<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cartrim_Service extends Model {

    protected $table = 'car_trim';
    
    protected $casts = [
        'status' => 'boolean',
    ];
    
    protected $hidden = [
         'remember_token',
    ];

}
