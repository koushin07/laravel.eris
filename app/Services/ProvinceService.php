<?php

namespace App\Services;

use App\Services\UserService;
use App\Models\User;
use App\Models\Province;
use App\Models\Municipality;

class ProvinceService
{
    protected $UserService;

    public  function __construct(UserService $UserService)
    {
        $this->UserService = $UserService;
    }
    public function getProvinceAll()
    {
        return Province::all();
    }

    public function getProvinceName()
    {
        return Province::get(['province_name']);
    }

    public function getProvinceById($id)
    {
        return Province::find($id);
    }

    public function getProvinceByName($name)
    {
        return Province::where('province_name', $name);
    }

    public function getProvinceMunicipalities($id)
    {
        return Municipality::where('province_id', $id);
    }

    public function getProvinceUser($id)
    {
       
        return User::select(['provinces.id'])
            ->join('municipalities', 'users.municipality_id', '=', 'municipalities.id')
            ->join('provinces', 'municipalities.province_id', '=', 'provinces.id')
            ->where('users.id', $id)->first();
    }

    public function filteredByStatusProvinceEquipment($param, $condition = 'no count' )
    {
        
        
        if($condition == 'count'){
           
            return Province::withCount(['equipment' => function ($q) use ($param) {
               
                return $q->where('status', '=', $param);
            }])
                ->where('id',  auth()->user()->province_id)
                ->get();
        }
        if($condition == 'no count'){
            return Municipality::with(['equipment' => function ($q) use ($param) {
               
                return $q->where('status', '=', $param);
            }])
                ->where('province_id',  $this->getProvinceUser(auth()->id())->id)
                ->get();
        }
       
    }
}
