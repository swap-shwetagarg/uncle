<?php

namespace App\Listeners;

use App\Events\MechanicLocation;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Pusher\PusherClient;

class MechanicLocationFired extends BaseListener implements ShouldQueue
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
     * @param  MechnaicLocation  $event
     * @return void
     */
    public function handle(MechanicLocation $event){
        $pusher = PusherClient::getPusher();

        $data['message'] =  $event->message;
        $data['title'] =  'mech_location';
        $pusher->trigger('booking-channel', 'mechanic-location-'.$event->booking->getUser->id, $data);
        
        $userDevices = $event->booking->getUser->getDevice;
        $role = $event->booking->getUser->getRole->first();
        if($userDevices->isNotEmpty()){
            foreach($userDevices as $userDevice){
                parent::sendNotification($userDevice,$event->message,$role);
            }
        }
    }
}
