<?php

namespace  App\Services;

use App\Models\Office;
use Illuminate\Support\Facades\DB;

class OfficeService
{
    public function ProvinceOffices()
    {
        return Office::select(['offices.*', 'assign_offices.province'])
            ->join('assign_offices', 'assign_offices.id', 'offices.assign')
            ->where([
                ['assign_offices.municipality', null], 
                ['assign_offices.province', auth()->user()->assign_office()->first()->province]
                ])
            ->first();
    }

    public function authMunicipalityProvince()
    {
        $myProvince = auth()->user()->assign_office()->first();

        $provinces = $this->ProvinceOffices();
        return  $provinces->firstWhere('province',  $myProvince->province);
    }
}
