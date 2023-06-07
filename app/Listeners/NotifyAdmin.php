<?php

namespace App\Listeners;

use App\Models\Office;
use App\Models\Role;
use App\Notifications\SendNotifToAdmin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class NotifyAdmin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $admin = Office::select('offices.*')->join('roles', 'roles.id', '=', 'offices.role_id')->where('roles.role_type', '=', Role::ADMIN)->first();
        Notification::sendNow($admin, new SendNotifToAdmin());
    }
}
