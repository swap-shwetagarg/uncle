<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model {

    protected $table = 'mechanic_ratings';
    protected $fillable = [
        'ratings', 'overall_rating', 'mechanic_id', 'booking_id', 'user_id', 'user_note'
    ];
 
    protected $hidden = [
         'remember_token',
    ];
    
    protected function getUser()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    
    protected function getMechanic()
    {
        return $this->belongsTo('App\User', 'mechanic_id');
    }
}