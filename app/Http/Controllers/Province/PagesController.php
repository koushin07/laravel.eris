<?php

namespace App\Http\Controllers\Province;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\UnfinishTransaction;
use App\Models\Office;
use App\Http\Controllers\Controller;
use App\Models\AssignOffice;
use App\Models\IncidentReport;

class PagesController extends Controller
{

    public function dashboard()
    {

        $myProvince = AssignOffice::find(auth()->user()->assign);
        return inertia('Province/DashboardPage', [
            'locals' => DB::select(
                "SELECT 
                e.name as equipment, borrower.name as borrower, owner.name as owner
             FROM borrowings b 
            JOIN offices borrower on b.borrower = borrower.id
            JOIN offices owner on b.owner= owner.id
            JOIN assign_offices ao ON ao.id = borrower.assign
            JOIN borrowing_details bd ON bd.borrowing_id = b.id
            JOIN equipment_attributes attrs ON attrs.id = bd.equipment_attrs
            JOIN equipment e ON e.id = bd.equipment_id
            WHERE ao.province = :province",
                [
                    'province' => $myProvince->province
                ]
            ),
            'regionals' => DB::select(
                "SELECT 
                e.name as equipment, borrower.name as borrower, owner.name as owner
             FROM borrowings b 
            JOIN offices borrower on b.borrower = borrower.id
            JOIN offices owner on b.owner= owner.id
            JOIN assign_offices ao ON ao.id = borrower.assign
            JOIN borrowing_details bd ON bd.borrowing_id = b.id
            JOIN equipment e ON e.id = bd.equipment_id
            JOIN equipment_attributes attrs ON attrs.id = bd.equipment_attrs
            WHERE NOT ao.province = :province",
                [
                    'province' => $myProvince->province
                ]
            ),
            'reports' => IncidentReport::with('reciever')->where('sender', auth()->id())->get()
        ]);
    }
    public function consolidated(Request $request)
    {
        return inertia('Province/ConsolidatedPage', [
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
                ->join('offices', 'offices.id', '=', 'equipment_owneds.office_id')
                ->join('equipment_attributes', 'equipment_attributes.equipment_id', '=', 'equipment.id')
                ->join('assign_offices', 'assign_offices.id', '=', 'offices.assign')
                ->where('assign_offices.province', '=', auth()->user()->assign_office()->first()->province)
                ->when(
                    $request->input('search'),
                    function ($q, $search) {
                        $q->where('equipment.name', 'like', '%' . $search . '%');
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
            'locals' => DB::select("SELECT e.name, borrower.name as borrower,
             owner.name as owner, 
             attrs.*
             FROM borrowing_details bd
            JOIN borrowings b ON b.id = bd.borrowing_id
            JOIN equipment_attributes attrs ON attrs.id = bd.equipment_attrs
            JOIN offices borrower ON borrower.id = b.borrower
            JOIN equipment e ON e.id = bd.equipment_id
            JOIN offices owner ON owner.id = b.owner
            JOIN assign_offices ao ON ao.id = owner.assign
            WHERE ao.province = :province", [
                'province' => auth()->user()->name
            ]),
            'regionals' => DB::select("SELECT e.*, borrower.name as borrower, owner.name as owner FROM borrowing_details bd
            
            JOIN borrowings b ON b.id = bd.borrowing_id
            JOIN equipment_attributes attrs ON attrs.id = bd.equipment_attrs
            JOIN offices borrower ON borrower.id = b.borrower
            JOIN equipment e ON e.id = bd.equipment_id
            JOIN offices owner ON owner.id = b.owner
            JOIN assign_offices ao ON ao.id = owner.assign
            WHERE NOT ao.province = :province", [
                'province' => auth()->user()->name
            ])
        ]);
    }
    public function request()
    {
        return inertia('Province/RequestPage', [
            'municipalities' =>Office::select(['offices.id', 'assign_offices.municipality'])
            ->join('assign_offices', 'assign_offices.id', '=', 'offices.assign')
            ->whereNotNull('assign_offices.municipality')
            ->get()
        ]);
    }
}
