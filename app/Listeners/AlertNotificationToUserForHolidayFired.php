<?php

namespace App\Listeners;

use App\Events\AlertNotificationToUserForHoliday;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\AlertNotificationToUser as UserNotificationMail;
use Mail;
use Illuminate\Support\Facades\Log;

class AlertNotificationToUserForHolidayFired extends BaseListener implements ShouldQueue {

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    /**
     * Handle the event.
     *
     * @param  vent=AlertNotificationToUser  $event
     * @return void
     */
    public function handle(AlertNotificationToUserForHoliday $event) {
        $userDevices = $event->data->getDevice;
        $role = $event->data->getRole->first();
        if ($userDevices->isNotEmpty()) {
            foreach ($userDevices as $userDevice) {
                parent::sendNotification($userDevice, $event->message, $role);
            }
        }
    }

}
