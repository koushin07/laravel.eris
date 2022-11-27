<?php

namespace App\Http\Controllers\Borrow;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Services\BorrowingService;
use App\Models\UnfinishTransaction;
use App\Models\Office;
use App\Models\IncidentReport;
use App\Models\Equipment;
use App\Models\BorrowingDetails;
use App\Models\Borrowing;
use App\Models\BorrowDetail;
use App\Models\AssignOffice;
use App\Http\Requests\MTRequest;
use App\Http\Controllers\Controller;
use App\Events\TransactionDenied;
use App\Events\TransactionConfirmed;
use App\Events\NewMunicipalityTransaction;
use App\Events\BorrowRequestRecieve;
use App\Models\Approvals;
use App\Models\EquipmentBorrow;
use App\Services\TempTable;

class BorrowingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        //
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

    public function requestAll(Request $request)
    {

        $equipment = Equipment::where('name', $request->equipment)->first();
        foreach ($request->municipalities as $id) {

            BorrowRequestRecieve::dispatch(Office::find($id), $equipment, $request->quantity);
        }
        return response()->noContent(200);
    }

    public function singleRequest(Request $request)
    {
 
        $request->validate([
            'equipment' => 'required',
            'municipality_id' => 'required',
            'quantity'=> 'required',
            'incidents' => 'required',
            'incident_summary' => 'string'
        ]);
      
        Approvals::create([]);
        
        // DB::transaction(function () use ($request) {
        //     $borrowing = Borrowing::create([
        //         'borrower' => auth()->id(),
        //         'owner' => $request->municipality_id,
        //     ]);
        //     $equipment = Equipment::where('name', $request->equipment)->first();
           
        //     $details = BorrowingDetails::create([
        //         'borrowing_id' => $borrowing->id,            
        //         'incident' => $request->incidents,
        //         'quantity' =>  $request->quantity
        //     ]);
        //     $equipment_B = EquipmentBorrow::create([
        //         'equipment_id' => $equipment->id,
        //         'detail_id'=> $details->id,
        //     ]);
        // });
        BorrowRequestRecieve::dispatch(Office::find($request->municipality_id), $request->equipment, $request->quantity, $request->incidents, $request->person);
        return redirect('/municipality/request');
    }
    public function notif()
    {
        
        return Borrowing::join('borrowing_details', 'borrowing_details.borrowing_id', '=', 'borrowings.id')
        ->where('borrowings.owner', '=', auth()->id())
        ->where('borrowing_details.status', '=', 'pending')->count();
    }
}
