<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Notification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Events\TransactionConfirmed;
use App\Notifications\ReconfirmationNotification;

class SendNotifictionForReconfirm 
{
 
    public function handle(TransactionConfirmed $event)
    {
           Notification::send(
            $event->office,
            new ReconfirmationNotification($event->office)
        );
    }
}
