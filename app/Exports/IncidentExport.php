<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Carbon\Carbon;
use App\Models\Equipment;

class IncidentExport implements  FromView, WithTitle, ShouldAutoSize
{


    public function __construct(
        public $id
    )
    {
        
    }
    public function title(): string
    {
        return 'Available Equipment';
    }
    public function view(): View
    {
        return view('export.Inventory.ServiceableReport', [
            'invoices' => Approval::select(
                'borrowing_details.incident_id',
                'borrowing_details.id',
                'borrowing_details.incident',
                'borrowing_details.incident_summary',
                'borrowing_details.created_at',
              
            )
            ->addSelect([
                'acquired' => EquipmentBorrow::whereColumn('borrowing_details.id', 'equipment_borrows.detail_id')
                    ->select(DB::raw('equipment_borrows.acquired'))->where('equipment_borrows.acquired', '=', 0)->where('equipment_borrows.status', '=', 'accepted')
            ])
            ->addSelect([
                'quantity' => EquipmentBorrow::whereColumn('borrowing_details.id', 'equipment_borrows.detail_id')
                    ->select( DB::raw('sum(equipment_borrows.quantity) as quantity'))
            ])
            
            
            ->join('borrowings', 'borrowings.approval_id', '=', 'approvals.id')
            ->join('borrowing_details', 'borrowing_details.borrowing_id', '=', 'borrowings.id')
            ->join('equipment_borrows', 'equipment_borrows.detail_id', '=', 'borrowing_details.id')
               
            ->where('approvals.borrowee', auth()->id())->latest()->paginate(10)->onEachSide(1),
        ]);
    }
}
