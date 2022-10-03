<?php

namespace App\Http\Controllers\Transactions;

use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\Equipment;
use App\Http\Requests\Transactions\CrossTransactionRequest;
use App\Http\Controllers\Controller;
use App\Models\Municipality;
use App\Services\CrossTransactionService;

class CrossTransactionController extends Controller
{
    protected $CTService;

    public function __construct(CrossTransactionService $crossTransactionService)
    {
        $this->CTService = $crossTransactionService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
     
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cross-transaction.create', [
            'municipalities' => Municipality::get(['id', 'municipality_name']),
            'equipments' => Equipment::where('status', 'Serviceable')->groupBy('equipment_name')->get('equipment_name'),
          ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CrossTransactionRequest $request)
    {
        if ($this->CTService->isEquipmentAvailable( $request->validated())) {
            return back()->with('success', 'Request Sent');
        }
       return back()->with('error', 'equipment not available');
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
