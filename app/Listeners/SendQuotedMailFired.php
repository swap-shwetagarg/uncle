<?php

namespace App\Listeners;

use App\Events\SendQuotedMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\SendQuoted;
use Mail;

class SendQuotedMailFired
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
     * @param  SendQuotedMail  $event
     * @return void
     */
    public function handle(SendQuotedMail $event)
    {
        Mail::to($event->event['details']->getUser->email)->send(new SendQuoted($event->event));
    }
}
