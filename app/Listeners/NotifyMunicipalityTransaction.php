<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\NewMunicipalityTransaction;
use App\Notifications\MunicipalityTransactionNotification;
use Illuminate\Support\Facades\Notification;

class NotifyMunicipalityTransaction
{
    
    public function handle(NewMunicipalityTransaction $event)
    {
     Notification::send($event->toNotify, new MunicipalityTransactionNotification($event->toNotify));
    }
}
