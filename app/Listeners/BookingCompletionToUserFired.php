<?php

namespace App\Listeners;

use App\Events\BookingCompletionToUser;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Pusher\PusherClient;
use PushNotification;

class BookingCompletionToUserFired extends BaseListener implements ShouldQueue
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
     * @param  BookingCompletionToUser  $event
     * @return void
     */
    public function handle(BookingCompletionToUser $event)
    {
        $pusher = PusherClient::getPusher();
        
        $data['message'] =  $event->message;
        $data['title'] =  'complete';
        $pusher->trigger('booking-channel', 'complete-event-'.$event->booking->getUser->id, $data);
        
        $userDevices = $event->booking->getUser->getDevice;
        $role = $event->booking->getUser->getRole->first();
        if($userDevices->isNotEmpty()){
            foreach($userDevices as $userDevice){
                 parent::sendNotification($userDevice,$event->message,$role,$event->booking ,'mechanicRating');
            }
        }
    }
}
