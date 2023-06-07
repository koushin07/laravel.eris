<?php

namespace App\Services;

use App\Models\Approval;
use App\Models\BorrowHistory;
use App\Models\Borrowing;
use App\Models\BorrowingDetails;
use App\Models\Equipment;
use App\Models\EquipmentBorrow;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HistoryService
{

    public function fetchTransaction($request, $load = 1)
    {
        return Borrowing::select(
            'borrowings.id as borrow_id',
            'bd.id as detail_id',
            'bd.incident',
            'e.id as equipment_id',
            DB::raw(" CONCAT(owner.lastname , ' ' , owner.firstname , ' ' , owner.middlename, ' ' ,owner.suffix) as owner"),
            DB::raw(" CONCAT(borrower.lastname , ' ' , borrower.firstname , ' ' , borrower.middlename, ' ' ,borrower.suffix) as borrower"),
            'aob.municipality as borrower',
            'oao.municipality as owner',
            'e.name as equipment',
            'eb.acquired as quantity',
            DB::raw('SUM(bh.serviceable - eb.acquired  ) as damage'),
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
            'bh.unserviceable',
            'borrowings.created_at'

        )
            ->addSelect([
                'returned' => BorrowHistory::whereColumn('bd.id', 'borrow_histories.borrowing_detail_id')
                    ->selectRaw('sum(borrow_histories.serviceable + borrow_histories.poor + borrow_histories.unserviceable)')
            ])
            ->join('offices as owner', DB::raw('owner.id'), '=', 'borrowings.owner')
            ->join('assign_offices as oao', DB::raw('oao.id'), '=',  DB::raw('owner.assign'))
            ->join('assign_offices as ao', DB::raw('ao.id'), '=', DB::raw('owner.assign'))
            ->join('borrowing_details as bd', DB::raw('bd.borrowing_id'), '=', 'borrowings.id')
            ->join('approvals', 'approvals.id', '=', 'borrowings.approval_id')
            ->join('offices as borrower', DB::raw('borrower.id'), '=', 'approvals.borrowee')
            ->join('assign_offices as aob', DB::raw('aob.id'), '=', DB::raw('borrower.assign'))
            ->join('equipment_borrows as eb', DB::raw('eb.detail_id'), '=', DB::raw('bd.id'))
            ->join('equipment as e', DB::raw('e.id'), '=', DB::raw('eb.equipment_id'))
            ->Leftjoin('borrow_histories as bh', DB::raw('bh.borrowing_detail_id'), '=', DB::raw('bd.id'))
            // ->withCount('history')
            ->leftJoin('equipment_attributes as attrs', DB::raw('attrs.id'), '=', DB::raw('eb.equipment_attrs'))
            ->where('owner.id', '=', auth()->id())
            ->when($request->input('search'), function ($q, $search) {
                $q->where('borrower.name', 'like', '%' . $search . '%');
            })
            // ->where('owner.id', auth()->id())
            ->latest()
            ->paginate($load)->withQueryString()

            ->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('F d, Y');
            });
    }
    public function fetchMyHistory()
    {
        return Borrowing::select(
            'borrowings.id as borrow_id',
            'bd.reason',
            'bd.status',
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
            'bh.unserviceable',
            'borrowings.created_at'

        )
            ->addSelect([
                'returned' => BorrowHistory::whereColumn('bd.id', 'borrow_histories.borrowing_detail_id')
                    ->selectRaw('sum(borrow_histories.serviceable + borrow_histories.poor + borrow_histories.unserviceable)')
            ])
            ->join('offices as borrower', DB::raw('borrower.id'), '=', 'borrowings.borrower')
            ->join('assign_offices as ao', DB::raw('ao.id'), '=', DB::raw('borrower.assign'))
            ->join('offices as owner', DB::raw('owner.id'), '=', 'borrowings.owner')
            ->join('borrowing_details as bd', DB::raw('bd.borrowing_id'), '=', 'borrowings.id')
            ->join('equipment as e', DB::raw('e.id'), '=', DB::raw('bd.equipment_id'))
            ->Leftjoin('borrow_histories as bh', DB::raw('bh.borrowing_detail_id'), '=', DB::raw('bd.id'))
            // ->withCount('history')
            ->leftJoin('equipment_attributes as attrs', DB::raw('attrs.id'), '=', DB::raw('bd.equipment_attrs'))
            ->where('borrower.id', '=', auth()->id())

            // ->where('owner.id', auth()->id())
            ->latest()
            ->get()

            ->groupBy(function ($incident) {
                return $incident->reason;
            });
    }
    public function borrowed($request, $load = 1)
    {
        $data = $this->fetchTransaction($request, $load);

        $total = $data->map(function ($date) {
            return $date->sum('quantity');
        });

        return $total;
    }


    public function byIncident($request)
    {

        return EquipmentBorrow::select(
            'borrowing_details.id',
            'borrowing_details.incident_id',
            'borrowing_details.incident',
            'borrowing_details.created_at'

        )
            ->addSelect([
                'authorize_quantity' => EquipmentBorrow::whereColumn('borrowing_details.id', 'equipment_borrows.detail_id')
                    ->select(DB::raw('sum(equipment_borrows.authorize_quantity)'))
            ])->addSelect([
                'acquired' => EquipmentBorrow::whereColumn('borrowing_details.id', 'equipment_borrows.detail_id')
                    ->select(DB::raw('sum(equipment_borrows.acquired)'))
            ])->addSelect([
                'count' => Equipment::whereColumn('equipment_borrows.equipment_id', 'equipment.id')
                    ->select(DB::raw('count(equipment.name)'))
            ])
            ->when($request->input('date'), function ($q, $date) {
                $q->whereDate('borrowing_details.created_at', '=', Carbon::parse($date)->addDay()->format('Y-m-d'));
            })
            ->when($request->input('filter'), function ($q, $filter) {
                $q->where('borrowing_details.incident', '=', $filter);
            })
            ->join  ('equipment', 'equipment.id', '=', 'equipment_borrows.equipment_id')
            ->join('borrowing_details', 'borrowing_details.id', '=', 'equipment_borrows.detail_id')
            ->join('borrowings', 'borrowings.id', '=', 'borrowing_details.borrowing_id')
            ->groupBy('borrowing_details.incident')
            ->where('approval.borrowee', auth()->id())->latest()->paginate(10)->onEachSide(1);
    }
}
// Approval::select(
//     'borrowing_details.incident_id',
//     'borrowing_details.id',
//     'borrowing_details.incident',
//     'borrowing_details.incident_summary',
//     'borrowing_details.created_at',
  
// )
// ->addSelect([
//     'acquired' => EquipmentBorrow::whereColumn('borrowing_details.id', 'equipment_borrows.detail_id')
//         ->select(DB::raw('equipment_borrows.acquired'))->where('equipment_borrows.acquired', '=', 0)->where('equipment_borrows.status', '=', 'accepted')
// ])
// ->addSelect([
//     'quantity' => EquipmentBorrow::whereColumn('borrowing_details.id', 'equipment_borrows.detail_id')
//         ->select( DB::raw('sum(equipment_borrows.quantity) as quantity'))
// ])


// ->when($request->input('date'), function ($q, $date) {
//         $q->whereRaw('DATE(borrowing_details.created_at) = ?', Carbon::parse($date)->format('Y-m-d'));
//     })
//     ->when($request->input('name'), function ($q, $name) {
//         $q->where('borrowing_details.incident', 'like', '%' . $name . '%');
//     })
  
//     ->when($request->input('id'), function ($q, $id) {
//         $q->where('borrowing_details.incident_id', '=', $id);
//     })
// ->join('borrowings', 'borrowings.approval_id', '=', 'approvals.id')
// ->join('borrowing_details', 'borrowing_details.borrowing_id', '=', 'borrowings.id')
// ->join('equipment_borrows', 'equipment_borrows.detail_id', '=', 'borrowing_details.id')
   
// ->where('approvals.borrowee', auth()->id())->latest()->paginate(10)->onEachSide(1);