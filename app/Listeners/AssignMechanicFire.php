<?php

namespace App\Listeners;

use App\Events\AssignMechanic;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Pusher\PusherClient;
use App\Models\DeviceTokens;
use PushNotification;

class AssignMechanicFire extends BaseListener implements ShouldQueue
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
     * @param  AssignMechanic  $event
     * @return void
     */
    public function handle(AssignMechanic $event)
    {
        $pusher = PusherClient::getPusher();

        $data['message'] =  $event->message;
        $data['title'] =  'assign';
        $pusher->trigger('booking-channel', 'assign-event-'.$event->booking->getUser->id, $data);
        
        $userDevices = $event->booking->getUser->getDevice;
        $role = $event->booking->getUser->getRole->first();
        if($userDevices->isNotEmpty()){
            foreach($userDevices as $userDevice){
                parent::sendNotification($userDevice,$event->message,$role);
            }
        }
        
        $user = $event->booking->bookingMechanic;
        if(collect($user)->isNotEmpty()){
            $mechDevices = $user->mechanic->getDevice;
            $role = $user->mechanic->getRole->first();
            if($mechDevices->isNotEmpty()){
                foreach($mechDevices as $userDevice){
                    parent::sendNotification($userDevice,$event->mechMessage,$role,$event->booking,"bookingDetail");
                }
            }
        }
    }
}
