<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MechanicRoute extends Model
{
    protected $table = 'mechanic_route';
    protected $fillable = [
        'id', 'booking_id','mech_location' ,'mech_starting_location','user_location', 'isReached','created_at', 'updated_at', 'remember_token'
    ];
    
    protected $casts = [
        'isReached' => 'integer',
    ];
    
    protected $hidden = [
         'remember_token',
    ];

}
