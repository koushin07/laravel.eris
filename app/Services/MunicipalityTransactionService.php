<?php

namespace App\Services;

use phpDocumentor\Reflection\Types\Boolean;
use Illuminate\Support\Facades\DB;
use App\Services\EquipmentService;
use App\Models\MunicipalityTransaction;
use App\Models\Municipality;
use App\Models\Equipment;
use App\Events\SendMunicipalityRequest;
use App\Events\NewMunicipalityTransaction;
use App\Models\Borrowing;
use App\Models\BorrowingDetails;
use App\Models\Condition;

class MunicipalityTransactionService
{

    protected $EquipmentService;

    public $returnRecord = array();

    public function __construct(EquipmentService $EquipmentService)
    {

        $this->EquipmentService = $EquipmentService;
    }

    public function isEquipmentAvailable($request)
    {

        //this will get the requested serviceable equipment  within the requested municipality 
        $equipments = $this->EquipmentService->getMunicipalityEquipment(
            $request['municipality_name'],
            $request['equipment_name']
        )->get();

        //check if equipment is available 
        // dd($equipments, $request->equipment);
        if ($equipments->isEmpty()) {
            return false;
        }

        //will get data from borrow table that has the id of the requested muni and equip
        // $borrows = $this->borrowedEquipment(
        //     $request->municipality,
        //     $request->equipment
        // )->get();


        // //check if the request is borrowed
        // if (!$borrows->isEmpty()) {
        //     dd( $borrows);
        //     // filter by returned all the fetched data 
        //     $filtered = $this->filterEquipmentReturned($borrows); //this is array
        //     //if null means the equipment is borrowed but not yet return



        foreach ($equipments as $equipment) {

            if ($equipment->quantity != 0 && $equipment->quantity >= $request['quantity']) {

                // dd($equipment->quantity, $request->quantity);

                // dd('goods');
                $this->insertData(
                    $equipment->id,
                    $equipment->municipality_id,
                    $request['quantity'],

                );
                return true;

                //soft delete borrow id
                // return array('equipment_id' => $equipment->id,'borrow_id' => $value->id, 'owner' => $equipment->muncipality_id);

            }
            return false;
        }

        return true;
        // } else {

        //     $setup =  Equipment::where('equipment_name', $request->equipment)->first();
        //     $this->insertData($setup->id, $setup->municiaplity_id, $request->quantity);
        //     // return array('equipment_id' => $setup->id, 'borrow_id' => '', 'owner' => $setup->municipality_id);
        // }
    }

    public function borrowedEquipment($municipality, $equipment)
    {
        return Municipality::select(['municipality_transactions.equipment_id', 'municipality_transactions.id', 'municipality_transactions.returned'])
            ->where('municipalities.municipality_name', '=', $municipality)
            ->join('equipment', 'municipalities.id', '=', 'equipment.municipality_id')
            ->where('equipment.equipment_name', '=', $equipment)
            ->join('municipality_transactions', 'equipment.id', '=', 'municipality_transactions.equipment_id')
            ->where('municipality_transactions.deleted_at', '=', null);
    }

    public function filterEquipmentReturned($records)
    {
        //is it returned?
        foreach ($records as $record) {
            if ($record->returned) { //not null or empty
                $this->returnRecord[] = $record;
            }
        }
        return $this->returnRecord;
    }

    public function insertData($equipment_id, $municipality_id, $quantity)
    {
        

        /* get data to the equipment table */
        $equipment = Equipment::find($equipment_id);

        /* check if the same equipment are barrowed by the same municipalty */
        $record = MunicipalityTransaction::where([
            'municipality_id' => auth()->user()->municipality_id,
            'equipment_id' => $equipment_id,
        ])->first();

        DB::transaction(function () use ($equipment, $equipment_id, $quantity, $record) {

            if (!$record) {
                /* insert new data to the municipality_transactions */
                MunicipalityTransaction::create([
                    'municipality_id' => auth()->user()->municipality_id,
                    'equipment_id' => $equipment_id,
                    'quantity' => $quantity,
                ]);
            } elseif ($record) {
                if ($record->quantity == 0)
                    /* fetch the data from municipality_transactions table and update its quantity (old quantity) + (new quanity request) */
                    $record->quantity = $record->quantity + $quantity;
                $record->save();
            }
            /* fetch the data from equipment table and update its quantity */
            $equipment->quantity =  $equipment->quantity - $quantity;
            $equipment->save();
        }, 3);


        /* fetch the owner of the equipment borrowed */
        $owner = Municipality::find($municipality_id);

        $borrow = Equipment::find($equipment_id);

        $toNotify = collect([
            'owner' => $owner,
            'borrow' => $borrow
        ]);
        /* fire event */
        NewMunicipalityTransaction::dispatch($toNotify);
    }
    // DB::select("SELECT municipalities.* FROM municipalities
    //     WHERE municipalities.id = (SELECT equipment.municipality_id 
    //     FROM equipment WHERE equipment.id = :equip_id);", [
    //         'equip_id' => $equipment_id,])[0]
}
