<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Closure;
use App\Providers\RouteServiceProvider;
use App\Models\Role;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {

                
                if (Auth::user()->role()->where('role_type', Role::ADMIN)->exists()) {
                    return redirect(RouteServiceProvider::ADMIN);
                } elseif (Auth::user()->role()->where('role_type', Role::PROVINCE)->exists()) {
                    return redirect(RouteServiceProvider::PROVINCE);
                } else {
                    return redirect(RouteServiceProvider::HOME);
                }
            }
        }

        return $next($request);
    }
}
