<?php

namespace App\Services;

use Auth;
use App\Models\User;
use App\Models\Province;
use App\Models\Municipality;

class UserService
{

    public function getUserMunicipalityById($id)
    {
        return Municipality::select(['municipalities.id'])
            ->where('municipalities.id', '=', $id)->first();
    }

    public function getUserProvince($id)
    {

        return Province::select('provinces.id')
            ->join('municipalities', 'provinces.id', '=', 'municipalities.province_id')
            ->where('municipalities.id', $id);
            // ->join('equipment', 'municipalities.id', '=', 'municipalities.province_id');
        //    return Province::select(['provinces.id'])
        //    ->join('municipalities', 'provinces.id', '=', 'municipalities.province_id')
        //    ->where('municipalities.id', '=', $id)->first();
    }
}
