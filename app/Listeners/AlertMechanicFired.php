<?php

namespace App\Listeners;

use App\Events\AlertMechanic;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AlertMechanicFired extends BaseListener implements ShouldQueue
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
     * @param  AlertMechanic  $event
     * @return void
     */
    public function handle(AlertMechanic $event)
    {   
        $message = 'Your next booking ( Booking Id : '.$event->booking->id.' ) is Schedule today at ' . $event->booking->schedule_start_time;
        $existMechanic = $event->booking->bookingMechanic;
        if(!is_null($existMechanic)){
            $mechanicDevices = $existMechanic->mechanic->getDevice;
            $role = $existMechanic->mechanic->getRole->first();
            if ($mechanicDevices->isNotEmpty()) {
                foreach ($mechanicDevices as $mechanicDevice) {
                    parent::sendNotification($mechanicDevice, $message,$role,$event->booking,"bookingDetail");
                }
            }
        }
    }
}
