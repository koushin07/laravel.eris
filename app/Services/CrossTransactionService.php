<?php

namespace App\Services;

use App\Events\MtoPTransactionEvent;
use Illuminate\Support\Facades\DB;
use App\Services\UserService;
use App\Services\EquipmentService;
use App\Models\Province;
use App\Models\MunicipalityTransaction;
use App\Models\Municipality;
use App\Models\Equipment;
use App\Models\CrossTransaction;

class CrossTransactionService
{
    protected $EquipmentService;
    protected $UserService;

    public function __construct(EquipmentService $EquipmentService, UserService $UserService)
    {
        $this->EquipmentService = $EquipmentService;
        $this->UserService = $UserService;
    }

    public function isEquipmentAvailable($request)
    {
        $equipments = $this->EquipmentService->getMunicipalityEquipment(
            $request['municipality_name'],
            $request['equipment_name']
        )->get();

        if (!$equipments->isEmpty()) {

            foreach ($equipments as $equipment) {

                if ($equipment->quantity != 0 && $equipment->quantity >= $request['quantity']) {
                    $this->insertData(
                        $equipment->id,
                        $equipment->municipality_id,
                        $request['quantity'],

                    );
                    return true;
                }
            }
            return false;
        }
        return false;
    }

    public function insertData($equipment_id, $municipality_id, $quantity)
    {
        $equipment = Equipment::find($equipment_id);
        $record = CrossTransaction::where([
            'municipality_id' => auth()->user()->municipality_id,
            'equipment_id' => $equipment_id,
        ])->first();
            
        DB::transaction(function () use ($equipment, $equipment_id, $quantity, $record) {

            //if exist update, if not create
            if (!$record) {
                CrossTransaction::create([
                    'municipality_id' => auth()->user()->municipality_id,
                    'equipment_id' => $equipment_id,
                    'quantity' => $quantity,
                ]);
            } elseif ($record) {
                $record->quantity = $record->quantity + $quantity;
                $record->save();
            }
            $equipment->quantity =  $equipment->quantity - $quantity;
            $equipment->save();
        }, 3);


        $province = Province::find($this->UserService->getUserProvince(auth()->user()->municipality_id)->first()->id);
        MtoPTransactionEvent::dispatch($province);
        return;
    }
}
