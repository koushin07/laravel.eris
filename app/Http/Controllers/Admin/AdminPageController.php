<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Office;
use App\Models\IncidentReport;
use App\Models\BorrowingDetails;
use App\Models\Borrowing;
use App\Models\BorrowHistory;
use App\Http\Controllers\Controller;

class AdminPageController extends Controller
{
    public function dashboard()
    {

        return inertia('Admin/DashboardPage', [
            'data' => DB::table('offices')
                ->select(
                    DB::raw('count(name) as total'),
                    DB::raw('month(created_at) as months'),
                )
                ->groupBy('months')
                ->whereYear('created_at', date('Y'))
                ->orderBy('months', 'asc')
                ->get(),
        ]);
    }

    public function consolidated(Request $request)
    {

        return inertia('Admin/InventoryPage', [
            'equipments' => DB::table('equipment')->select(
                [
                    'equipment.name',
                    'equipment_attributes.*',
                    'offices.name as owner',
                    'equipment_details.serviceable',
                    'equipment_details.unusable',
                    'equipment_details.poor',
                ]
            )
                ->join('equipment_owneds', 'equipment_owneds.equipment_id', '=', 'equipment.id')
                ->join('equipment_details', 'equipment_details.equipment_owner', '=', 'equipment_owneds.id')
                ->join('equipment_attributes', 'equipment_attributes.equipment_id', '=', 'equipment.id')
                ->join('offices', 'offices.id', '=', 'equipment_owneds.office_id')
                ->when(
                    $request->input('search'),
                    function ($q, $search) {
                        $q->where('equipment.name', 'like', '%' . $search . '%');
                    }
                )
                ->paginate(5)->onEachSide(1)->withQueryString(),

            'filters' => $request->only(['search', 'status', 'owner'])
        ]);
    }
    public function report(Request $request)
    {
        // dd(
        //     IncidentReport::select('incident_reports.id', 'incident_reports.filename', DB::raw('sender.name as sender'), DB::raw('sender.name as reciever'))
        //         ->join('offices as sender', DB::raw('sender.id'), '=', DB::raw('incident_reports.sender'))
        //         ->join('offices as reciever', DB::raw('reciever.id'), '=', DB::raw('incident_reports.reciever'))
        //         ->paginate()
        // );
        return inertia('Admin/ReportPage', [
            'reports' =>   IncidentReport::select('incident_reports.id', 'incident_reports.filename', DB::raw('sender.name as sender'), DB::raw('reciever.name as reciever'))
            ->join('offices as sender', DB::raw('sender.id'), '=', DB::raw('incident_reports.sender'))
            ->join('offices as reciever', DB::raw('reciever.id'), '=', DB::raw('incident_reports.reciever'))
            ->whereNotNull('incident_reports.filename')
            ->when(
                $request->input('search'),
                function ($q, $search) {
                    $q->where('sender.name', 'like', '%' . $search . '%');
                }
            )
            ->paginate(5)->onEachSide(1)->withQueryString(),
            'filters' => $request->only('search')

        ]);
    }

    // public function equipmentRequest()
    // {
    //     dd(
    //         Borrowing::select(d')
    //         ->join('borrowing_details', 'borrowing_details.borrowing_id', '=', 'borrowing.id')
    //         ->join('offices as owner', DB::raw('owner.id'), '=', DB::raw('borrowing.owner'))
    //         ->join('offices as borrower', DB::raw('borrower.id'), '=', DB::raw('borrowing.borrower'))
    //         ->join('equipment', 'equipment.id', '=', 'borrowing_details.equipment_id')
    //         -join('equipment_attributes', 'equipment_attributes.id', 'borrowing_details.equipment_attrs')
    //     );
    // }
    public function transaction(Request $request)
    {
      return inertia('Admin/HistoricalPage',[
        'histories' => Borrowing::select(
            'borrowings.id as borrow_id',
            'bd.id as detail_id',
            'e.id as equipment_id',
            'owner.name as owner',
            'ao.municipality as borrower',
            'e.name as equipment',
            'bd.quantity as quantity',
            'attrs.code',
            'attrs.asset_desc',
            'attrs.category',
            'attrs.unit',
            'attrs.model_number',
            'attrs.serial_number',
            'attrs.asset_id',
            'attrs.remarks',
            'bh.serviceable',
            'bh.poor',
            'bh.unusable',
            'borrowings.created_at'

        )
            ->addSelect([
                'returned' => BorrowHistory::whereColumn('bd.id', 'borrow_histories.borrowing_detail_id')
                    ->selectRaw('sum(borrow_histories.serviceable + borrow_histories.poor + borrow_histories.unusable)')
            ])
            ->join('offices as borrower', DB::raw('borrower.id'), '=', 'borrowings.borrower')
            ->join('assign_offices as ao', DB::raw('ao.id'), '=', DB::raw('borrower.assign'))
            ->join('offices as owner', DB::raw('owner.id'), '=', 'borrowings.owner')
            ->join('borrowing_details as bd', DB::raw('bd.borrowing_id'), '=', 'borrowings.id')
            ->join('equipment as e', DB::raw('e.id'), '=', DB::raw('bd.equipment_id'))
            ->Leftjoin('borrow_histories as bh', DB::raw('bh.borrowing_detail_id'), '=', DB::raw('bd.id'))
            // ->withCount('history')
            ->leftJoin('equipment_attributes as attrs', DB::raw('attrs.id'), '=', DB::raw('bd.equipment_attrs'))
            ->when($request->input('search'), function ($q, $search) {
                $q->where('borrower.name', 'like', '%' . $search . '%');
            })
            // ->where('owner.id', auth()->id())
            ->latest()
            ->paginate($request->input('load'))->withQueryString()

            ->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('d F Y');
            }),
            'filters' => $request->only('search'),
        ]);
    }
}
