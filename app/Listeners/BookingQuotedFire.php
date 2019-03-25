<?php

namespace App\Listeners;

use App\Events\BookingQuoted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Pusher\PusherClient;
use PushNotification;
use Illuminate\Support\Facades\Log;

class BookingQuotedFire extends BaseListener implements ShouldQueue
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
     * @param  BookingQuoted  $event
     * @return void
     */
    public function handle(BookingQuoted $event)
    {
        $pusher = PusherClient::getPusher();
        
        /*
        Log::useDailyFiles(storage_path() . '/logs/debug.log');        
        Log::info(['sendNotification BOOKING OBJECT END:' => $event->booking->id]);
        */
        
        $data['message'] =  $event->message;
        $data['title'] =  'quoted';
        $pusher->trigger('booking-channel', 'quoted-event-'.$event->user->id, $data);
        
        $userDevices = $event->user->getDevice;
        
        $role = $event->user->getRole->first();
        if($userDevices->isNotEmpty()){
            foreach($userDevices as $userDevice){
                parent::sendNotification($userDevice,$event->message,$role, $event->booking, 'bookingDetail');
            }
        }
    }
}
