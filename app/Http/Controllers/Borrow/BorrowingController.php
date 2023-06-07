<?php

namespace App\Http\Controllers\Borrow;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Services\TempTable;
use App\Services\BorrowingService;
use App\Rules\AttributeExistRule;
use App\Models\UnfinishTransaction;
use App\Models\Role;
use App\Models\Office;
use App\Models\IncidentReport;
use App\Models\EquipmentBorrow;
use App\Models\EquipmentAttribute;
use App\Models\Equipment;
use App\Models\BorrowingDetails;
use App\Models\Borrowing;
use App\Models\BorrowHistory;
use App\Models\BorrowDetail;
use App\Models\AssignOffice;

use App\Models\Approval;
use App\Http\Requests\MTRequest;
use App\Http\Controllers\Controller;
use App\Events\TransactionDenied;
use App\Events\TransactionConfirmed;
use App\Events\NewMunicipalityTransaction;
use App\Events\BorrowRequestRecieve;
use App\Events\NotifyProvince;
use App\Events\Reconfirmed;
use App\Models\EquipmentDetail;
use App\Models\EquipmentOwned;

class BorrowingController extends Controller
{

    public function index()
    {
        return inertia('municipality/TransactionPage', [
            'notifications' => auth()->user()->unreadNotifications,
            'unfinish' =>  BorrowingDetails::select(['equipment.name', 'borrowing_details.id', 'assign_offices.municipality'])
                ->where([
                    ['borrowings.owner', auth()->id()],
                    ['borrowing_details.equipment_attrs', null]
                ])
                ->join('borrowings', 'borrowings.id', '=', 'borrowing_details.borrowing_id')
                ->join('equipment', 'equipment.id', '=', 'borrowing_details.equipment_id')
                ->join('offices', 'offices.id', 'borrowings.borrower')
                ->join('assign_offices', 'assign_offices.id', '=', 'offices.assign')
                ->get(),

            'borrowings' => BorrowingDetails::select(
                [
                    'borrowing_details.id',
                    'borrowing_details.quantity',
                    'equipment.name',
                    'offices.name'
                ]
            )
                ->join('equipment', 'equipment.id', '=', 'borrowing_details.equipment_id')
                ->join('equipment_attributes', 'equipment_attributes.id', '=', 'borrowing_details.equipment_attrs')
                ->join('borrowings', 'borrowings.id', '=', 'borrowing_details.borrowing_id')
                ->join('offices', 'offices.id', '=', 'borrowings.borrower')
                ->where('borrowings.owner', auth()->id())
                ->get(),

            'reports' => IncidentReport::with('sender')->where([
                ['reciever', auth()->id()],
                ['filename', null],
                ['file_path', null]
            ])->get(),

        ]);
    }

    public function create()
    {
        return inertia('localTransaction', [
            'municipalities' => AssignOffice::query()->when(request()->input('province'), function ($q, $name) {
                $q->where('province', $name);
            })->get(),
            'provinces' => AssignOffice::get(['id', 'province'])

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MTRequest $request, BorrowingService $BService)
    {
        $request->validated();

        $BService->insertData($request);
        $office = Office::where('assign', $request->owner)->first();
        NewMunicipalityTransaction::dispatch($office);
        redirect('/borrowing/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Borrowing  $borrowing
     * @return \Illuminate\Http\Response
     */
    public function show(Borrowing $borrowing)
    {
    }


    public function edit(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Borrowing  $borrowing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Borrowing $borrowing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Borrowing  $borrowing
     * @return \Illuminate\Http\Response
     */
    public function destroy(Borrowing $borrowing)
    {
    }
    public function accept($id)
    {
        abort_unless(auth()->check(), 403);

        $BD = BorrowingDetails::find($id);
        $borrow = Borrowing::find($BD->borrowing_id);
        $borrow->confirmation = 1;
        $borrow->Save();

        TransactionConfirmed::dispatch(Borrowing::find($id));
        return response()->noContent();
    }
    public function deny($id)
    {

        abort_unless(auth()->check(), 403);
        $borrow = Borrowing::find($id);
        $borrow->confirmation = true;
        $borrow->Save();
        TransactionDenied::dispatch(Borrowing::find($id));
        return response()->noContent();
    }

    public function fetchEquip($id)
    {
        return
            EquipmentBorrow::select(
                'equipment.name',
                DB::raw(" CONCAT(offices.lastname , ' ' , offices.firstname , ' ' , offices.middlename, ' ' ,offices.suffix) as owner"),
                'assign_offices.municipality',
                'offices.contact',
                'offices.address',
                'borrowing_details.incident',
                'borrowing_details.incident_summary',
                'equipment_borrows.quantity',
                'equipment_borrows.acquired',
                'equipment_borrows.status',
                'borrowing_details.id',
            )
            ->where('detail_id', $id)
            ->join('borrowing_details', 'borrowing_details.id', 'equipment_borrows.detail_id')
            ->join('borrowings', 'borrowings.id', '=', 'borrowing_details.borrowing_id')
            ->join('approvals', 'approvals.id', '=', 'borrowings.approval_id')
            ->join('offices', 'offices.id', '=', 'borrowings.owner')
            ->join('assign_offices', 'assign_offices.id', '=', 'offices.assign')
            ->join('equipment', 'equipment.id', '=', 'equipment_borrows.equipment_id')->get();




        // $equipment = Equipment::where('name', $request->equipment)->first();
        // foreach ($request->municipalities as $id) {

        //     BorrowRequestRecieve::dispatch(Office::find($id), $equipment, $request->quantity);
        // }
        // return response()->noContent(200);
        // @testFunction testBorrowingControllerSingleRequest
    }

    public function singleRequest(Request $request)
    {
        // dd($request->date);
        $request->validate([
            'equipment' => 'required',
            'municipality_id' => 'required',
            'quantity' => 'required',
            'incidents' => 'required',
            'incident_summary' => 'string'
        ]);
        DB::transaction(function () use ($request) {


            $approval = Approval::create([
                'borrowee' => auth()->id(),
                'status' => 'pending',
            ]);

            $borrowing = Borrowing::create([
                'approval_id' => $approval->id,
                'owner' => $request->municipality_id,
            ]);
            if ($request->date) {
                $details = BorrowingDetails::create([
                    'incident_id' => 'IN-' . rand(pow(10, 5 - 1), pow(10, 5) - 1),
                    'borrowing_id' => $borrowing->id,
                    'incident' => $request->incidents,
                    'incident_summary' => $request->incident_summary,
                    'created_at' => Carbon::parse($request->date)

                ]);
            } else {
                $details = BorrowingDetails::create([
                    'incident_id' => 'IN-' . rand(pow(10, 5 - 1), pow(10, 5) - 1),
                    'borrowing_id' => $borrowing->id,
                    'incident' => $request->incidents,
                    'incident_summary' => $request->incident_summary,


                ]);
            }

            $equipment = Equipment::where('name', $request->equipment)->first();
            $equipment_B = EquipmentBorrow::create([
                'equipment_id' => $equipment->id,
                'detail_id' => $details->id,
                'quantity' =>  $request->quantity
            ]);
        });
        BorrowRequestRecieve::dispatch(Office::find($request->municipality_id));
        return redirect('/municipality/request');
    }
    public function reconNotif()
    {
        return EquipmentBorrow::query()
            ->join('borrowing_details', 'borrowing_details.id', '=', 'equipment_borrows.detail_id')
            ->join('borrowings', 'borrowings.id', '=', 'borrowing_details.borrowing_id')
            ->join('approvals', 'approvals.id', '=', 'borrowings.approval_id')
            ->join('offices', 'offices.id', '=', 'approvals.borrowee')
            ->join('assign_offices', 'assign_offices.id', '=', 'offices.assign')
            ->groupBy('incident')
            ->where('borrowings.owner', auth()->id())  ->where('equipment_borrows.status', '=', 'pending')->count();

       
    }

    public function updateRequest(Request $request)
    {
        // dd($request);
        $equipment = Equipment::where('name', $request->equipment)->first();
        EquipmentBorrow::create([
            'equipment_id' => $equipment->id,
            'detail_id' => $request->detail,
            'quantity' => $request->quantity,
            'borrowee' =>$request->municipality_id,
        ]);
        $detail = BorrowingDetails::find($request->detail);
        $borrowings = Borrowing::find($detail->borrowing_id);

        BorrowRequestRecieve::dispatch(Office::find($request->municipality_id));
        return back();
    }

    public function confirmQuantity(Request $request)
    {
        // dd($request);
        $eb = EquipmentBorrow::find($request->transaction['id']);

        $eb->acquired = $request->quantity;
        // Office::find($request->transaction['office_id']);
        $eb->save();

        $municipality = AssignOffice::find(auth()->user()->assign);
        $province = AssignOffice::where('province', $municipality->province)->whereNull('municipality')->first();
        // NotifyProvince::dispatch(Office::where('assign', $province->id)->first());
        // dd(Office::find($request->transaction['office_id']));
        Reconfirmed::dispatch(Office::find($request->transaction['office_id']));

        return back();
    }

    public function partial(Request $request)
    {
        return inertia('municipality/PartialsPage', [

            'unfinish' => EquipmentBorrow::select(
                'borrowing_details.id',
                'offices.firstname',
                'offices.lastname',
                'offices.middlename',
                'offices.suffix',
                'offices.address',
                'offices.contact',
                'assign_offices.municipality',
                'borrowing_details.incident',
                'borrowing_details.created_at',


            )->addSelect([
                'pendings' => EquipmentBorrow::whereColumn('borrowing_details.id', 'equipment_borrows.detail_id')
                    ->select(DB::raw('count(equipment_borrows.status)'))->where('equipment_borrows.status', '=', 'pending')
            ])->addSelect([
                'authorize_quantity' => EquipmentBorrow::whereColumn('borrowing_details.id', 'equipment_borrows.detail_id')
                    ->select(DB::raw('sum(equipment_borrows.authorize_quantity)'))
            ])->addSelect([
                'acquired' => EquipmentBorrow::whereColumn('borrowing_details.id', 'equipment_borrows.detail_id')
                    ->select(DB::raw('sum(equipment_borrows.acquired)'))
            ])->addSelect([
                'count' => Equipment::whereColumn('equipment_borrows.equipment_id', 'equipment.id')
                    ->select(DB::raw('count(equipment.name)'))
            ])
                ->when($request->input('date'), function ($q, $date) {
                    $q->whereDate('borrowing_details.created_at', '=', Carbon::parse($date)->addDay()->format('Y-m-d'));
                })
                ->when($request->input('filter'), function ($q, $filter) {
                    $q->where('borrowing_details.incident', '=', $filter);
                })

                ->join('borrowing_details', 'borrowing_details.id', '=', 'equipment_borrows.detail_id')
                ->join('borrowings', 'borrowings.id', '=', 'borrowing_details.borrowing_id')
                
                ->join('offices', 'offices.id', '=', 'borrowings.borrower')
                ->join('assign_offices', 'assign_offices.id', '=', 'offices.assign')
                ->groupBy('incident')
                ->where('equipment_borrows.borrowee', auth()->id())->latest()->paginate(10)->onEachSide(1)
        ]);
    }
    public function showPartial(Request $request, $id)
    {
        // dd($id);
        return inertia('municipality/ShowPartialPage', [
            'equipments' =>  EquipmentBorrow::select(
                'equipment.name',
                'offices.lastname',
                'offices.firstname',
                'offices.middlename',
                'offices.suffix',
                'assign_offices.municipality',
                'offices.contact',
                'offices.address',
                'borrowing_details.id as detail_id',
                'borrowing_details.incident',
                'borrowing_details.incident_summary',
                'equipment_borrows.authorize_quantity',
                'equipment_borrows.quantity',
                'borrowings.reason',
                'equipment_borrows.quantity',
                'equipment_borrows.acquired',
                'equipment_borrows.status',
                'equipment_borrows.status',
                'equipment_borrows.id',
                'equipment_borrows.created_at'
            )
                ->where('equipment_borrows.detail_id', $id)
                ->join('borrowing_details', 'borrowing_details.id', 'equipment_borrows.detail_id')
                ->join('borrowings', 'borrowings.id', '=', 'borrowing_details.borrowing_id')
                
                ->join('offices', 'offices.id', '=', 'borrowings.borrower')
                ->join('assign_offices', 'assign_offices.id', '=', 'offices.assign')
                ->join('equipment', 'equipment.id', '=', 'equipment_borrows.equipment_id')
                ->where('equipment_borrows.borrowee', auth()->id())

                ->get(),
            'incident' => $request->incident,
            'summary' => $request->summary,
            'detail_id' => $id,
            'equipments_drowpdown' => DB::table('equipment')
                ->join('equipment_owneds', 'equipment_owneds.equipment_id', '=', 'equipment.id')
                ->whereNot('equipment_owneds.office_id', '=', auth()->id())
                ->select('equipment.id', 'name')
                ->groupBy('name')->get(),
            'provinces' => Office::select('assign_offices.province')
                ->join('assign_offices', 'assign_offices.id', '=', 'offices.assign')
                ->join('roles', 'roles.id', '=', 'offices.role_id')->where('roles.role_type', Role::PROVINCE)->get()
        ]);
    }

    public function UpdatePartial(Request $request, $id)
    {
        // dd($request);

        $request->validate([
            'attrs' => new AttributeExistRule,
        ]);

        DB::transaction(function () use ($request, $id) {
            $eb = EquipmentBorrow::find($id);
            $eb->status = 'return';
            // dd($id);
            $attrs =   $attr = EquipmentAttribute::where([

                ['code', $request->attrs['code']],
                ['category', $request->attrs['category']],
                ['unit', $request->attrs['unit']],
                ['model_number', $request->attrs['model_number']],
                ['serial_number', $request->attrs['serial_number']],
                ['asset_id', $request->attrs['asset_id']],
            ])->first();
            // dd($eb);

            $owned = EquipmentOwned::where([['equipment_attrs', $attrs->id], ['equipment_id', $eb->equipment_id]])->first();
            // dd($eb->equipment_attrs, $atts);
            if (!is_null($owned)) {
                $eb->equipment_attrs = $attrs->id;
                $eb->save();
                // dd($request->status['serviceable'], $request->status['poor'], $request->status['unserviceable']);
                $detail = BorrowingDetails::find($eb->detail_id);
                $history = BorrowHistory::create([
                    'return_at' => Carbon::now(),
                    'borrowing_detail_id' => $detail->id,
                    'serviceable' => $request->status['serviceable'],
                    'poor' => $request->status['poor'],
                    'unserviceable' => $request->status['unserviceable'],
                ]);
            }

            $equip_det = EquipmentDetail::where('equipment_owner', $owned->id)->first();
            $equip_det->serviceable = $equip_det->serviceable - $request->status['unserviceable'];
            // $equip_det->unserviceable = $equip_det->unserviceable - $request->status['unserviceable'];
            // $equip_det->poor = $equip_det->poor - $request->status['poor'];
            $equip_det->save();
        }, 2);
    }

    public function borrowAttrs($id)
    {
        /* NOTE:
            ! $id is equipment_id
         */

        return inertia('municipality/BorrowAttrs', [
            'attrs' => EquipmentBorrow::select(['equipment_attributes.*'])
                ->join('equipment_attributes', 'equipment_attributes.id', '=', 'equipment_borrows.equipment_attrs')
                ->join('borrowing_details', 'borrowing_details.id', '=', 'equipment_borrows.detail_id')
                ->join('borrowings', 'borrowings.id', '=', 'borrowing_details.borrowing_id')
                ->where('equipment_borrows.equipment_id', '=', $id)
                ->get(),
        ]);
    }
}
