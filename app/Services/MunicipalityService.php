<?php

namespace App\Services;

use App\Models\Municipality;

class MunicipalityService
{

    public function getMunicipalityAll()
    {
        return Municipality::all();
    }

    public function getMunicipalityName()
    {
        return Municipality::select(['municipality_name']);
    }

    public function getMunicipalityById($id)
    {
        return Municipality::find($id);
    }

    

    public function getMunicipalityByName($name)
    {
        return Municipality::where('municipality_name', $name);
    }

    public function isMunicipalityNull($value)
    {
        if (!$value) {
            return null;
        }
        return $value->id;
    }

    
}
