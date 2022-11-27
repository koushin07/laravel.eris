<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Office;

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

    public function fetchAvailableOffices($equipments, $provinces)
    {

        return Office::select(
            DB::raw('offices.name as owner'),
            DB::raw('offices.address as owner_address'),
            DB::raw('offices.contact as owner_contact'),
            DB::raw('ao.municipality as municipality'),
            DB::raw('ao.province as province'),
            'ao.province',
            DB::raw('e.name as equipment'),
            'e.id',
            DB::raw('offices.id as owner_id'),
            DB::raw('sum(ed.serviceable) as serviceable'),
            'ao.latitude',
            'ao.longitude'
        )
            ->join('equipment_owneds as oe', DB::raw('oe.office_id'), '=', 'offices.id')
            ->join('equipment_details as ed', DB::raw('ed.equipment_owner'), '=', DB::raw('oe.id'))
            ->join('equipment as e', DB::raw('e.id'), '=', DB::raw('oe.equipment_id'))
            ->join('assign_offices as ao', DB::raw('ao.id'), '=', 'offices.assign')
            ->whereNot('offices.assign', auth()->user()->assign)
            ->whereIn(DB::raw('e.name'), $equipments)
            ->WhereIn(DB::raw('ao.province'), $provinces)
            ->groupBy(['equipment', 'province'])
            ->get();
        // return  DB::select(
        //     "SELECT
        //      o.name AS owner,
        //     e.name,
        //     e.id,
        //     o.id as owner_id,
        //     SUM(ed.serviceable) as serviceable,
        //     ao.latitude,
        //     ao.longitude
        // FROM
        //     offices o
        //     JOIN equipment_owneds oe ON oe.office_id = o.id
        //     JOIN equipment_details ed ON ed.equipment_owner = oe.id
        //     JOIN equipment e ON e.id = oe.equipment_id
        //     JOIN assign_offices ao ON ao.id = o.assign
        // where
        //     e.name = :equipment
        //     AND NOT o.assign = :id
        //     GROUP BY
        //     owner",
        //     [
        //         'id' => auth()->user()->assign,
        //         'equipment' => $equipment
        //     ],
        //     false

        // );
    }

    public function fetchCrossOffices($equipment)
    {
        return Office::select(
            DB::raw('offices.name as owner'),
            DB::raw('offices.address as owner_address'),
            DB::raw('offices.contact as owner_contact'),
            DB::raw('ao.municipality as municipality'),
            'ao.province',
            'e.name',
            'e.id',
            DB::raw('offices.id as owner_id'),
            DB::raw('sum(ed.serviceable) as serviceable'),
            'ao.latitude',
            'ao.longitude'
        )
            ->join('equipment_owneds as oe', DB::raw('oe.office_id'), '=', 'offices.id')
            ->join('equipment_details as ed', DB::raw('ed.equipment_owner'), '=', DB::raw('oe.id'))
            ->join('equipment as e', DB::raw('e.id'), '=', DB::raw('oe.equipment_id'))
            ->join('assign_offices as ao', DB::raw('ao.id'), '=', 'offices.assign')
            ->where('e.name', $equipment)
            ->whereNot('offices.assign', auth()->user()->assign)
            ->groupBy(['owner', ''])
            ->get();
    }

    public function getDistance($equipment, $provinces)
    {
        
        $distance = collect();
        $myDistance = auth()->user()->assign_office()->first(['latitude', 'longitude']);
        if (empty($provinces)) {
            
            $data = $this->fetchCrossOffices($equipment);
          
        } else {
            $data = $this->fetchAvailableOffices($equipment, $provinces);
            
        }


        foreach ($data as $datum) {

            $distance->push(
                [
                    "municipality" => $datum->municipality,
                    'owner_address' => $datum->owner_address,
                    'owner_contact' =>$datum->owner_contact,
                    'owner' => $datum->owner,
                    'province' => $datum->province,
                    'equipment'=>$datum->equipment,
                    "municipality_id" => $datum->owner_id,
                    "distance" => round($this->haversine(
                        $myDistance->latitude,
                        $myDistance->longitude,
                        $datum->latitude,
                        $datum->longitude,
                    ), 2),
                    "quantity" => $datum->serviceable
                ]
            );
        }
        $sorted = $distance->sortBy('distance');
        return $sorted->values()->all();
    }
}
