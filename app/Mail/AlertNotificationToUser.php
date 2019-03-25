<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\App;

class AlertNotificationToUser extends Mailable {

    use Queueable,
        SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $booking;
    public $nextDate;

    public function __construct($booking, $nextDate) {
        $this->booking = $booking;
        $this->nextDate = $nextDate;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        $name = 'Uncle Fitter';

        if (App::environment('local')) {
            $address = 'unclefitter@encoresky.com';
            $cc_address = 'unclefitter@encoresky.com';
        } elseif (App::environment('development')) {
            $address = 'unclefitter@encoresky.com';
            $cc_address = 'unclefitter@encoresky.com';
        } elseif (App::environment('production')) {
            $address = 'accts@unclefitter.com';
            $cc_address = 'info@unclefitter.com';
        }
        $bcc_address = 'info@encoresky';
        $subject = 'Your Next Booking Alert';

        return $this->from($address, $name)
                        //->cc($cc_address, $name)
                        //->bcc($bcc_address, $name)
                        ->replyTo($address, $name)
                        ->subject($subject, $this)
                        ->view('email.booking.alertToUser');
    }

}
