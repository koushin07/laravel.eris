<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\Office;
use App\Models\IncidentReport;
use App\Models\EquipmentOwned;
use App\Models\EquipmentDetail;
use App\Models\EquipmentBorrow;
use App\Models\Equipment;
use App\Models\BorrowingDetails;
use App\Models\Borrowing;
use App\Models\BorrowHistory;
use App\Models\AssignOffice;
use App\Models\Approval;
use App\Http\Controllers\Controller;

class AdminPageController extends Controller
{
    public function dashboard()
    {

        return inertia('Admin/DashboardPage', [
            'unverifieds' => Office::select(['offices.id', 'assign_offices.municipality'])->join('assign_offices', 'assign_offices.id', '=', 'offices.assign')->join('roles', 'roles.id', '=', 'offices.role_id')->where('roles.role_type', '=', Role::MUNICIPALITY)->get(),

            'count_unverified' => Office::select(['offices.id', 'assign_offices.municipality'])->join('assign_offices', 'assign_offices.id', '=', 'offices.assign')->join('roles', 'roles.id', '=', 'offices.role_id')->where('roles.role_type', '=', Role::MUNICIPALITY)
                ->where('offices.must_reset_password', true)->count(),

            'prov_unverified' => Office::select(['offices.id', 'assign_offices.municipality'])->join('assign_offices', 'assign_offices.id', '=', 'offices.assign')->join('roles', 'roles.id', '=', 'offices.role_id')->where('offices.must_reset_password', true)->where('roles.role_type', '=', Role::PROVINCE)->count()
        ]);
    }

    public function consolidated(Request $request)
    {
    }
    public function archive(Request $request)
    {


        return inertia('Admin/ReportPage', [
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
                ->join('equipment_borrows', 'equipment_borrows.detail_id', '=', 'borrowing_details.id')
                ->join('offices', 'offices.id', '=', 'borrowings.borrower')
                ->join('assign_offices', 'assign_offices.id', '=', 'offices.assign')

                ->whereNotNull(['assign_offices.municipality', 'borrowing_details.filename'])
                ->when($request->input('date'), function ($q, $date) {
                    $q->whereDate('borrowing_details.created_at', '=', Carbon::parse($date)->addDay()->format('Y-m-d'));
                })
                ->when($request->input('municipality'), function ($q, $municipality) {
                    $q->where('assign_offices.id', '=', $municipality);
                })
                ->paginate(8)
        ]);
    }


    public function transaction(Request $request)
    {
        return inertia('Admin/HistoricalPage', [
            'histories' => Borrowing::select([
                'equipment.name',
                'borrowing_details.id',
                'borrowing_details.incident',
                'borrowing_details.filename',
                'borrowing_details.file_path',
                DB::raw('aob.municipality as borrower'),
                DB::raw('ao.municipality as owner'),
                DB::raw("CONCAT(borrower.lastname , ' ' , borrower.firstname , ' ' , borrower.middlename, ' ' ,borrower.suffix) as borrower_personnel"),
                DB::raw("CONCAT(owner.lastname , ' ' , owner.firstname , ' ' , owner.middlename, ' ' ,owner.suffix) as owner_personnel"),
                'aob.province'

            ])


                ->join('offices as borrower', DB::raw('borrower.id'), '=', 'borrowings.borrower')

                ->join('assign_offices as aob', DB::raw('aob.id'), '=', DB::raw('borrower.assign'))
                ->join('borrowing_details', 'borrowing_details.borrowing_id', '=', 'borrowings.id')
                ->join('equipment_borrows', 'equipment_borrows.detail_id', '=', 'borrowing_details.id')
                ->join('offices as owner', DB::raw('owner.id'), '=', 'equipment_borrows.borrowee')
                ->join('assign_offices as ao', DB::raw('ao.id'), '=', DB::raw('owner.assign'))
                ->leftJoin('equipment_attributes', 'equipment_attributes.id', '=', 'equipment_borrows.equipment_attrs')
                ->join('equipment', 'equipment.id', '=', 'equipment_borrows.equipment_id')
                ->when($request->input('municipality'), function ($q, $municipality) {
                    // dd();
                    $q->where('aob.municipality', '=', $municipality['municipality']);
                })
                ->paginate(10),
            'filters' => $request->only('search'),
            'municipalities' => AssignOffice::select(['assign_offices.municipality'])
                ->join('offices', 'offices.assign', '=', 'assign_offices.id')
                ->whereNotNull('municipality')->get(),
        ]);
    }
}
