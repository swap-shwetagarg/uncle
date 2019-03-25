<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Providers extends Model
{
    protected $table = 'providers';
    protected $fillable = [
        'provider_id', 'provider', 'user_id',
    ];
    
    public function getUser() {
        return $this->belongsTo('App\User','user_id');
    }
}
