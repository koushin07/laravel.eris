<?php

namespace App\Http\Controllers\Auth;

use Inertia\Inertia;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use App\Rules\MunicipalityRule;
use App\Providers\RouteServiceProvider;
use App\Models\User;

use App\Http\Controllers\Controller;
use App\Models\AssignOffice;
use App\Models\Office;
use App\Models\Province;
use App\Models\Role;
use App\Rules\ProvinceMustExistRule;
use App\Rules\ProvinceRule;
use Illuminate\Support\Facades\DB;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Inertia\Response
     */
    public function create()
    {

        return Inertia::render('Auth/Register', [
            'municipalities' => AssignOffice::select(['id', 'municipality'])->get(),
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {

        $request->validate(
            [
                'name' => 'required|string|max:255|unique:App\Models\Office,name',
                'email' => 'required|string|email|max:255|unique:offices',
                'password' => ['required', 'confirmed', Rules\Password::defaults()],

            ],
            [
                'name.unique' => 'this province is already registered'
            ]
        );

       
        DB::transaction(function() use($request){
            $role =  Role::where('role_type', Role::PROVINCE)->first();
            $assign = AssignOffice::create([
                'province' => $request->name
            ]);
            $user = Office::create([
                'name' => $request->name,
                'assign' => $assign->id,
                'email' => $request->email,
                'role_id' => $role->id,
                'password' => Hash::make($request->password),
            ]);
        });
    
        return redirect(RouteServiceProvider::ADMIN);
    }
    public function store_municipality(Request $request)
    {

        $request->validate([
            'email' => 'required|string|email|max:255|unique:offices',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'province' => ['required', 'exists:App\Models\AssignOffice,province'],
            'name' => 'required|string|max:255|unique:App\Models\Office,name',
            'lat' => ['required', 'numeric'],
            'long' => ['required', 'numeric']
        ]);

      

      
        DB::transaction(function() use($request){
            $role =  Role::where('role_type', Role::MUNICIPALITY)->first();
            $assign = AssignOffice::create([
                'municipality' => $request->name,
                'province'=> $request->province,
                'latitude'=> $request->lat,
                'longitude' => $request->long
            ]);
            $user = Office::create([
                'name' => $request->name,
                'assign' => $assign->id,
                'email' => $request->email,
                'role_id' => $role->id,
                'password' => Hash::make($request->password),
            ]);
        });
        

        // event(new Registered($user));


        return redirect(RouteServiceProvider::ADMIN);
    }
}
