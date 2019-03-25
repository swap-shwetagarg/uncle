<?php

namespace App\Listeners;

use App\Events\ConfirmedBooking;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Pusher\PusherClient;
use App\Mail\ConfirmBookingAlert;
use Mail;
use Illuminate\Support\Facades\App;

class ConfirmedBookingFired
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ConfirmBooking  $event
     * @return void
     */
    public function handle(ConfirmedBooking $event)
    {
        $pusher = PusherClient::getPusher();

        $data['message'] =  $event->message;
        $data['title'] =  'confirm';
        $pusher->trigger('booking-channel', 'confirm-event', $data);
        
        if (App::environment('local')) {
            Mail::to('unclefitter@encoresky.com')->send(new ConfirmBookingAlert($event->booking));
        } elseif (App::environment('development')) {
            Mail::to('unclefitter@encoresky.com')->send(new ConfirmBookingAlert($event->booking));
        } elseif (App::environment('production')) {
            Mail::to('accts@unclefitter.com')->send(new ConfirmBookingAlert($event->booking));
        }
    }
}
