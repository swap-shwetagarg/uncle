<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Utility\StatusFlag;

class CarsModel extends Model {

    protected $table = 'car_models';
    protected $fillable = [
        'year_id', 'modal_name', 'status'
    ];
    
    protected $casts = [
        'status' => 'boolean',
    ];
    
    protected $hidden = [
         'remember_token',
    ];

    public function carTrim() {
        return $this->hasMany('App\Models\CarTrim', 'car_model_id')->whereStatus(StatusFlag::ACTIVE);
    }

    public function years() {
        return $this->belongsTo('App\Models\Years', 'year_id');
    }

}
