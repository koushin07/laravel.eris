<?php

namespace App\Exports;

use App\Exports\Inventory\UnserviceableReport;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Carbon\Carbon;
use App\Models\Equipment;
use App\Exports\Inventory\ServiceableReport;
use App\Exports\Inventory\OnHandReport;

class InventoryInvoice implements WithMultipleSheets 
{

    // public function __construct(
    //     public $date
    // )
    // {
        
    // }

    public function sheets(): array
    {
        return [
            'Equipment On Hand' => new OnHandReport(),
            'Available Equipment' => new ServiceableReport(),
            'Damage Equipment' => new UnserviceableReport()
        ];
    }
}
