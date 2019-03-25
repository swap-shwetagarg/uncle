<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model {

    protected $table = 'address';
    protected $fillable = [
        'user_id', 'add_1','add_2','country','area','zipcode','remember_token'
    ];
    
    protected $hidden = [
         'remember_token',
    ];

}
