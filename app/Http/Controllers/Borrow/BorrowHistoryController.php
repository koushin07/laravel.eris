<?php

namespace App\Http\Controllers\Borrow;

use App\Http\Controllers\Controller;
use App\Models\BorrowHistory;
use App\Models\Borrowing;
use App\Services\HistoryService;
use Illuminate\Http\Request;

class BorrowHistoryController extends Controller
{

    protected $history;
    public function __construct(HistoryService $historyService)
    {
        $this->history = $historyService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        
        return inertia('municipality/Transactions/HistoricalPage', [
            'histories' => $this->history->fetchTransaction($request, $request->input('load')), 
            
            'filters' => $request->only('search'),
        ]);
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
        BorrowHistory::create([
            'borrowing_detail_id' => $request->id,
            'is_return' => true,
            'serviceable' => $request->serviceable,
            'unserviceable' => $request->unserviceable,
            'poor' => $request->poor
        ]);
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
}
