<?php

namespace App\Http\Controllers\Borrow;

use App\Events\NotifyProvince;
use App\Events\TransactionConfirmed;
use App\Events\TransactionDenied;
use App\Http\Controllers\Controller;
use App\Models\Office;
use App\Models\UnfinishTransaction;
use Illuminate\Http\Request;

class UnfinishTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function accepted(Request $request)
    {

        $unfinish = UnfinishTransaction::create([
            'borrower' => $request->borrower_id,
            'owner' => auth()->id(),
            'quantity' => $request->quantity,
            'equipment' => $request->equipment
        ]);
        auth()->user()->unreadNotifications->where('id', $request->notif_id)->markAsRead();
        TransactionConfirmed::dispatch(Office::find($request->borrower_id), $unfinish);
        $province = auth()->user()->assign_office()->province;
        NotifyProvince::dispatch(Office::where([['name', $province], ['assign', 2]])->firt(), $unfinish->equipment);
        return response()->noContent();
    }
    public function deny(Request $request)
    {

        auth()->user()->unreadNotifications->where('id', $request->notif_id)->markAsRead();

        TransactionDenied::dispatch(Office::find($request->borrower_id), $unfinish);
        return response()->noContent();
    }
}
