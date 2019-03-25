<?php

namespace App\Listeners;

use App\User;
use Mail;

class UserEmailsFired {

    /**
     * Handle user login events.
     */
    public function onAssignMechanic($event) {
        //Send email to user about the mechanic detail that has assigned for his/her booking
        $data['user'] = ['mechanic' => $event->event['bookingMechanic']->mechanic, 'user' => $event->event['bookingMechanic']->booking->getUser, 'booking_id' => $event->event['bookingMechanic']->booking->id, 'isMechanic' => '1'];

        Mail::send('email.booking.assigned_page', $data, function($message) use($event) {
            $user = $event->event['bookingMechanic']->booking->getUser;
            $message->to($user->email, $user->name)->subject('Mechanic Assigned, Booking Scheduled!');
        });

        //Send email to Mechanic with detail of booking user
        $data['user'] = ['mechanic' => $event->event['bookingMechanic']->mechanic, 'user' => $event->event['bookingMechanic']->booking->getUser, 'booking_id' => $event->event['bookingMechanic']->booking->id, 'isMechanic' => '0'];
        Mail::send('email.booking.assigned_page', $data, function($message) use($event) {
            $muser = $event->event['bookingMechanic']->mechanic;
            $message->to($muser->email, $muser->name)->subject('Congratulation !!', $event);
        });
    }

    public function onReAssignMechanic($event) {
        //Send email to user about the mechanic detail that has assigned for his/her booking
        $data['user'] = ['mechanic' => $event->event['bookingMechanic']->mechanic,'user' => $event->event['bookingMechanic']->booking->getUser, 'booking_id' => $event->event['bookingMechanic']->booking->id, 'isMechanic' => '1'];
        Mail::send('email.booking.assigned_page', $data, function($message) use($event) {
            $user = $event->event['bookingMechanic']->booking->getUser;
            $message->to($user->email, $user->name)->subject('Mechanic Assigned, Booking Scheduled!');
        });

        //Send email to Mechanic with detail of booking user
        $data['user'] = ['mechanic' => $event->event['bookingMechanic']->mechanic,'user' => $event->event['bookingMechanic']->booking->getUser, 'booking_id' => $event->event['bookingMechanic']->booking->id, 'isMechanic' => '0'];
        Mail::send('email.booking.assigned_page', $data, function($message) use($event) {
            $muser = $event->event['bookingMechanic']->mechanic;
            $message->to($muser->email, $muser->name)->subject('Congratulation !!', $event);
        });


        //Send Email to old mechanic that was removed for booking
        $mdata['user'] = ['booking_id' => $event->event['bookingMechanic']->booking->id];
        Mail::send('email.booking.remove_assigned_page', $mdata, function($message) use($event) {
            $muser = $event->event['old_mechanic']->mechanic;
            $message->to($muser->email, $muser->name)->subject('Sorry !!', $event);
        });
    }

    public function onSendReferralEmail($event) {        
        $emails_detail['data'] = ['referral_link' => $event->event['referral_link'], 'user_name' => $event->event['user_name']];

        Mail::send('email.referral_email', $emails_detail, function($message) use($event) {
            foreach ($event->event['emails'] as $email) {
                $message->to($email, '')->subject('UncleFitter referral !!', $event);
            }
        });
    }

    public function sendWelComeEmail($event) {
        $data['user'] = $event->event;        
        Mail::send('email.welcome_email', $data, function($message) use($event) {            
            $message->to($event->event->email, $event->event->name)->subject('Save Time, Save Money!');
        });
    }
    
    public function subscribe($events) {
        $events->listen(
                'App\Events\MechanicAssignEmail', 'App\Listeners\UserEmailsFired@onAssignMechanic'
        );

        $events->listen(
                'App\Events\MechanicReAssignEmail', 'App\Listeners\UserEmailsFired@onReAssignMechanic'
        );

        $events->listen(
                'App\Events\SendReferralEmail', 'App\Listeners\UserEmailsFired@onSendReferralEmail'
        );
        
        $events->listen(
                'App\Events\WelComeEmail', 'App\Listeners\UserEmailsFired@sendWelComeEmail'
        );
    }

}
