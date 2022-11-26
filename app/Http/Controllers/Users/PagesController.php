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

class PagesController extends Controller
{
    protected $history;
    public function __construct(HistoryService $historyService)
    {
        $this->history = $historyService;
    }
    function index()
    {
        // dd(auth()->user()->unreadNotifications);
        // dd($this->history->fetchMyHistory());
        // dd(Office::join('roles', 'roles.id' , '=', 'offices.role_id' )->where('roles.role_type',Role::PROVINCE)->get());
        return inertia('municipality/RequestPage', [
            'histories' => $this->history->fetchMyHistory(),
            'equipments' => DB::table('equipment')
                ->join('equipment_owneds', 'equipment_owneds.equipment_id', '=', 'equipment.id')
                ->whereNot('equipment_owneds.office_id', '=', auth()->id())
                ->select('equipment.id', 'name')
                ->groupBy('name')->get(),
            'provinces' => Office::join('roles', 'roles.id', '=', 'offices.role_id')->where('roles.role_type', Role::PROVINCE)->get()
        ]);
    }
    public function returnedChart()
    {
        // $returned = DB::select("SELECT COUNT(returned) AS total,
        // SUM(CASE WHEN returned = 0 AND equipment.municipality_id = :Fid THEN 1 else 0 END) AS totalPending,
        // SUM(CASE WHEN returned = 1 AND equipment.municipality_id = :Tid THEN 1 else 0 END) AS totalReturn
        // FROM municipality_transactions
        // INNER JOIN equipment ON municipality_transactions.equipment_id = equipment.id
        // WHERE equipment.municipality_id = :myid
        // ORDER BY total", [
        //     'Fid' => auth()->user()->municipality_id,
        //     'Tid' => auth()->user()->municipality_id,
        //     'myid' => auth()->user()->municipality_id,
        // ]);
        // return $returned[0];
        // return DB::select("SELECT b.name AS borrower, c.name AS owner FROM borrowings a
        // JOIN  offices b on b.id = a.borrower 
        // JOIN offices c on c.id = a.owner
        // WHERE c.id = :id",['myid' =>auth()->id()]);
        // return DB::table('borrowings')
        // ->select(DB::raw('month(created_at) as month' ), DB::raw('count(*) as views'), DB::raw('year(created_at) as nows'))

        // ->where('nows', date("Y"))
        // ->groupBy('month')
        // ->get();
        return DB::select("select bd.quantity, e.equipment_name, o.name as owner , bd.created_at from  borrowing_details bd
        join borrowings b on b.id = bd.borrowing_id
        join offices o on o.id = b.owner
        join equipment e on e.id = bd.equipment_id");
        /* 
        return DB::select("select month(created_at) as month, 
        count(*) as total from borrowings 
        where year(created_at) = :nowYear group by month;", ['nowYear' => date("Y")]);
        $confirmed = Borrowing::where(
            [
                ['owner', auth()->id()],
                ['confirmation', true]
            ]
        )->count();

        $Xconfirmed = Borrowing::where(
            [
                ['owner', auth()->id()],
                ['confirmation', false]
            ]
        )->count();

        return collect([
            'total' => $confirmed + $Xconfirmed,
            'confirmed' => $confirmed,
            'not_confirmed' => $Xconfirmed,
        ]); */
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
                'borrowings.id as borrow_id',
                'borrowings.borrower_personel',
                'bd.reason',
                'bd.id as detail_id',
                'owner.name as owner',
                'ao.municipality as borrower',
                'e.name as equipment',
                'bd.quantity as quantity',
                'borrowings.created_at'

            )
                ->join('offices as borrower', DB::raw('borrower.id'), '=', 'borrowings.borrower')
                ->join('assign_offices as ao', DB::raw('ao.id'), '=', DB::raw('borrower.assign'))
                ->join('offices as owner', DB::raw('owner.id'), '=', 'borrowings.owner')
                ->join('borrowing_details as bd', DB::raw('bd.borrowing_id'), '=', 'borrowings.id')
                ->join('equipment as e', DB::raw('e.id'), '=', DB::raw('bd.equipment_id'))
                ->where('owner.id', '=', auth()->id())
                ->where('bd.status', '=', 'pending')
                // ->where('owner.id', auth()->id())
                ->latest()
                ->get()


        ]);
    }
}
