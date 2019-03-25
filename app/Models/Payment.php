<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model {

    protected $table = 'payments';
    protected $fillable = [
        'booking_id', 'transaction_id', 'mode', 'status','payment_token','created_at', 'updated_at',
    ];

    protected $hidden = [
         'remember_token',
    ];
    
    protected $casts = [
        'status' => 'integer',
    ];

    protected function booking() {
        return $this->belongsTo('App\Models\Booking', 'booking_id');
    }

}
