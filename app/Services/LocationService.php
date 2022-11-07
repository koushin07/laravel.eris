<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class LocationService
{

    public function haversine($latitude1, $longitude1, $latitude2, $longitude2)
    {

        $earth_radius = 6371;
        // 3958.756 for miles

        $dLat = deg2rad($latitude2 - $latitude1);
        $dLon = deg2rad($longitude2 - $longitude1);

        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * asin(sqrt($a));
        $d = $earth_radius * $c;

        return $d;
    }

    public function fetchAvailableOffices($quantity, $equipment)
    {

        return  DB::select(
            "SELECT
             o.name AS owner,
            e.equipment_name,
            o.id as owner_id,
            SUM(ed.serviceable) as serviceable,
            ao.latitude,
            ao.longitude
        FROM
            offices o
            JOIN equipment_owneds oe ON oe.office_id = o.id
            JOIN equipment_details ed ON ed.equipment_owner = oe.id
            JOIN equipment e ON e.id = oe.equipment_id
            JOIN assign_offices ao ON ao.id = o.assign
        where
            e.equipment_name = :equipment
            AND ed.serviceable >:quantity
            AND ao.province = :province
            AND NOT o.assign = :id
            GROUP BY
            owner",
            [
                'province' => auth()->user()->assign_office()->first('province')->province,
                'id' => auth()->user()->assign,
                'quantity' => $quantity,
                'equipment' => $equipment
            ],
            false

        );
    }

    public function fetchCrossOffices($quantity, $equipment)
    {
        return  DB::select(
            "SELECT 
                        e.*, 
                        o.name AS owner,
                        o.id as owner_id,
                        SUM(ed.serviceable) as serviceable, 
                        ao.latitude,
                        ao.longitude 
                        FROM equipment e
                            JOIN equipment_owneds oe ON oe.equipment_id = e.id
                            JOIN equipment_details ed ON ed.equipment_owner = oe.id
                            JOIN offices o ON o.id = oe.office_id
                            JOIN assign_offices ao ON ao.id = o.assign
                                where e.equipment_name =:equipment
                                AND     
                                ed.serviceable > :quantity 
                                AND NOT
                                o.assign =:id 
                                GROUP BY owner",
            [
                'id' => auth()->user()->assign,
                'quantity' => $quantity,
                'equipment' => $equipment
            ]
        );
    }

    public function getDistance($name, $quantity, $mode = 'local')
    {
        //fetch data
        //calculate data
        $distance = collect();
        $myDistance = auth()->user()->assign_office()->first(['latitude', 'longitude']);

        if ($mode == 'local') {
            $data = $this->fetchAvailableOffices($quantity, $name);
            
        } elseif ($mode == 'regional') {
            $data = $this->fetchCrossOffices($quantity, $name);
        }

        foreach ($data as $datum) {

            $distance->push(
                [
                    "municipality" => $datum->owner,
                    "municipality_id" => $datum->owner_id,
                    "distance" => round($this->haversine(
                        $myDistance->latitude,
                        $myDistance->longitude,
                        $datum->latitude,
                        $datum->longitude,
                    ), 2) ,
                    "quantity" => $datum->serviceable
                ]
            );
        }
        $sorted = $distance->sortBy('distance');
        return $sorted->values()->all();
    }
}
