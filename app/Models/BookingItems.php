<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingItems extends Model {

    protected $table = 'booking_items';
    protected $fillable = [
        'booking_id', 'service_id',
    ];

    protected $hidden = [
         'remember_token',
    ];

    protected function bookingServiceSub() {
        return $this->hasMany('App\Models\BookingServiceSubService', 'booking_items_id');
    }

    protected function booking() {
        return $this->belongsTo('App\Models\Booking', 'booking_id');
    }

     protected function getService()
    {
        return $this->belongsTo('App\Models\Services', 'service_id');
    }
    // this is a recommended way to declare event handlers
    protected static function boot() {
        parent::boot();

        static::deleting(function($bookingItems) { // before delete() method call this
             $bookingItems->bookingServiceSub()->delete();
        });
    }
}
