<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AlertNotificationToUserForHoliday {

    use Dispatchable,
        InteractsWithSockets,
        SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $data;
    public $message;

    public function __construct($data) {
        if ($data) {
            //$user_id = $data->id;
            $this->data = $data;
            //$this->message = 'Please schedule a convenient time and location for the service. Booking ID: ' . $booking_id;
            $this->message = "Dear esteemed customers, please note that we would be unavailable on the 25th and 26th of December as well as the 1st of January for the holidays. Thanks and happy Holidays to you all!";
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn() {
        return [];
    }

}
