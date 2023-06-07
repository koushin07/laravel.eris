<?php

namespace App\Http\Middleware;

use Tightenco\Ziggy\Ziggy;
use Inertia\Middleware;
use Illuminate\Http\Request;
use App\Models\Municipality;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        // 'notification' =>(Municipality::find(auth()->user()->municipality_id))->unreadNotifications,
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user() ? $request->user()->load(['role', 'assign_office']) :$request->user(),
              
            ],
            'csrf_token' =>$request->session()->token(),
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
            'flash' => [
                'message' => fn () => $request->session()->get('message')
            ],
            
        ]);
    }
}
