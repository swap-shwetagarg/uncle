<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use App\Utility\BookingStatus;
use Carbon\Carbon;
use Event;
use App\Events\AlertMechanic;

class KeepAlertMechanic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alert:mechanic';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It will notify mechanic before 1 hour from booking time for assigned Booking';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(){
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(){
        $booking_collection = Booking::whereStatus(BookingStatus::SCHEDULED)->get();
        if($booking_collection->isNotEmpty()){
            foreach ($booking_collection as $booking) {
                $booked_from = new Carbon($booking->bookingMechanic->booked_from);
                $now = Carbon::now();
                $difference = $booked_from->diffInHours($now);
                if($difference == 1){
                    Event::fire(new AlertMechanic($booking));
                }
            }
        }
    }
}
