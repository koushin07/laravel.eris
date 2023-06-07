<?php

namespace App\Services;
use Illuminate\Support\Facades\DB;
use App\Models\EquipmentBorrow;
use App\Models\Equipment;

class EquipmenTrack
{

    /* NOTE:
    *     must frequent municipality borrow   
    */

    public function Analysis($id)
    {
        return EquipmentBorrow::select([
            'assign_offices.municipality',
            DB::raw(" CONCAT(offices.lastname , ' ' , offices.firstname , ' ' , offices.middlename, ' ' ,offices.suffix) as borrower"),
            DB::raw("coalesce(borrow_histories.return_at, 'not returned yet') as date_returned"),
            'borrowing_details.created_at as date_borrowed',
            DB::raw('coalesce(sum(borrow_histories.serviceable), "NaN") as serviceable'),
            DB::raw('coalesce(sum(borrow_histories.unserviceable), "NaN") as unserviceable'),
            DB::raw('coalesce(sum(borrow_histories.poor), "NaN") as poor'),
            DB::raw('coalesce(sum(borrow_histories.serviceable), 0) + coalesce(sum(borrow_histories.unserviceable), 0) + coalesce(sum(borrow_histories.poor), 0) as total_return '),
            DB::raw('coalesce(sum(equipment_borrows.acquired), 0) as total_borrow'),



        ])


            ->join('borrowing_details', 'borrowing_details.id', '=', 'equipment_borrows.detail_id')
            ->join('borrowings', 'borrowings.id', '=', 'borrowing_details.borrowing_id')
            ->join('approvals', 'approvals.id', '=', 'borrowings.approval_id')

            ->join('offices', 'offices.id', '=', 'approvals.borrowee')
            ->join('assign_offices', 'assign_offices.id', '=', 'offices.assign')
            ->leftJoin('borrow_histories', 'borrow_histories.borrowing_detail_id', '=', 'borrowing_details.id')
            ->where('borrowings.owner', auth()->id())->where('equipment_borrows.equipment_id', $id)->groupBy(['assign_offices.municipality'])->get();
            
    }
}