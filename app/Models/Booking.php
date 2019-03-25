<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Auth;

class Booking extends Model {

    protected $table = 'bookings';
    protected $fillable = [
        'labour_cost','parts_cost', 'vat_cost','user_id','cartrim_id','zipcode_id', 'own_service_description', 'status','date_time','price','schedule_date','schedule_start_time','schedule_end_time','address'
    ];
    
    protected $hidden = [
         'remember_token',
    ];
    
    protected $casts = [
        'status' => 'integer',
    ];

    protected function bookingItems() {
        return $this->hasMany('App\Models\BookingItems', 'booking_id');
    }

    protected function payment() {
        return $this->hasMany('App\Models\Payment', 'booking_id');
    }

    protected function bookingMechanic() {
        return $this->hasOne('App\Models\BookingMechanic','booking_id')->orderBy('id','desc')->latest();
    }
    
    protected function bookingMechanicRating() {
        return $this->hasOne('App\Models\Rating','booking_id');
    }
    
    protected function usercar(){
        return $this->belongsTo('App\Models\UserCar', 'user_id');
    }
    
    protected function getUser(){
        return $this->belongsTo('App\User', 'user_id');
    }
    
    public function carTrim(){
        return $this->belongsTo('App\Models\CarTrim', 'cartrim_id');
    }
    
    public function getZipCode(){
        return $this->belongsTo('App\Models\ZipCode', 'zipcode_id');
    }
    
    // this is a recommended way to declare event handlers
    protected static function boot() {
        parent::boot();

        static::deleting(function($booking) { // before delete() method call this        
             $booking->bookingItems()->delete();
        });
    }
    
    public function scopeStatus($query){
        return $query->whereStatus(6);
    }

    public function scopeDatetime($query){
        return $query->orderBy('date_time','DESC');
    }

    public function scopeOfBooking($query, $type){
        return $query->whereUser_id($type->user_id)->whereCartrim_id($type->car_trim_id);
    }
    
    public function scopeOfBookingCount($query,$type){
        return $query->whereStatus($type);
    }
    
    public function scopeCreatedAt($query){
        return $query->whereStatus(4)->orderBy('created_at','DESC')->get();
    }
    /**
     * Create a collection of models from plain arrays.
     *
     * @param  array  $items
     * @param  string|null  $connection
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function hydrate(array $items, $connection = null){
        $instance = (new static)->setConnection($connection);

        $items = array_map(function ($item) use ($instance) {
            return $instance->newFromBuilder($item);
        }, $items);

        return $instance->newCollection($items);
    }
}

