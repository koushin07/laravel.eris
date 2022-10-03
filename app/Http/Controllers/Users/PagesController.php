<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Province;
use App\Models\Municipality;
use App\Models\Equipment;
use App\Http\Controllers\Controller;
use App\Events\BCastingEvent;
use Illuminate\Support\Facades\DB;

class PagesController extends Controller
{
    function index()
    {


        return inertia('Dashboard', [
            'status' => DB::select(
                "SELECT
      SUM(quantity) AS total,
      SUM(CASE when status = 'serviceable' AND municipality_id = :Sid then quantity else 0 end) AS serviceable,
      SUM(CASE when status = 'poor'  AND municipality_id = :Pid   then quantity else 0 end) AS poor,
      SUM(CASE when status = 'unusable'  AND municipality_id = :Uid  then quantity else 0 end) as unusable
      FROM equipment
      WHERE municipality_id = :myid
      order BY total",
                [
                    'myid' => auth()->user()->municipality_id,
                    'Sid' => auth()->user()->municipality_id,
                    'Pid' => auth()->user()->municipality_id,
                    'Uid' => auth()->user()->municipality_id
                ]
            )[0],
        ]);
    }
    public function returnedChart()
    {
        $returned = DB::select("SELECT COUNT(returned) AS total,
        SUM(CASE WHEN returned = 0 AND equipment.municipality_id = :Fid THEN 1 else 0 END) AS totalPending,
        SUM(CASE WHEN returned = 1 AND equipment.municipality_id = :Tid THEN 1 else 0 END) AS totalReturn
        FROM municipality_transactions
        INNER JOIN equipment ON municipality_transactions.equipment_id = equipment.id
        WHERE equipment.municipality_id = :myid
        ORDER BY total", [
            'Fid' => auth()->user()->municipality_id,
            'Tid' => auth()->user()->municipality_id,
            'myid' => auth()->user()->municipality_id,
        ]);
        return $returned[0];
    }
}
