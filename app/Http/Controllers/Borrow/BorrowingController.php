<?php

namespace App\Http\Controllers\Borrow;

use App\Events\BorrowRequestRecieve;
use Illuminate\Http\Request;
use App\Services\BorrowingService;
use App\Models\Office;
use App\Models\BorrowingDetails;
use App\Models\Borrowing;
use App\Models\AssignOffice;
use App\Http\Requests\MTRequest;
use App\Http\Controllers\Controller;
use App\Events\NewMunicipalityTransaction;
use App\Events\TransactionConfirmed;
use App\Events\TransactionDenied;
use App\Models\BorrowDetail;
use App\Models\IncidentReport;
use App\Models\UnfinishTransaction;

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
            'unfinish' => UnfinishTransaction::select(['assign_offices.municipality', 'unfinish_transactions.*'])
                ->join('offices', 'offices.id', '=', 'unfinish_transactions.borrower')
                ->join('assign_offices', 'assign_offices.id', '=', 'offices.assign')
                ->where('owner', auth()->id())
                ->get(),

            'borrowings' => BorrowingDetails::select(
                [
                    'borrowing_details.id',
                    'borrowing_details.quantity',
                    'equipment.*',
                    'offices.name'
                ]
            )
                ->join('equipment_owneds', 'equipment_owneds.id', '=', 'borrowing_details.equipment_owned_id')
                ->join('equipment', 'equipment.id', 'equipment_owneds.equipment_id')
                ->join('borrowings', 'borrowings.id', '=', 'borrowing_details.borrowing_id')
                ->join('offices', 'offices.id', 'borrowings.borrower')
                ->where('equipment_owneds.office_id', auth()->id())
                ->get(),

            'reports' => IncidentReport::where('reciever', auth()->id()),

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Borrowing  $borrowing
     * @return \Illuminate\Http\Response
     */
    public function edit(Borrowing $borrowing)
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


        foreach ($request->municipalities as $id) {

            BorrowRequestRecieve::dispatch(Office::find($id), $request->equipment, $request->quantity);
        }
        return response()->noContent(200);
    }

    public function singleRequest($name, $id, $quantity)
    {

        BorrowRequestRecieve::dispatch(Office::find($id), $name, $quantity);
        return response()->noContent(200);
    }
}
