<?php

namespace App\Listeners;

use App\Events\MechanicConfirmation;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Pusher\PusherClient;

class MechanicConfirmationFired
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
     * @param  MechanicConfirmation  $event
     * @return void
     */
    public function handle(MechanicConfirmation $event)
    {
        $pusher = PusherClient::getPusher();

        $data['message'] =  $event->message;
        $data['title'] =  'mech_confirmation';
        $pusher->trigger('booking-channel', 'mech_confirmation-event', $data);
    }
}
