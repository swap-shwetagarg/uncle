<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model {

    protected $table = 'role_user';
    protected $fillable = [
        'user_id','role_id'
    ];
 
    protected $hidden = [
         'remember_token',
    ];
}