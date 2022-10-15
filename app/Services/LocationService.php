<?php
namespace App\Services;

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

    public function geo_location($office)
    {
        $provinces = collect([
            'mis_or' => collect([
                'Alubijid' => array('lat' => 8.570987484492505, 'long' => 124.47310579251179),
                'Balingasag ' => array('lat' => 8.742647289896173, 'long' => 124.77435680648715),
                'balingoan' => array('lat' => 9.00351802981955, 'long' => 124.85641295436021),
                'binuangan' => array('lat' => 8.921984622151621, 'long' => 124.7856545831952),
                'CDO' => array('lat' => 8.47676893229092, 'long' => 124.64136559723777),
                'claveria' => array('lat' => 8.620819700538966, 'long' => 124.9062569831937),
                'el_salvador' => array('lat' => 8.558615496844213, 'long' => 124.52698286969947),
                'gingoog' => array('lat' => 8.81648263094006, 'long' => 125.10364655435933),

            ]),
        ]);


        //check what province the auth belongs to
        $myProvince = $provinces->map(function ($province) {
            if ($province == $office) {
                return $province;
            }
        });

        return $myProvince;
    }

    public function getDistance()
    {
        $myProvince = $this->geo_location(auth()->user()->assign_office()->municipality);
        $myLocation = $myProvince->pluck(auth()->user()->assign_office()->municipality);
        $myProvince = $myProvince->except(auth()->user()->assign_office()->municipality);

       
        $ditances = array();
        foreach ($myProvince as $municipality) {
            $distance = $this->haversine(
                $myLocation['lat'],
                $myLocation['long'],
                $municipality['lat'],
                $municipality['long']
            );
           array_push($ditances, $distance);
        }
        sort($ditances);
        dd($ditances);
    }
}