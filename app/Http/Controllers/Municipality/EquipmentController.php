<?php

namespace App\Http\Controllers\Municipality;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request as Req;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Auth\Events\Validated;
use Carbon\Carbon;
use App\Services\LocationService;
use App\Services\EquipmentService;
use App\Models\User;
use App\Models\Municipality;
use App\Models\EquipmentOwned;
use App\Models\EquipmentDetail;
use App\Models\EquipmentBorrow;
use App\Models\EquipmentAttribute;
use App\Models\Equipment;
use App\Models\BorrowingDetails;
use App\Models\AssignOffice;
use App\Http\Requests\UpdateEquipmentRequest;
use App\Http\Requests\CreateEquipmentRequest;
use App\Http\Controllers\Controller;
use App\Exports\InventoryExport;
use App\Events\NewEquipmentAdded;
use App\Exports\InventoryInvoice;

class EquipmentController extends Controller
{

    protected $equipmentService;


    public function __construct(EquipmentService $equipmentService)
    {
        $this->equipmentService = $equipmentService;
    }




    public function index()
    {


        return inertia('municipality/InventoryPage', [
            'equipments' => Equipment::select([
                'equipment.*',
                DB::raw('count(equipment_attributes.id) as attrs'),
                DB::raw('sum(equipment_details.serviceable) as available'),
                DB::raw('sum(equipment_details.unserviceable) as damages'),
            ])

                ->join('equipment_owneds', 'equipment_owneds.equipment_id', '=', 'equipment.id')
                ->join('equipment_details', 'equipment_details.equipment_owner', '=', 'equipment_owneds.id')
                ->join('offices', 'offices.id', '=', 'equipment_owneds.office_id')
                ->join('assign_offices', 'assign_offices.id', '=', 'offices.assign')
                ->join('equipment_attributes', 'equipment_attributes.id', '=', 'equipment_owneds.equipment_attrs')
                ->where('equipment_owneds.office_id', auth()->id())->orderBy('available', 'ASC')
                ->groupBy('name')
                ->when(Request::input('search'), function ($q, $search) {
                    $q->where('name', 'like', '%' . $search . '%');
                })
                ->paginate(10)->onEachSide(1),
            'filters' => Request::only(['search', 'status', 'owner']),
            'status' => DB::select(
                "SELECT
                SUM(serviceable + unserviceable + poor) AS total,
                        SUM(serviceable) AS serviceable,
                        SUM(unserviceable) AS unserviceable,
                        SUM(poor) AS poor
                      FROM equipment_details ed
                      JOIN equipment_owneds eo ON eo.id = ed.equipment_owner
                      JOIN offices o ON o.id = eo.office_id
                       WHERE o.id = :myid",
                [
                    'myid' => auth()->id(),
                ]
            )[0],
            'notification' => auth()->user()->unreadNotifications()->count(),

            'criticals' =>  EquipmentDetail::select([
                'equipment.name',
                DB::raw('sum(equipment_details.serviceable)'),
                'equipment_owneds.equipment_id as id'
            ])

                ->join('equipment_owneds', 'equipment_owneds.id', '=', 'equipment_details.equipment_owner')
                ->join('equipment', 'equipment.id', '=', 'equipment_owneds.equipment_id')->where('equipment_owneds.office_id', '=', auth()->id())
                ->orderBy('serviceable', 'asc')
                ->get()->groupBy('name')->map(function ($total) {
                    $sum =  $total->sum('serviceable');
                    if ($sum > 3) {
                        return $total->sum('serviceable');
                    }
                })->sort()->take(3),

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return inertia('municipality/FormPage');
    }


    public function store(CreateEquipmentRequest $request)
    {
        // dd($request);
        $request->validated();

        $this->equipmentService->insertData($request);
        // NewEquipmentAdded::dispatch();
        return redirect()->route('municipality.inventory.index');
    }


    public function show(Req $request, $id)
    {
       
        $equipment = Equipment::find($id);
        $owned = EquipmentOwned::select([
            'equipment_owneds.id',
            'equipment_attributes.id as attrs_id',
            'equipment_details.id as detail_id',
            'equipment_attributes.code',
            'equipment_attributes.asset_desc',
            'equipment_attributes.category',
            'equipment_attributes.unit',
            'equipment_attributes.model_number',
            'equipment_attributes.serial_number',
            'equipment_attributes.asset_id',
            'equipment_attributes.remarks',
            'equipment_details.serviceable',
            'equipment_details.poor',
            'equipment_details.unserviceable'
        ])
            ->join('equipment_details', 'equipment_details.equipment_owner', '=', 'equipment_owneds.id')
            ->join('equipment_attributes', 'equipment_attributes.id', '=', 'equipment_owneds.equipment_attrs')
            ->join('offices', 'offices.id', '=', 'equipment_owneds.office_id')
            ->join('assign_offices', 'assign_offices.id', '=', 'offices.assign')
            ->where('equipment_owneds.equipment_id', '=', $id)
            ->when(
                Request::input('status'),
                function ($q, $status) {
                    if ($status == 'Serviceable') {
                        $q->whereColumn('equipment_details.poor', '<=', 'equipment_details.serviceable')->whereColumn('equipment_details.unserviceable', '<=', 'equipment_details.serviceable');
                    }
                    if ($status == 'Poor') {
                        $q->whereColumn('equipment_details.poor', '>=', 'equipment_details.serviceable')->whereColumn('equipment_details.unserviceable', '<=', 'equipment_details.poor');
                    }
                    if ($status == 'Unusable') {
                        $q->whereColumn('equipment_details.poor', '<=', 'equipment_details.unserviceable')->whereColumn('equipment_details.unserviceable', '>=', 'equipment_details.serviceable');
                    }
                }
            );

        /* NOTE:
                ? get equipment borrow detials
                ! municipality most borrow
                ! number of returns and not return per municipality
                ! most reason(incident) equipment borrow
                !! all with DATES
             */
        $borrow = EquipmentBorrow::select([
            'equipment_borrows.id as eb_id',
            'equipment_borrows.equipment_id as eqip_id',
            'assign_offices.municipality',
            DB::raw(" CONCAT(offices.lastname , ' ' , offices.firstname , ' ' , offices.middlename, ' ' ,offices.suffix) as borrower"),
            DB::raw("borrow_histories.created_at as date_returned"),
            'borrowing_details.created_at as date_borrowed',
            DB::raw('sum(borrow_histories.serviceable) as serviceable'),
            DB::raw('sum(borrow_histories.unserviceable) as unserviceable'),
            DB::raw('sum(borrow_histories.poor) as poor'),
            DB::raw('sum(borrow_histories.serviceable) + sum(borrow_histories.unserviceable) + sum(borrow_histories.poor) as total_return '),
            DB::raw('sum(equipment_borrows.acquired) as total_borrow'),
            DB::raw('count(assign_offices.municipality) as frequent')
        ])
            ->join('borrowing_details', 'borrowing_details.id', '=', 'equipment_borrows.detail_id')
            ->join('borrowings', 'borrowings.id', '=', 'borrowing_details.borrowing_id')
            ->join('offices', 'offices.id', '=', 'borrowings.borrower')

            ->join('assign_offices', 'assign_offices.id', '=', 'offices.assign')
            ->leftJoin('borrow_histories', 'borrow_histories.borrowing_detail_id', '=', 'borrowing_details.id')
            ->where('equipment_borrows.borrowee', auth()->id())->where('equipment_borrows.equipment_id', $id)->groupBy(['assign_offices.municipality'])->orderBy('frequent', 'DESC');

        $tracks = new Collection();
        if (!empty($borrow->first())) {


            $tracks->put('mean',  collect([
                ['total_of_borrow' => $borrow->get()->sum('total_borrow')],
                ['total_of_return' => $borrow->get()->sum('total_return')],
                ['total_serviceable' => $owned->get()->sum('serviceable')],
                ['total_unserviceable' => $owned->get()->sum('unserviceable')],
                ['total_poor' => $owned->get()->sum('poor')],
            ]));
            $tracks->put('mode', collect([
                ['frequent_municipality' => $borrow->first()->only('frequent', 'municipality')]
            ]));
            $tracks->put('min', collect([
                ['less_return' => $borrow->get()->sortBy('total_return')->first()]
            ]));
        }


        return inertia('EquipmentBackTrack', [
            'equipments' =>  $equipment,
            'owned' => $owned->paginate(10)->onEachSide(1),
            'borrow' => $borrow->paginate(10)->onEachSide(1),
            'tracks' => $tracks,

        ]);
    }

    public function update(UpdateEquipmentRequest $request, $id)
    {
        // dd($request);
        $request->validated();
        // dd($request->validated());
        DB::transaction(function () use ($request, $id) {

            $owned = EquipmentOwned::find($id);
            $attrs = EquipmentAttribute::find($request->attrs);
            // $equipment = Equipment::find($owned->equipment_id);
            // $attrs = EquipmentAttribute::find($id);
            // $equipment = Equipment::find($attrs->equipment_id);
            $attrs->update([
                'code' => $request->code,
                'asset_desc' => $request->asset_desc,
                'category' => $request->category,
                'unit' => $request->unit,
                'model_number' => $request->model_number,
                'serial_number' => $request->serial_number,
                'asset_id' => $request->asset_id,
                'remarks' => $request->remarks,
            ]);
            $detail = EquipmentDetail::find($request->detail_id);
            $detail->update([
                'serviceable' => $request->serviceable,
                'poor' => $request->poor,
                'unserviceable' => $request->unserviceable
            ]);
            // $equipment->update([

            //     'name' => $request->name,
            // ]);
        });

        // $equipment->update($request->validated());
        return redirect()->back();
    }

    public function getEquipment($name)
    {

        abort_unless(auth()->check(), 403);

        return EquipmentOwned::query()
            ->join('equipment', 'equipment_owneds.equipment_id', 'equipment.id')
            ->join('offices', 'offices.id', 'equipment_owneds.office_id')
            ->join('assign_offices', 'assign_offices.id', 'offices.assign')
            ->join('equipment_details', 'equipment_details.equipment_owner', 'equipment_owneds.id')
            ->where('assign_offices.municipality', $name)
            ->get();

        return Equipment::where([['municipality_id', '=', $id], ['status', '=', 'serviceable']])->get();
    }

    public function equipmentList($name)
    {
        abort_unless(auth()->check(), 403);

        return Equipment::where('equipment_name', '=', $name)->get();
    }

    public function municipalityList(Req $request, LocationService $locationService)
    {
        return response()->json($locationService->getDistance($request->equipments, $request->provinces));
    }



    public function equipmentAttr(Req $request)
    {

        $validated = $request->validate([
            'id' => 'required',
            'equipment_name' => 'required',
            'serial_number' => ['required', 'numeric'],
            'unit' => ['required', 'numeric'],
            'code' => 'required',
            'model_number' => ['required', 'numeric'],
            'asset_id' => ['required', 'numeric'],
            'quantity' => ['required', 'numeric'],
        ]);

        $status = $this->equipmentService->fulfillTransaction($request);

        if ($status == 200) {
            return response()->noContent($status);
        }

        if ($status == 400) {
            return response()->noContent($status);
        }
    }

    public function invoice(Request $request)
    {
        $assign = AssignOffice::select('assign_offices.municipality')->join('offices', 'offices.assign', '=', 'assign_offices.id')->where('offices.id', '=', auth()->id())->first();
        return Excel::download(new InventoryInvoice,  $assign->municipality . '-' . Carbon::now()->format('Y-m-d') . '-Inventory' . '.xlsx');
    }

    public function summary()
    {
    }
}
