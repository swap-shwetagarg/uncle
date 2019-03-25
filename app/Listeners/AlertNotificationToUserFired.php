<?php

namespace App\Listeners;

use App\Events\AlertNotificationToUser;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\AlertNotificationToUser as UserNotificationMail;
use Mail;

class AlertNotificationToUserFired extends BaseListener implements ShouldQueue
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
     * @param  vent=AlertNotificationToUser  $event
     * @return void
     */
    public function handle(AlertNotificationToUser $event){
        // Send Email
        Mail::to($event->data->getUser->email)->send(new UserNotificationMail($event->data,$event->nextDate));
        
        // Send Push Notification to the Device
        $userDevices = $event->data->getUser->getDevice;
        $role = $event->data->getUser->getRole->first();
        if($userDevices->isNotEmpty()){
            foreach($userDevices as $userDevice){
                parent::sendNotification($userDevice,$event->message,$role);
            }
        }
    }
}
