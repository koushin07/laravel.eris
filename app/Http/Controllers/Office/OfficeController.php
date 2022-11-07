<?php

namespace App\Http\Controllers\Office;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\UnfinishTransaction;
use App\Models\Office;
use App\Models\IncidentReport;
use App\Models\BorrowingDetails;
use App\Http\Controllers\Controller;

class OfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        return inertia('AccountPage', [
            'reports' =>  IncidentReport::where([
                ['reciever', auth()->id()],
                ['filename', null],
                ['file_path', null]
                ])->count(),
            'status' => DB::select(
                "SELECT
                SUM(serviceable + unusable+ poor) AS total,
                        SUM(serviceable) AS serviceable,
                        SUM(unusable) AS unusable,
                        SUM(poor) AS poor
                      FROM equipment_details ed
                      JOIN equipment_owneds eo ON eo.id = ed.equipment_owner
                      JOIN offices o ON o.id = eo.office_id
                       WHERE o.id = :myid",
                [
                    'myid' => auth()->id(),
                ]
            )[0],
            'notification' =>auth()->user()->unreadNotifications()->count(),
            'unfinish' => UnfinishTransaction::where('owner', auth()->id())->count(),
            

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function show(Office $office)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function edit(Office $office)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Office $office)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function destroy(Office $office)
    {
        //
    }
}
