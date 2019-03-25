<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCar extends Model {

    protected $table = 'user_car';
	
    protected $fillable = [
        'user_id','car_trim_id','remember_token','car_health','status','car_attributes_details'
    ];

    protected $hidden = [
         'remember_token',
    ];
        
    public function usercars() {
        return $this->belongsTo('App\Models\CarTrim', 'car_trim_id');
    }
    
    public function bookings() {
        return $this->hasMany('App\Models\Booking', 'car_trim_id', 'cartrim_id');
    }
    
    public function usercardetails() {
        return $this->hasOne('App\Models\UserCarDetails', 'user_car_id');
    }
}
