<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingSubServiceOption extends Model {

    protected $table = 'booking_sub_service_option';
    protected $fillable = [
        'booking_sub_service_id', 'sub_service_option_id',
    ];

    protected $hidden = [
         'remember_token',
    ];

    protected function bookingServiceSub() {
        return $this->belongsTo('App\Models\BookingServiceSubService', 'booking_sub_service_id');
    }
    
    protected function getSubOption()
    {
        return $this->belongsTo('App\Models\SubServicesOptions', 'sub_service_option_id');
    }
     // this is a recommended way to declare event handlers
    protected static function boot() {
        parent::boot();

        static::deleting(function($bookingSubService) { // before delete() method call this
             $bookingSubService->delete();
        });
    }
}
