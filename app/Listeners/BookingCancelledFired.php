<?php

namespace App\Listeners;

use App\Events\BookingCancelled;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;
use App\Mail\CancelBookingAlert;
use Illuminate\Support\Facades\App;

class BookingCancelledFired extends BaseListener implements ShouldQueue {

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    /**
     * Handle the event.
     *
     * @param  BookingCancelled  $event
     * @return void
     */
    public function handle(BookingCancelled $event) {
        $existMechanic = $event->booking->bookingMechanic;
        if(!is_null($existMechanic)){
            $mechanicDevices = $existMechanic->mechanic->getDevice;
            $role = $event->booking->bookingMechanic->mechanic->getRole->first();
            if ($mechanicDevices->isNotEmpty()) {
                foreach ($mechanicDevices as $mechanicDevice) {
                    parent::sendNotification($mechanicDevice, $event->message,$role);
                }
            }
            
            $data['booking'] = ['booking_id' => $event->booking->id];
            $mechanic = $existMechanic->mechanic;
            if (!is_null($mechanic)) {
                Mail::send('email.booking.cancelled_booking', $data, function($message) use($mechanic) {
                    $message->to($mechanic->email, $mechanic->name)->subject('Booking cancelled');
                });
            }
        }        
        if (App::environment('local')) {
            Mail::to('unclefitter@encoresky.com')->send(new CancelBookingAlert($event->booking));
        } elseif (App::environment('development')) {
            Mail::to('unclefitter@encoresky.com')->send(new CancelBookingAlert($event->booking));
        } elseif (App::environment('production')) {
            Mail::to('accts@unclefitter.com')->send(new CancelBookingAlert($event->booking));
        }
    }

}
