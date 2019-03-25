<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\App;

class BookingMail extends Mailable {

    use Queueable,
        SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $event;

    public function __construct($event) {
        $this->event = $event;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        $data = $this->event;
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
        $subject = $data['heading'];

        return $this->from($address, $name)
                        //->cc($cc_address, $name)
                        //->bcc($bcc_address, $name)
                        ->replyTo($address, $name)
                        ->subject($subject, $this->event)
                        ->view('email.booking.booking_page');
    }

}
