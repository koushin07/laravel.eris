<?php

namespace App\Http\Controllers\Province;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    
    public function dashboard()
    {
        return inertia('Province/Dashboard');
    }
}
