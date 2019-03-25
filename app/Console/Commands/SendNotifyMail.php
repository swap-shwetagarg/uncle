<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Notification;
use App\Notifications\AlertNotification;
use App\Helpers\UpcomingBookings;
use Event;
use App\Events\AlertNotificationToUser;

class SendNotifyMail extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send-notification:mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It will notify User to get other Service from the Uncle Fitter';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        $dates = UpcomingBookings::getUsers();
        if (count($dates) > 0) {
            foreach ($dates as $val) { // Booking Object
                $nextDate = UpcomingBookings::CaluculateNextDate($val);
                if (count($nextDate) > 0 && $nextDate !== false) {
                    Event::fire(new AlertNotificationToUser($val, $nextDate));
                    $this->info($val->getUser->name . ' will get email from us by ' . Carbon::now() . ' Thank You....');
                }
            }
        }
    }

}
