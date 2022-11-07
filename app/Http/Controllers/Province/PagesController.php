<?php

namespace App\Http\Controllers\Province;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\UnfinishTransaction;
use App\Models\Office;
use App\Http\Controllers\Controller;
use App\Models\IncidentReport;

class PagesController extends Controller
{

    public function dashboard()
    {

        return inertia('Province/DashboardPage', [
            'locals' => DB::select(
                "SELECT ut.equipment, ow.name AS owner, br.name AS borrower, ut.created_at FROM unfinish_transactions ut
                 JOIN offices ow ON ut.borrower = ow.id
                 JOIN offices br ON br.id = ut.owner
                 JOIN assign_offices ao ON ao.id = br.assign
                 WHERE ao.province = :province

            ",
                [
                    'province' => auth()->user()->name
                ]
            ),
            'regionals' => DB::select(
                "SELECT ut.equipment, ow.name AS owner, br.name AS borrower, ut.created_at FROM unfinish_transactions ut
                JOIN offices ow ON ut.borrower = ow.id
                JOIN offices br ON br.id = ut.owner
                JOIN assign_offices ao ON ao.id = br.assign
                WHERE NOT ao.province = :province",
                [
                    'province' => auth()->user()->name
                ]
            ),
            'reports' => IncidentReport::with('sender')->where('reciever', auth()->id())->get()
        ]);
    }
    public function consolidated(Request $request)
    {
        return inertia('Province/ConsolidatedPage', [
            'equipments' => DB::table('equipment')->select(
                [
                    'equipment.*',
                    'offices.name as owner',
                    'equipment_details.serviceable',
                    'equipment_details.unusable',
                    'equipment_details.poor',
                ]
            )
                ->join('equipment_owneds', 'equipment_owneds.equipment_id', '=', 'equipment.id')
                ->join('equipment_details', 'equipment_details.equipment_owner', '=', 'equipment_owneds.id')
                ->join('offices', 'offices.id', '=', 'equipment_owneds.office_id')
                ->when(
                    $request->input('search'),
                    function ($q, $search) {
                        $q->where('equipment_name', 'like', '%' . $search . '%');
                    }
                )->when(
                    $request->input('owner'),
                    function ($q, $owner) {
                        $q->Where('equipment_owneds.office_id', $owner);
                    }
                )
                ->paginate(5)->onEachSide(1)->withQueryString(),

            'filters' => $request->only(['search', 'status', 'owner'])
        ]);
    }
    public function transaction()
    {
        return inertia('Province/TransactionPage', [
            'locals' => DB::select("SELECT e.*, borrower.name as borrower, owner.name as owner FROM borrowing_details bd
            JOIN equipment_owneds eo ON eo.id = bd.equipment_owned_id
            JOIN borrowings b ON b.id = bd.borrowing_id
            JOIN offices borrower ON borrower.id = b.borrower
            JOIN equipment e ON e.id = eo.equipment_id
            JOIN offices owner ON owner.id = eo.office_id
            JOIN assign_offices ao ON ao.id = owner.assign
            WHERE ao.province = :province", [
                'province' => auth()->user()->name
            ]),
            'regionals' => DB::select("SELECT e.*, borrower.name as borrower, owner.name as owner FROM borrowing_details bd
            JOIN equipment_owneds eo ON eo.id = bd.equipment_owned_id
            JOIN borrowings b ON b.id = bd.borrowing_id
            JOIN offices borrower ON borrower.id = b.borrower
            JOIN equipment e ON e.id = eo.equipment_id
            JOIN offices owner ON owner.id = eo.office_id
            JOIN assign_offices ao ON ao.id = owner.assign
            WHERE NOT ao.province = :province", [
                'province' => auth()->user()->name
            ])
        ]);
    }
    public function request()
    {
        return inertia('Province/RequestPage', [
            'municipalities' => Office::select(['offices.*'])
                ->join('assign_offices', 'assign_offices.id', '=', 'offices.id')
                ->where('assign_offices.province', '=', auth()->user()->name)
                ->whereNot('offices.id', auth()->id())
                ->get()
        ]);
    }
}
