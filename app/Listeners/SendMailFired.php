<?php

namespace App\Listeners;

use App\Events\SendMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;
use App\Mail\BookingMail;
use Auth;
use Illuminate\Support\Facades\App;

class SendMailFired {

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct() {
        
    }

    /**
     * Handle the event.
     *
     * @param  SendMail  $event
     * @return void
     */
    public function handle(SendMail $event) {

        $flag = true;
        foreach ($event as $data) {
            if ($flag === true) {
                $user['data'] = $data;
                $admin['data'] = $data;

                $user['heading'] = 'Your request';
                $user['info'] = 'Your request is in process. We will get back with your quotation ....Thank You';
                Mail::to(Auth::user()->email)->send(new BookingMail($user));

                $admin['heading'] = 'User Booking';
                $admin['info'] = "Here is the Booking Details of User's";

                if (App::environment('local')) {
                    Mail::to('unclefitter@encoresky.com')->send(new BookingMail($admin));
                } elseif (App::environment('development')) {
                    Mail::to('unclefitter@encoresky.com')->send(new BookingMail($admin));
                } elseif (App::environment('production')) {
                    Mail::to('accts@unclefitter.com')->send(new BookingMail($admin));
                }
                $flag = false;
            }
        }
    }

}
