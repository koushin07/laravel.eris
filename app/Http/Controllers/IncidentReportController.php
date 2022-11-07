<?php

namespace App\Http\Controllers;

use App\Events\IncidentReportDemand;
use App\Models\BorrowingDetails;
use App\Models\IncidentReport;
use App\Models\Office;
use Illuminate\Http\Request;

class IncidentReportController extends Controller
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
        $request->validate([

            'docs' => 'mimes:pdf,docx,docs|max:2048',
        ]);


        $rddrmc = Office::where('role_id', 3)->first();

        if ($request->hasFile('docs')) {
            $doc_path = $request->file('docs')->store('docs');
            $file = $request->file('docs');

          $incident =  IncidentReport::create([
                'reciever' => $rddrmc->id,
                'sender' => auth()->id(),
                'filename' => $file->getClientOriginalName(),
                'file_path' => $doc_path
            ]);
            $details = BorrowingDetails::find($request->details_id);
            $details->incident_report = $incident->id;
            $details->save();
        }
        return;
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
    public function request(Request $request)
    {
        $request->validate([
            'assign' => 'required',
            'reason' => 'required'
        ]);

        IncidentReport::create([
            'reciever' => $request->assign,
            'reason' => $request->reason,
            'sender' => auth()->id()
        ]);

        IncidentReportDemand::dispatch(Office::find($request->assign));
        return;
    }
}
