<?php

namespace App\Services;

use Request;
use App\Services\UserService;

use App\Models\borrow;
use App\Models\User;
use App\Models\Municipality;
use App\Models\Equipment;
use Illuminate\Support\Facades\DB;

class EquipmentService
{

    protected $UserService;

    public function __construct(UserService $UserService)
    {
        $this->UserService = $UserService;
    }


    public function getEquipmentByName($name)
    {
        return Equipment::where('equipment_name', $name);
    }

    public function getEquipmentStatus($status = 'serviceable')
    {
        return Equipment::where('status', $status);
    }

    public function getEquipmentByMunicipalityId($id)
    {
        return Equipment::select('equipment.*')
            ->where('equipment.municipality_id', $id);
    }


    public function getMunicipalityEquipment($municipality, $equipment, $by = 'name')
    {
        if ($by == 'name') {
            return Equipment::select(
                [
                    'equipment.municipality_id',
                    'equipment.id',
                    'equipment.equipment_name',
                    'equipment.quantity'
                ]
            )
                ->where('equipment.equipment_name', '=', $equipment)
                ->join('municipalities', 'equipment.municipality_id', '=', 'municipalities.id')
                ->where('municipalities.municipality_name', '=', $municipality)
                ->join('provinces', 'municipalities.province_id', '=', 'provinces.id');
        } elseif ($by == 'id') {
            return Equipment::select(
                [
                    'equipment.municipality_id',
                    'equipment.id',
                    'equipment.equipment_name',
                    'municipalities.municipality_name'
                ]
            )
                ->where('equipment.id', '=', $equipment)
                ->join('municipalities', 'equipment.municipality_id', '=', 'municipalities.id')
                ->where('municipalities.id', '=', $municipality)
                ->join('provinces', 'municipalities.province_id', '=', 'provinces.id');
        }
    }

    public function checkIfExist($data)
    {
       
        $equipment= Equipment::where(
            [
                ['code', $data['code']],
                ['asset_id', $data['asset_id']],
                ['unit', $data['unit']],
                ['model_number', $data['model_number']],
                ['serial_number', $data['serial_number']]
            ])->first();

            if($equipment){
                return false;
            }
            $this->insertData($data);
            return true;
    }

    public function insertData($data)
    {



        Equipment::create([
            'equipment_name' => $data['equipment_name'],
            'municipality_id' => auth()->user()->municipality_id,
            'code' => $data['code'],
            'asset_desc' => $data['asset_desc'],
            'category' => $data['category'],
            'unit' => $data['unit'],
            'model_number' => $data['model_number'],
            'serial_number' => $data['serial_number'],
            'status' => $data['status'],
            'asset_id' => $data['asset_id'],
            'remarks' => $data['remarks'],
            'quantity' => $data['quantity'],
        ]);

        // dd($record);
        // if ($record) {
        //     $record->quantity = $record->quantity + $data['quantity'];
        //     $record->save();

        // }



    }
}
