<?php

namespace App\Services;

use Request;
use Illuminate\Support\Facades\DB;

use App\Services\UserService;
use App\Models\borrow;
use App\Models\User;
use App\Models\UnfinishTransaction;
use App\Models\Municipality;
use App\Models\EquipmentOwned;
use App\Models\EquipmentDetail;
use App\Models\Equipment;
use App\Models\Condition;
use App\Models\BorrowingDetails;
use App\Models\Borrowing;
use App\Models\EquipmentAttribute;
use Carbon\Carbon;

class EquipmentService
{



    public function checkEquipmentAttrs($data)
    {

        return EquipmentAttribute::where(
            [
                ['code', $data->code],
                ['asset_id', $data->asset_id],
                ['category', $data->category],
                ['unit', $data->unit],
                ['serial_number',  $data->serial_number],
                ['model_number', $data->model_number]

            ]
        )->first();
    }

    public function insertData($data)
    {

        DB::transaction(function () use ($data) {


            $equipmentAttrs = $this->checkEquipmentAttrs($data);

            if (is_null($equipmentAttrs)) {
                $newequipment = Equipment::firstOrCreate([
                    'name' => $data->equipment_name,
                    

                ],[
                    'recieved_at' => Carbon::parse($data->date)
                ]);

                $attrs = EquipmentAttribute::create([
                    'code' => $data->code,
                    'asset_desc' => $data->asset_desc,
                    'category' => $data->category,
                    'unit' => $data->unit,
                    'model_number' => $data->model_number,
                    'serial_number' => $data->serial_number,
                    'asset_id' => $data->asset_id,
                    'remarks' => $data->remarks,
                ]);

                $EOwner = EquipmentOwned::create([
                    'equipment_attrs'=> $attrs->id,
                    'equipment_id' => $newequipment->id,
                    'office_id' => auth()->id(),

                ]);
                $EDetail = EquipmentDetail::create([
                    'equipment_owner' => $EOwner->id,
                    'serviceable' => $data->serviceable,
                    'unserviceable' => $data->unserviceable,
                    'poor' => $data->poor
                ]);
            } else {
                $upCondition = EquipmentDetail::select(['equipment_details.*', 'equipment_owneds.*'])
                    ->join('equipment_owneds', 'equipment_details.equipment_owner', '=', 'equipment_owneds.id')
                    ->where([
                        ['equipment_owneds.equipment_attrs', $equipmentAttrs->id],
                        ['equipment_owneds.office_id', auth()->id()]
                    ])->first();

                if (!is_null($upCondition)) {

                    $upCondition->serviceable += $data->serviceable;
                    $upCondition->unserviceable += $data->unserviceable;
                    $upCondition->poor += $data->poor;
                    $upCondition->save();
                };
            }
        }, 3);
    }

    public function fulfillTransaction($data)
    {

        $equipment = EquipmentAttribute::select(['equipment_attributes.*'])->where(
            [
                ['code', $data->code],
                ['asset_id', $data->asset_id],
                ['unit', $data->unit],
                ['model_number',  $data->model_number],

            ]
        )
        ->join('equipment', 'equipment.id', '=', 'equipment_attributes.equipment_id')
        ->join('equipment_owneds', 'equipment_owneds.equipment_id', '=', 'equipment.id')
            ->where('equipment_owneds.office_id', '=', auth()->id())
            ->first();
            

        if (!is_null($equipment)) {

            DB::transaction(function () use ($data, $equipment) {

                $details = BorrowingDetails::find($data->id);
               
                $details->equipment_attrs = $equipment->id;
                $details->save();
              
                return 200;
            }, 3);
        } else {
            dd($data);
            return 404;
        }
    }
}
