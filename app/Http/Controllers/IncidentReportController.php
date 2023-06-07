<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Office;
use App\Models\IncidentReport;
use App\Models\EquipmentBorrow;
use App\Models\Equipment;
use App\Models\BorrowingDetails;
use App\Models\Borrowing;
use App\Models\AssignOffice;
use App\Models\Approval;
use App\Events\ReportSubmitted;
use App\Events\IncidentReportDemand;

class IncidentReportController extends Controller
{

    public function index()
    {
        return inertia('municipality/ReportPage', [
            'reports' => BorrowingDetails::select(
                'borrowing_details.file_path',
                'borrowing_details.filename',
                'approvals.borrowee as borrower',
                'borrowing_details.INC_submitted_at as submitted_at',
                'borrowing_details.incident',
                'borrowing_details.incident_summary',
                'borrowing_details.id',
            )
                ->join('borrowings', 'borrowings.id', '=', 'borrowing_details.borrowing_id')
                ->join('approvals', 'approvals.id', '=', 'borrowings.approval_id')
                ->where('approvals.borrowee', auth()->id())
                ->whereNull('borrowing_details.filename')
                ->whereNull('borrowing_details.file_path')->get()
        ]);
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([

            'docs' => 'mimes:pdf,docx,docs|max:2048',
        ]);


        // dd($request);

        if ($request->hasFile('docs')) {
            $doc_path = $request->file('docs')->store('public');
            $file = $request->file('docs');

            $incident =  BorrowingDetails::find($request->id);
            if ($incident) {
                $incident->filename = $file->getClientOriginalName();
                $incident->file_path = $doc_path;
                $incident->INC_submitted_at = Carbon::now();
                $incident->save();
            }
            // ReportSubmitted::dispatch(Office::find($incident->sender));
        }
        return redirect('/municipality/request');
    }


    public function show($id)
    {
        $report = BorrowingDetails::findOrFail($id);
        // $headers = array(
        //     'Content-Type: application/pdf',
        // );

        $cut = ltrim($report->file_path, "public/");
        // dd($cut, $report);

        $path = "../public/storage/" . $cut;

        return response()->file($path);
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


    public function destroy($id)
    {
        $incident = BorrowingDetails::find($id);
        DB::transaction(function () use ($incident) {

            if (Storage::exists($incident->file_path)) {
                Storage::delete($incident->file_path);
                $incident->filename = null;
                $incident->file_path = null;
                $incident->INC_submitted_at = null;
                $incident->save();
            }
        }, 2);
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
        $report = BorrowingDetails::findOrFail($id);
        $headers = array(
            'Content-Type: application/pdf',
        );
        return Storage::download($report->file_path, $report->filename, $headers);
    }

    public function archive(Request $request)
    {
        if ($request->input('municipality')) {
            dd($request->input('municipality'));
        }
        $myMuni = AssignOffice::find(auth()->user()->assign);
        return inertia('ArchivePage', [
            'provinces' => DB::table('assign_offices')->select()->whereNull('municipality')->get(),
            'incidents' => BorrowingDetails::select([
                'borrowing_details.id',
                'borrowing_details.incident',
                'assign_offices.municipality',
                'borrowing_details.filename',
                'borrowing_details.file_path',
                'borrowing_details.INC_submitted_at'
            ])
                ->join('borrowings', 'borrowings.id', '=', 'borrowing_details.borrowing_id')
                ->join('approvals', 'approvals.id', '=', 'borrowings.approval_id')
                ->join('offices', 'offices.id', '=', 'approvals.borrowee')
                ->join('assign_offices', 'assign_offices.id', '=', 'offices.assign')
                ->where('assign_offices.municipality', $myMuni->municipality)
                ->whereNotNull(['assign_offices.municipality', 'borrowing_details.filename'])
                ->when($request->input('date'), function ($q, $date) {
                    $q->whereDate('borrowing_details.created_at', '=', Carbon::parse($date)->addDay()->format('Y-m-d'));
                })

                ->paginate(8)
        ]);
    }

    public function newIncident(Request $request)
    {
        // dd($request);
        $request->validate([
            'incidents' => 'required',
            'incident_summary' => 'string'
        ]);
        // dd($request->date);
      

        $borrowing = Borrowing::create([
            'borrower' => auth()->id(),
        ]);
        $details = BorrowingDetails::create([
            'incident_id' => 'IN-' . rand(pow(10, 5 - 1), pow(10, 5) - 1),
            'borrowing_id' => $borrowing->id,
            'incident' => $request->incidents,
            'incident_summary' => $request->incident_summary,
            'created_at' => Carbon::parse($request->date)

        ]);
        // dd($details);
        // return redirect('/municipality/request/'. $details->id);
        return back();
    }
}
