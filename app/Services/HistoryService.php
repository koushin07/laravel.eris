<?php

namespace App\Services;

use App\Models\BorrowHistory;
use App\Models\Borrowing;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HistoryService
{

    public function fetchTransaction($request, $load = 1)
    {
        return Borrowing::select(
            'borrowings.id as borrow_id',
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
            'bh.unusable',
            'borrowings.created_at'

        )
            ->addSelect([
                'returned' => BorrowHistory::whereColumn('bd.id', 'borrow_histories.borrowing_detail_id')
                    ->selectRaw('sum(borrow_histories.serviceable + borrow_histories.poor + borrow_histories.unusable)')
            ])
            ->join('offices as borrower', DB::raw('borrower.id'), '=', 'borrowings.borrower')
            ->join('assign_offices as ao', DB::raw('ao.id'), '=', DB::raw('borrower.assign'))
            ->join('offices as owner', DB::raw('owner.id'), '=', 'borrowings.owner')
            ->join('borrowing_details as bd', DB::raw('bd.borrowing_id'), '=', 'borrowings.id')
            ->join('equipment as e', DB::raw('e.id'), '=', DB::raw('bd.equipment_id'))
            ->Leftjoin('borrow_histories as bh', DB::raw('bh.borrowing_detail_id'), '=', DB::raw('bd.id'))
            // ->withCount('history')
            ->leftJoin('equipment_attributes as attrs', DB::raw('attrs.id'), '=', DB::raw('bd.equipment_attrs'))
            ->where('owner.id', '=', auth()->id())
            ->when($request->input('search'), function ($q, $search) {
                $q->where('borrower.name', 'like', '%' . $search . '%');
            })
            // ->where('owner.id', auth()->id())
            ->latest()
            ->paginate($load)->withQueryString()

            ->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('d F Y');
            });



        // $borrow = $borrow->map(function ($date) {
        //      $date->map(function ($data) {
        //         $data->created_at =  $data->created_at->format('h:i A');
        //        return $data->created_at;
        //     });
        //     return $date;
        // });
        // dd($borrow);
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
            'bh.unusable',
            'borrowings.created_at'

        )
            ->addSelect([
                'returned' => BorrowHistory::whereColumn('bd.id', 'borrow_histories.borrowing_detail_id')
                    ->selectRaw('sum(borrow_histories.serviceable + borrow_histories.poor + borrow_histories.unusable)')
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

            ->groupBy(function($incident){
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
}
