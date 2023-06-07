<?php

namespace App\Exports\Inventory;

use App\Models\AssignOffice;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Carbon\Carbon;
use App\Models\Equipment;
use App\Models\Role;

class ServiceableReport implements FromView, WithTitle, ShouldAutoSize
{

    // public function __construct(
    //     public $date
    // )
    // {
        
    // }
    public function title(): string
    {
        return 'Available Equipment';
    }
    public function view(): View
    {

        $role = Role::find(auth()->user()->role_id);

        if($role->role_type == Role::MUNICIPALITY){}
        return view('export.Inventory.ServiceableReport', [
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
                ->get()->sortBy('equipment_details.serviceable'),
                'office'=>auth()->user(),
                'date' =>Carbon::now()->format('F d Y ')
        ]);
    }
}
