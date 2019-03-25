<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtpAuthentication extends Model {

    protected $table = 'otp_authentication';
    protected $fillable = [
        'mobile', 'code', 'created_at', 'updated_at',
    ];

    protected $hidden = [
         'remember_token',
    ];

}
