<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\User;

class BookingCompletionToUser
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $message;
    public $booking;
    
    public function __construct($booking)
    {
        $this->message = 'Service is completed, kindly rate your mechanic';
        $this->booking  = $booking;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('booking-channel');
    }

    public function broadcastAs()
    {
        return 'complete-event-'.$this->booking->getUser->id;
    }
}
