<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use App\Utility\BookingStatus;
use Carbon\Carbon;
use Event;
use App\Helpers\UpcomingBookings;
use App\Events\AlertNotificationToUserForSchedule;

class KeepAlertUserForSchedule extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alert:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It will notify user for few hours from the quoted time to schedule thier booking';

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
        $bookings = UpcomingBookings::getUserBookingQuoted();
        if (count($bookings) > 0) {
            foreach ($bookings as $booking) {
                //$booking = new Booking($booking->toArray());
                Event::fire(new AlertNotificationToUserForSchedule($booking));
            }
        }
    }

}
