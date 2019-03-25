<?php

namespace App\Listeners;

use App\Events\MechanicApproved;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MechanicApprovedFired extends BaseListener implements ShouldQueue
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
     * @param  MechanicApproved  $event
     * @return void
     */
    public function handle(MechanicApproved $event){
        $userDevices = $event->user->getDevice;
        $role = $event->user->getRole->first();
        if($userDevices->isNotEmpty()){
            foreach($userDevices as $userDevice){
                parent::sendNotification($userDevice,$event->message,$role);
            }
        }
    }
}
