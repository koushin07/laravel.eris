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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = Office::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
    public function store_municipality(Request $request)
    {

        $request->validate([
            'email' => 'required|string|email|max:255|unique:offices',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'municipality_id' => [new MunicipalityRule]

        ]);

        // dd($request->municipality_id);


        //   dd('here');
        $user = Office::create([
            'name' => $request->name,
            'assign' => $request->municipality_id,
            'email' => $request->email,
            'role_id' => 1,
            'password' => Hash::make($request->password),
        ]);

        // event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
