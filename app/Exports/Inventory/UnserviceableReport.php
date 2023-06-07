<?php

namespace App\Exports\Inventory;

use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Carbon\Carbon;
use App\Models\Equipment;


class UnserviceableReport implements FromView, WithTitle, ShouldAutoSize
{
    public function title(): string
    {
        return 'Damage Equipment';
    }
    public function view(): View
    {
        return view('export.Inventory.UnserviceableReport', [
            'invoices' =>Equipment::select([
                'equipment.name',
                'equipment_attributes.*',
                'equipment_details.serviceable',
                'equipment_details.unserviceable',
                'equipment_details.poor',
               

            ])
    
                ->join('equipment_owneds', 'equipment_owneds.equipment_id', '=', 'equipment.id')
                ->join('equipment_details', 'equipment_details.equipment_owner', '=', 'equipment_owneds.id')
                ->join('offices', 'offices.id', '=', 'equipment_owneds.office_id')
                ->join('assign_offices', 'assign_offices.id', '=', 'offices.assign')
                ->join('equipment_attributes', 'equipment_attributes.id', '=', 'equipment_owneds.equipment_attrs')
                ->where('equipment_owneds.office_id', auth()->id())
                ->where('equipment_details.unserviceable', '<>', 0)
                ->get()->sortBy('equipment_details.unserviceable'),
                'office'=>auth()->user(),
                'date' =>Carbon::now()->format('F d Y ')
        ]);
    }
}
