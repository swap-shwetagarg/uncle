<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarTrim extends Model {

    protected $table = 'car_trim';
    protected $fillable = [
        'car_model_id', 'car_trim_name', 'status'
    ];
    
    protected $casts = [
        'status' => 'boolean',
    ];
    
    protected $hidden = [
         'remember_token',
    ];

    public function services() {
        return $this->belongsToMany('App\Models\Services');
    }

    public function carmodel() {
        return $this->belongsTo('App\Models\CarsModel', 'car_model_id');
    }

}
