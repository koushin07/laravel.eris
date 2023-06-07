<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Auth\Events\Registered;
use App\Listeners\SendNotifictionForReconfirm;
use App\Listeners\NotifyMunicipalityTransaction;
use App\Listeners\NotifyAdmin;
use App\Events\TransactionConfirmed;
use App\Events\NewMunicipalityTransaction;
use App\Events\BorrowRequestRecieve;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
       
        BorrowRequestRecieve::class => [
            NotifyMunicipalityTransaction::class,
            NotifyAdmin::class
        ],

        TransactionConfirmed::class =>[
            SendNotifictionForReconfirm::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
