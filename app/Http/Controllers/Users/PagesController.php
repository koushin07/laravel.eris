<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Province;
use App\Models\Municipality;
use App\Models\Equipment;
use App\Http\Controllers\Controller;
use App\Events\BCastingEvent;
use App\Models\Borrowing;
use App\Models\Office;
use App\Services\LocationService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PagesController extends Controller
{
    function index()
    {


        //     [
        //         'status' => DB::select(
        //             "SELECT
        //   SUM(quantity) AS total,
        //   SUM(CASE when status = 'serviceable' AND municipality_id = :Sid then quantity else 0 end) AS serviceable,
        //   SUM(CASE when status = 'poor'  AND municipality_id = :Pid   then quantity else 0 end) AS poor,
        //   SUM(CASE when status = 'unusable'  AND municipality_id = :Uid  then quantity else 0 end) as unusable
        //   FROM equipment
        //   WHERE municipality_id = :myid
        //   order BY total",
        //             [
        //                 'myid' => auth()->user()->municipality_id,
        //                 'Sid' => auth()->user()->municipality_id,
        //                 'Pid' => auth()->user()->municipality_id,
        //                 'Uid' => auth()->user()->municipality_id
        //             ]
        //         )[0],
        //     ]
        $status = DB::select(
            "SELECT
        Serviceable + Unusable + Poor AS total,
        SUM(serviceable) AS Serviceable, 
        SUM(unusable) AS Unusable, 
        SUM(poor) AS Poor FROM conditions
        JOIN equipment_owneds ON equipment_owneds.id = conditions.equipment_owner
        WHERE office_id = :myid
        GROUP BY total",
            [
                'myid' => auth()->id(),

            ]
        );
        if ($status) {
            $status = $status[0];
        }
        return inertia('municipality/RequestPage', [
            'status' => $status
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
        // abort_unless(auth()->check(), 403);
        // $borrows = MunicipalityTransaction::select(
        //     [
        //         'municipality_transactions.id',
        //         'municipality_transactions.created_at',
        //         'municipality_transactions.quantity',
        //         'municipalities.municipality_name',
        //         'equipment.equipment_name',
        //         'equipment.model_number',
        //     ]
        // )
        //     ->join('equipment', 'municipality_transactions.equipment_id', '=', 'equipment.id')
        //     ->where('equipment.municipality_id', '=', auth()->user()->municipality_id)
        //     ->join('municipalities', 'equipment.municipality_id', '=', 'municipalities.id')
        //     ->where('confirm', '=', 1)
        //     ->limit(5)->latest()->get();

        // return $borrows;


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

    public function distance(LocationService $locService)
    {
        $provinces = array(
            'camiguin' => ['Catarman', 'Guinsiliban', 'Mahinog', 'Mambajao', 'Sagay'],
            'Bukidnon' =>['Baungon','Cabanglasan', 'Damulog', 'Dangcagan', 'Don_Carlos', 'Impasug-Ong']
        );

        foreach($provinces as $key => $province)
        {
            foreach($province as $municipality){

                dd($municipality, $key);
            }
            dd($province);
        }
    }
}
