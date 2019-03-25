<?php

namespace App\Listeners;

use App\Events\MechanicCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Pusher\PusherClient;

class MechanicCreatedFired
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
     * @param  MechanicCreated  $event
     * @return void
     */
    public function handle(MechanicCreated $event)
    {
        $pusher = PusherClient::getPusher();
        $data['message'] =  $event->message;
        $data['title'] =  'mechanic_created';
        $pusher->trigger('booking-channel', 'mechanic_created-event', $data);
    }
}
