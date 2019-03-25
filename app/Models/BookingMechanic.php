<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingMechanic extends Model {

    protected $table = 'booking_mechanic';
    protected $fillable = [
        'booking_id', 'mechanic_id','booked_from','booked_to','mech_response'
    ];

    protected $hidden = [
         'remember_token',
    ];

    protected function mechanic() {
        return $this->belongsTo('App\User', 'mechanic_id');
    }

    protected function booking() {
        return $this->belongsTo('App\Models\Booking', 'booking_id');
    }   

}
