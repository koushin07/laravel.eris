<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Office;
use App\Models\EquipmentOwned;
use App\Models\Condition;
use App\Models\BorrowingDetails;
use App\Models\Borrowing;
use App\Events\NewMunicipalityTransaction;
use Exception;

class BorrowingService
{

    public function insertData($data)
    {

        /* 
            check if the equipment is already borrowed and if yes check if the amount available is greater than the request
            
        */

        /* get borrow record */

        try {
            $office = Office::where('assign', $data->owner)->first();
            $record = Borrowing::query()
                ->join('borrowing_details', function ($join) use ($data) {
                    $join->on('borrowing_id', '=', 'borrowings.id')
                        ->where('equipment_id', $data->equipment_id);
                })
                ->where([
                    ['borrowings.owner', $office->id],
                    ['borrowings.borrower', auth()->id()]
                ])->first();
            if (is_null($office)) {
                dd('office is null');
            }
            // if(is_null($record)){
            //     dd('record is null');
            // }

            // dd($office->id, $data->equipment_id);
            $condition = EquipmentOwned::where([
                ['equipment_id', $data->equipment_id],
                ['office_id', $office->id]
            ])
                ->join('conditions', 'conditions.equipment_owner', 'equipment_owneds.id')->first(['serviceable']);
            // dd($condition->serviceable, $data, $office);

            if (is_null($condition)) {
                dd('condition is null');
            }
            if (!is_null($condition)) {

                $total =  $condition->serviceable;

                // dd('s');    
                if (!is_null($record)) {
                    $total -= $record->quantity;
                }

                if ($total > $data->quantity) {

                    DB::transaction(function () use ($data, $office) {
                        $borrow = Borrowing::create([
                            'borrower' => auth()->id(),
                            'owner' => $data->owner,
                        ]);

                        BorrowingDetails::create([
                            'equipment_id' => $data->equipment_id,
                            'borrowing_id' => $borrow->id,
                            'quantity' => $data->quantity
                        ]);
                      
                       
                    }, 2);
                }
            }
        } catch (Exception $th) {
            dd($th);
        }
    }
}
