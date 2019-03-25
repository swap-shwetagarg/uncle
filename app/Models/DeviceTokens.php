<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DeviceTokens extends Model {

    protected $table = 'device_tokens';
    protected $fillable = [
        'id', 'user_id','device' ,'device_token', 'created_at', 'updated_at', 'remember_token', 'status'
    ];
    
    protected $casts = [
        'status' => 'boolean',
    ];
    
    protected $hidden = [
         'remember_token',
    ];

}
