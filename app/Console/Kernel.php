<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\SendNotifyMail::class,
        Commands\KeepAlertMechanic::class,
        Commands\KeepAlertUserForSchedule::class,
        Commands\KeepAlertUserForHoliday::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule) {
        /*
          $schedule->command('send-notification:mail')
          ->daily();
         */

        //$schedule->command('Alert:UsersHoliday')->daily();

        $schedule->command('alert:user')
                ->twiceDaily(8, 17);

        $schedule->command('alert:mechanic')
                ->hourly();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands() {
        require base_path('routes/console.php');
    }

}
