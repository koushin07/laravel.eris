<?php

namespace App\Http\Controllers\Municipality;

use App\Http\Controllers\Controller;
use App\Models\AssignOffice;


class MunicipalityController extends Controller
{
    public function allMuniciplity($province)
    {
        return response()->json(AssignOffice::where('province', $province)->whereNotNull('municipality')->get());
    }
}
