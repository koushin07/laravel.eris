<?php

namespace App\Http\Controllers\Municipality;

use App\Http\Controllers\Controller;
use App\Models\Municipality;
use Illuminate\Http\Request;

class MunicipalityController extends Controller
{
    public function allMuniciplity($id)
    {
        return Municipality::where('province_id', $id)->get();
    }
}
