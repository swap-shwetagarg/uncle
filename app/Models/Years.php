<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Utility\StatusFlag;

class Years extends Model {

    protected $table = 'years';
    protected $fillable = [
        'year','car_id', 'status',
    ];
    
    protected $casts = [
        'status' => 'boolean',
    ];
    
    protected $hidden = [
         'remember_token',
    ];

    /**
     * 
     * @return type
     * 
     */
    public function model() {
        return $this->hasMany('App\Models\CarsModel', 'year_id')->whereStatus(StatusFlag::ACTIVE);
    }

    /**
     * 
     * @return type
     * 
     */
    public function cars() {
        return $this->belongsTo('App\Models\Cars', 'car_id');
    }

}
