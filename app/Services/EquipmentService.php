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

class EquipmentService
{

    

    public function checkEquipmentAttrs($data)
    {

        return Equipment::where(
            [
                ['equipment_name', $data->equipment_name],
                ['code', $data->code],
                ['asset_id', $data->asset_id],
                ['category', $data->category],
                ['unit', $data->unit],
                ['model_number',  $data->model_number],

            ]
        )->first();
    }

    public function insertData($data)
    {

        DB::transaction(function () use ($data) {


            $equipment = $this->checkEquipmentAttrs($data);



            if (is_null($equipment)) {
                $newequipment = Equipment::create([
                    'equipment_name' => $data->equipment_name,
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
                    'equipment_id' => $newequipment->id,
                    'office_id' => auth()->id(),

                ]);
                $EDetail = EquipmentDetail::create([
                    'equipment_owner' => $EOwner->id,
                    'serviceable' => $data->serviceable,
                    'unusable' => $data->unusable,
                    'poor' => $data->poor
                ]);
            } else {
                $upCondition = EquipmentDetail::select(['equipment_details.*', 'equipment_owneds.*'])
                    ->join('equipment_owneds', 'equipment_details.equipment_owner', '=', 'equipment_owneds.id')
                    ->where([
                        ['equipment_owneds.equipment_id', $equipment->id],
                        ['equipment_owneds.office_id', auth()->id()]
                    ])->first();

                if (!is_null($upCondition)) {

                    $upCondition->serviceable += $data->serviceable;
                    $upCondition->unusable += $data->unusable;
                    $upCondition->poor += $data->poor;
                    $upCondition->save();
                };
            }
        }, 3);
    }

    public function fulfillTransaction($data)
    {
        /*
 objectives
 KWAON ANG EQUIPMENT NGA NAA ANA NA PROPERTIES UBAN ANG OWNED EQUIPMENT
 */


        $equipment = Equipment::select(['equipment.*', 'equipment_owneds.office_id'])->where(
            [
                ['equipment_name', $data->equipment_name],
                ['code', $data->code],
                ['asset_id', $data->asset_id],

                ['unit', $data->unit],
                ['model_number',  $data->model_number],

            ]
        )->join('equipment_owneds', 'equipment_owneds.equipment_id', '=', 'equipment.id')
            ->where('equipment_owneds.office_id', '=', auth()->id())
            ->first();

        if (!is_null($equipment)) {

            DB::transaction(function () use ($data, $equipment) {

                $unfinish = UnfinishTransaction::find($data->id);

                $borrowing = Borrowing::create([
                    'borrower' => $unfinish->borrower,
                ]);
                $EquipOwned = EquipmentOwned::query()
                    ->where([
                        ['office_id', $unfinish->owner],
                        ['equipment_id', $equipment->id]
                    ])->first();

                $details = BorrowingDetails::create([
                    'equipment_owned_id' => $EquipOwned->id,
                    'quantity' => $data->quantity,
                    'borrowing_id' => $borrowing->id,
                ]);

                $unfinish->delete();
                return 200;
            }, 3);
        } else {
            dd($data);
            return 404;
        }
    }
}
