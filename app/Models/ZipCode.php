<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZipCode extends Model {

    protected $table = 'zip_code';
    protected $fillable = [
        'zip_code', 'country_code', 'service_availability', 'remember_token', 'status'
    ];
    protected $casts = [
        'status' => 'boolean',
        'service_availability' => 'boolean',
    ];
    protected $hidden = [
        'remember_token',
    ];

    public function cars() {
        return $this->hasMany('App\Models\Cars');
    }

    public function bookings() {
        return $this->hasMany('App\Models\Booking', 'zipcode_id');
    }

}
