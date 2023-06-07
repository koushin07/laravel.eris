<?php

namespace App\Console;

use App\Models\Borrowing;
use App\Models\BorrowingDetails;
use App\Models\EquipmentBorrow;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('model:prune', [
            '--model' => [EquipmentBorrow::class]
        ]);
        $schedule->command('model:prune', [
            '--model' => [BorrowingDetails::class]
        ])->everyMinute();
        $schedule->command('model:prune', [
            '--model' => [Borrowing::class]
        ]);
        // $schedule->command('inspire')->hourly();

       
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
