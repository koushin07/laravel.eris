<?php

namespace App\Http\Controllers\Users;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Services\LocationService;
use App\Services\HistoryService;
use App\Models\User;
use App\Models\Role;
use App\Models\Province;
use App\Models\Office;
use App\Models\Municipality;
use App\Models\Equipment;
use App\Models\Borrowing;
use App\Models\BorrowHistory;
use App\Http\Controllers\Controller;
use App\Events\BCastingEvent;
use App\Models\Approval;
use App\Models\AssignOffice;
use App\Models\EquipmentBorrow;

class PagesController extends Controller
{
    protected $history;
    public function __construct(HistoryService $historyService)
    {
        $this->history = $historyService;
    }
    function index(Request $request)
    {
        // dd($request->input('id'));
        return inertia('municipality/RequestPage', [
            'histories' => Borrowing::select([
                'borrowing_details.id',
                'borrowing_details.incident_id',
                'borrowing_details.incident',
                'borrowing_details.file_path',
                'borrowing_details.created_at',

            ])->addSelect([
                'acquired' => EquipmentBorrow::whereColumn('borrowing_details.id', 'equipment_borrows.detail_id')
                    ->select(DB::raw('sum(equipment_borrows.acquired)'))
            ])->addSelect([
                'authorize_quantity' => EquipmentBorrow::whereColumn('borrowing_details.id', 'equipment_borrows.detail_id')
                    ->select(DB::raw('count(equipment_borrows.authorize_quantity) as authorize_quantity'))->where('equipment_borrows.status', '=', 'pending')->where('equipment_borrows.acquired', '=', 0)
            ])

                ->when($request->input('date'), function ($q, $date) {
                    $q->whereDate('borrowing_details.created_at', '=', Carbon::parse($date)->addDay()->format('Y-m-d'));
                })->when($request->input('id'), function ($q, $id) {
                    $q->where('borrowing_details.incident_id', '=', $id);
                })->when($request->input('name'), function ($q, $name) {
                    $q->where('borrowing_details.incident', 'like', '%'. $name .'%');
                })


                ->join('borrowing_details', 'borrowing_details.borrowing_id', '=', 'borrowings.id')->where('borrowings.borrower', auth()->id())->latest()->paginate(10),

            'queryString' => $request->only(['date', 'name', 'id']),
            'equipments' => DB::table('equipment')
                ->join('equipment_owneds', 'equipment_owneds.equipment_id', '=', 'equipment.id')
                ->whereNot('equipment_owneds.office_id', '=', auth()->id())
                ->select('equipment.id', 'name')
                ->groupBy('name')->get(),
            'provinces' => Office::select('assign_offices.province')
                ->join('assign_offices', 'assign_offices.id', '=', 'offices.assign')
                ->join('roles', 'roles.id', '=', 'offices.role_id')->where('roles.role_type', Role::PROVINCE)->get(),

        ]);
    }


    public function send()
    {

        $recieved = DB::select(
            "SELECT 
            b.name AS borrower, 
            c.name AS owner, 
            e.equipment_name as equipment, 
            bd.quantity as quantity
            FROM borrowings a
        JOIN  offices b ON b.id = a.borrower 
        JOIN offices c ON c.id = a.owner
        JOIN borrowing_details bd ON bd.borrowing_id = a.id
        JOIN equipment e ON e.id = bd.equipment_id
        WHERE a.confirmation = 1 AND
        b.id = :myid LIMIT 5",
            ['myid' => auth()->id()]
        );

        return  collect($recieved);
    }

    public function pending()
    {
        abort_unless(auth()->check(), 403);


        $pendning = DB::select(
            "SELECT 
            bd.id,
            o.name AS borrower, 
            c.name AS owner, 
            e.equipment_name as equipment, 
            bd.quantity as quantity
            FROM borrowings b
        JOIN  offices o ON o.id = b.borrower 
        JOIN offices c ON c.id = b.owner
        JOIN borrowing_details bd ON bd.borrowing_id = b.id
        JOIN equipment e ON e.id = bd.equipment_id
        WHERE c.id = :myid AND b.confirmation = 0
        LIMIT 5",
            ['myid' => auth()->id()]
        );
        return collect($pendning);
    }


    public function approval()
    {

        return inertia('municipality/Transactions/ApprovalPage', [

            'notifications' => Borrowing::select(
                'bd.incident',
                'borrowings.id as borrow_id',
                'borrowee.lastname as borrower_lastname',
                'borrowee.firstname as borrower_firstname',
                'borrowee.middlename as borrower_middlename',
                'borrowee.suffix as borrower_suffix',
                'bd.incident',
                'bd.id as detail_id',
                'owner.lastname as owner_lastname',
                'owner.firstname as owner_firstname',
                'owner.middlename as owner_middlename',
                'owner.suffix',
                'owner.contact',
                'owner.address',
                'eb.id as eb_id',
                'ao.municipality',
                'e.name as equipment',
                'eb.quantity as quantity',
                'borrowings.created_at'

            )




                ->join('offices as borrower', DB::raw('owner.id'), '=', 'borrowings.borrower')
                ->join('borrowing_details as bd', DB::raw('bd.borrowing_id'), '=', 'borrowings.id')

                ->join('equipment_borrows as eb', DB::raw('eb.detail_id'), '=', DB::raw('bd.id'))
                ->join('offices as borrowee', DB::raw('borrowee.id'), '=', DB::raw('eb.borrowee'))
                ->join('assign_offices as ao', DB::raw('ao.id'), '=', DB::raw('borrowee.assign'))
                ->join('equipment as e', DB::raw('e.id'), '=', DB::raw('eb.equipment_id'))
                ->where('borrowings.owner', '=', auth()->id())
                ->where('eb.status', '=', 'pending')
                // ->where('owner.id', auth()->id())
                ->latest()
                ->get()


        ]);
    }
    public function show(Request $request, $id)
    {

        return inertia('municipality/InvoicePage', [
            'equipments' =>  EquipmentBorrow::select(
                'equipment.name',
                'offices.lastname',
                'offices.firstname',
                'offices.middlename',
                'offices.suffix',
                'assign_offices.municipality',
                'offices.id as office_id',
                'offices.contact',
                'offices.address',
                'borrowing_details.incident',
                'borrowing_details.incident_summary',
                'equipment_borrows.created_at',
                'equipment_borrows.authorize_quantity',
                'equipment_borrows.quantity',
                'equipment_borrows.reason',
                'equipment_borrows.acquired',
                'equipment_borrows.status',
                'equipment_borrows.id',
            )
                ->where('detail_id', $id)
                ->join('borrowing_details', 'borrowing_details.id', 'equipment_borrows.detail_id')
                ->join('borrowings', 'borrowings.id', '=', 'borrowing_details.borrowing_id')
                ->join('offices', 'offices.id', '=', 'equipment_borrows.borrowee')
                ->join('assign_offices', 'assign_offices.id', '=', 'offices.assign')
                ->join('equipment', 'equipment.id', '=', 'equipment_borrows.equipment_id')->latest()->paginate(10),
            'incident' => $request->incident,
            'summary' => $request->summary,
            'detail_id' => $id,
            'equipments_drowpdown' => DB::table('equipment')
                ->join('equipment_owneds', 'equipment_owneds.equipment_id', '=', 'equipment.id')
                ->whereNot('equipment_owneds.office_id', '=', auth()->id())
                ->select('equipment.id', 'name')
                ->groupBy('name')->get(),
            'provinces' => AssignOffice::whereNull('municipality')->whereNotNull('province')->get('province')
        ]);
    }
}
