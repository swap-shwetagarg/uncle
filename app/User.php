<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Jrean\UserVerification\Traits\VerifiesUsers;
use App\Utility\BookingStatus;

class User extends Authenticatable {

    use HasApiTokens,
        Notifiable,
        EntrustUserTrait,
        VerifiesUsers;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'mobile', 'provider', 'provider_id', 'default_location', 'verified', 'verification_code',
        'verification_token', 'verified', 'mobile_country_code', 'approved', 'profile_photo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'verification_token', 'verification_code'
    ];
    protected $casts = [
        'verified' => 'boolean',
        'approved' => 'boolean',
    ];

    protected function bookingMechanic() {
        return $this->hasMany('App\Models\BookingMechanic', 'mechanic_id')->orderBy('booking_id', 'desc')->latest();
    }

    public function address() {
        return $this->hasMany('App\Models\Address', 'user_id');
    }

    public function getRole() {
        return $this->belongsToMany('App\Role');
    }

    public function getBookings() {
        return $this->hasMany('App\Models\Booking', 'user_id')->whereStatus(BookingStatus::PENDING);
    }

    public function getBooking() {
        return $this->hasMany('App\Models\Booking', 'user_id')->orderBy('created_at', 'desc')->latest();
    }

    public function getCars() {
        return $this->hasMany('App\Models\UserCar', 'user_id')->whereStatus(1);
    }
    
    public function getActiveCars() {
        return $this->hasMany('App\Models\UserCar', 'user_id')->where('status', 1);
    }

    public function getDevice() {
        return $this->hasMany('App\Models\DeviceTokens', 'user_id');
    }

    public function scopeOfUserCount($query, $type) {
        return $query->whereVerified($type);
    }

    public function getRating() {
        return $this->hasMany('App\Models\Rating', 'mechanic_id');
    }
    
    public function getZipCode(){
        return $this->belongsTo('App\Models\ZipCode', 'default_location');
    }
}
