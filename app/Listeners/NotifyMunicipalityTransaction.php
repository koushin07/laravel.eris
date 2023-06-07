<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Notification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\MunicipalityTransactionNotification;
use App\Events\NewMunicipalityTransaction;
use App\Events\BorrowRequestRecieve;

class NotifyMunicipalityTransaction
{

    public function handle(BorrowRequestRecieve $event)
    {
       
        Notification::sendNow(
            $event->office,
            new MunicipalityTransactionNotification($event->office)
        );
    }
}
