<?php

namespace App\Http\Controllers;

use App\Events\IncidentReportDemand;
use App\Events\ReportSubmitted;
use App\Models\BorrowingDetails;
use App\Models\IncidentReport;
use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IncidentReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return inertia('municipality/ReportPage', [
            'reports' => IncidentReport::with('sender')->where([
                ['reciever', auth()->id()],
                ['filename', null],
                ['file_path', null]
            ])->get(),
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
        $request->validate([

            'docs' => 'mimes:pdf,docx,docs|max:2048',
        ]);




        if ($request->hasFile('docs')) {
            $doc_path = $request->file('docs')->store('public');
            $file = $request->file('docs');

            $incident =  IncidentReport::find($request->id);
            if ($incident) {
                $incident->filename = $file->getClientOriginalName();
                $incident->file_path = $doc_path;
                $incident->save();
            }
            ReportSubmitted::dispatch(Office::find($incident->sender));
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
        $report = IncidentReport::findOrFail($id);
        $headers = array(
            'Content-Type: application/pdf',
        );
        $cut = ltrim($report->file_path, "public/");
        $path = "../public/storage/" . $cut;

        return response()->file($path, $headers);
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
        $request->validate([
            'docs' => ['mimes:pdf,docx,docs|max:2048', 'required'],
        ]);

        if ($request->hasFile('docs')) {
            $doc_path = $request->file('docs')->store('public');

            $file = $request->file('docs');

            $incident =  IncidentReport::find($id);
            dd($incident);
            if ($incident) {

                $incident->filename = $file->getClientOriginalName();
                $incident->file_path = $doc_path;
                $incident->save();
            }
        }
        return;
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
    public function downloadFile($id)
    {
        $report = IncidentReport::findOrFail($id);
        $headers = array(
            'Content-Type: application/pdf',
        );
        return Storage::download($report->file_path, $report->filename, $headers);
    }
}
