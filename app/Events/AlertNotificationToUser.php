<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AlertNotificationToUser {

    use Dispatchable,
        InteractsWithSockets,
        SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $data;
    public $nextDate;
    public $message;

    public function __construct($data, $nextDate) {
        if ($data) {
            $car_trim = $data->carTrim->car_trim_name;
            $car_model = $data->carTrim->carmodel->modal_name;
            $car_year = $data->carTrim->carmodel->years->year;
            $car_brand = $data->carTrim->carmodel->years->cars->brand;
            $this->data = $data;
            $this->nextDate = $nextDate;
            //$this->message = 'Your have an upcoming service.';
            $this->message = 'Your ' . $car_brand . ', ' . $car_year . ', ' . $car_model . ' ' . $car_trim . ' is due for maintenance.';
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn() {
        return new PrivateChannel('channel-name');
    }

}
