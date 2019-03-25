<?php

namespace App\Listeners;

use App\Events\BookingComplete;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Pusher\PusherClient;

class BookingCompleteFire
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
     * @param  BookingComplete  $event
     * @return void
     */
    public function handle(BookingComplete $event)
    {
        $pusher = PusherClient::getPusher();

        $data['message'] =  $event->message;
        $data['title'] =  'complete';
        $pusher->trigger('booking-channel', 'complete-event', $data);
    }
}
