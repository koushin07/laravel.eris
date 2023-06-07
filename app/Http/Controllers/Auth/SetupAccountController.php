<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Models\Role;
use App\Http\Controllers\Controller;
use App\Models\Office;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Hash;

class SetupAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return inertia('Auth/SetupAccount');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'contact' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'address' => 'required',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
    
        $office = auth()->user()->update([
           
            'email' => $request->email,
            'contact' => $request->contact,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'middlename'=> $request->middlename,
            'suffix' => $request->suffix,
            'address' => $request->address,
            'must_reset_password' => 0,
            'password' =>  Hash::make($request->password)
        ]);
       
        if (auth()->user()->role()->where('role_type', Role::PROVINCE)->exists()) {
            return redirect(RouteServiceProvider::PROVINCE);
        }

        return redirect(RouteServiceProvider::HOME);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
