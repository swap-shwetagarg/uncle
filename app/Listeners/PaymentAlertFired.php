<?php

namespace App\Listeners;

use App\Events\PaymentAlert;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\DeviceTokens;
use PushNotification;

class PaymentAlertFired extends BaseListener implements ShouldQueue
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
     * @param  vent=PaymentAleert  $event
     * @return void
     */
    public function handle(PaymentAlert $event)
    {
        $userDevices = $event->user->getDevice;
        $role = $event->user->getRole->first();
        if($userDevices->isNotEmpty()){
            foreach($userDevices as $userDevice){
                parent::sendNotification($userDevice,$event->message,$role);
            }
        }
    }
}
