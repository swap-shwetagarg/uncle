<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Utility\StatusFlag;

class Cars extends Model {

    protected $table = 'cars';
    protected $fillable = [
        'brand', 'description', 'zip_code_id', 'image_url', 'status', 'remember_token'
    ];
    
    protected $casts = [
        'status' => 'boolean',
    ];
    
    protected $hidden = [
         'remember_token',
    ];

    public function zipCode() {
        return $this->belongsTo('App\Models\ZipCode', 'zip_code_id');
    }

    public function years() {
        return $this->hasMany('App\Models\Years', 'car_id')->whereStatus(StatusFlag::ACTIVE);
    }
}
