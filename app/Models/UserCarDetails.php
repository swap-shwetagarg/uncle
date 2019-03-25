<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCarDetails extends Model
{
    protected $table = 'user_car_details';
	
    protected $fillable = [
        'user_car_id','remember_token','daily_milage','vin'
    ];

    protected $hidden = [
         'remember_token',
    ];
}
