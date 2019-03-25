<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingServiceSubService extends Model {

    protected $table = 'booking_service_sub_service';
    protected $fillable = [
        'booking_items_id', 'sub_service_id',
    ];

    protected $hidden = [
         'remember_token',
    ];

    protected function bookingSubOption() {
        return $this->hasMany('App\Models\BookingSubServiceOption', 'booking_sub_service_id');
    }

    protected function bookingItems() {
        return $this->belongsTo('App\Models\BookingItems', 'booking_items_id');
    }
     
    protected function getServiceSub()
    {
        return $this->belongsTo('App\Models\SubServices', 'sub_service_id');
    }
    // this is a recommended way to declare event handlers
    protected static function boot() {
        parent::boot();

        static::deleting(function($bookingSubService) { // before delete() method call this
             $bookingSubService->bookingSubOption()->delete();
        });
    }
}
