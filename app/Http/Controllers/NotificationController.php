<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EquipmentBorrow;
use App\Models\Approval;
use App\Models\Borrowing;

class NotificationController extends Controller
{
    public function requestNotif()
    {
        return EquipmentBorrow::query()
        ->join('borrowing_details', 'borrowing_details.id', '=', 'equipment_borrows.detail_id')
        ->join('borrowings', 'borrowings.id', '=', 'borrowing_details.borrowing_id')
       
        ->join('offices', 'offices.id', '=', 'borrowings.borrower')
        ->join('assign_offices', 'assign_offices.id', '=', 'offices.assign')
        ->groupBy('incident')
        ->where('equipment_borrows.borrowee', auth()->id())  ->where('equipment_borrows.status', '=', 'pending')->count();
    }

    public function reconfirmNotif()
    {

       return  EquipmentBorrow::query()
        ->join('borrowing_details', 'borrowing_details.id', '=', 'equipment_borrows.detail_id')
        ->join('borrowings', 'borrowings.id', '=', 'borrowing_details.borrowing_id')
       
        ->join('offices', 'offices.id', '=', 'equipment_borrows.borrowee')
        ->join('assign_offices', 'assign_offices.id', '=', 'offices.assign')
        ->groupBy('incident')
        ->where('borrowings.borrower', auth()->id())->where('equipment_borrows.status', '=', 'accepted')->where('equipment_borrows.acquired', '=', 0)->count();
        // return Borrowing::query()
        //     ->join('borrowings', 'borrowings.approval_id', '=', 'approvals.id')
        //     ->join('borrowing_details', 'borrowing_details.borrowing_id', '=', 'borrowings.id')
        //     ->join('equipment_borrows', 'equipment_borrows.detail_id', '=', 'borrowing_details.id')
    }
}
