<?php

namespace App\Listeners;

use App\Events\StatusLiked;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Pusher\PusherClient;

class PusherEventListener
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
     * @param  StatusLiked  $event
     * @return void
     */
    public function handle(StatusLiked $event)
    {
        $pusher = PusherClient::getPusher();

        $data['message'] =  $event->message;
        $data['title'] =  'booking';
        $pusher->trigger('booking-channel', 'booking-event', $data);
    }
}
