<?php

namespace App\Http\Controllers\Auth;

use App\Events\NewOfficeRegistered;
use App\Rules\MunicipalityAlreadyRegistered;
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

            'provinces' => AssignOffice::select(['id', 'province'])
                ->whereNull('municipality')->whereNotNull('province')->get()

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

        $request->validate([
            'email' => 'required|string|email|max:255|unique:offices',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'firstname' => 'required',
            'lastname' => 'required',
            'contact' => 'required',
            'address' => 'required',
            'province' => ['required', new MunicipalityAlreadyRegistered],


        ]);


        DB::transaction(function () use ($request) {
            $role =  Role::where('role_type', Role::PROVINCE)->first();
            $assign = AssignOffice::create([
                'province' => $request->name
            ]);
            $user = Office::create([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'middlename' => $request->middlename,
                'suffix' => $request->suffix,
                'assign' => $request->province,
                'email' => $request->email,
                'address' => $request->address,
                'contact' => $request->contact,
                'role_id' => $role->id,
                'password' => Hash::make($request->password),
            ]);
            $office = collect([
                'id' => $user->id,
                'personnel' => $user->firstname . ' ' . $user->middlename . ' ' . $user->lastname . ' ' . $user->suffix,
                'email' => $user->email,
                'role' => $role->role_type,
                'assign' => $assign->province

            ]);
            NewOfficeRegistered::dispatch($office);
        });

        return redirect('/');
    }
    public function store_municipality(Request $request)
    {

        $request->validate([
            'email' => 'required|string|email|max:255|unique:offices',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'firstname' => 'required',
            'lastname' => 'required',
            'contact' => 'required',
            'address' => 'required',
            'municipality' => ['required', new MunicipalityAlreadyRegistered],

            // 'lat' => ['required', 'numeric'],
            // 'long' => ['required', 'numeric']
        ]);




        DB::transaction(function () use ($request) {
            $role =  Role::where('role_type', Role::MUNICIPALITY)->first();
            // $assign = AssignOffice::create([
            //     'municipality' => $request->name,
            //     'province' => $request->province,
            //     'latitude' => $request->lat,
            //     'longitude' => $request->long
            // ]);
            $user = Office::create([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'middlename' => $request->middlename,
                'suffix' => $request->suffix,
                'assign' => $request->municipality,
                'email' => $request->email,
                'address' => $request->address,
                'contact' => $request->contact,
                'role_id' => $role->id,
                'password' => Hash::make($request->password),
            ]);
            $assign = AssignOffice::find($request->municipality);
            $office = collect([
                'id' => $user->id,
                'personnel' => $user->firstname . ' ' . $user->middlename . ' ' . $user->lastname . ' ' . $user->suffix,
                'email' => $user->email,
                'role' => $role->role_type,
                'assign' => $assign->municipality

            ]);
            NewOfficeRegistered::dispatch($office);
        });


        // event(new Registered($user));


        return redirect('/');
    }
}
