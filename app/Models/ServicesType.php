<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Utility\StatusFlag;

class ServicesType extends Model {

    protected $table = 'services_type';
    protected $fillable = [
        'service_type', 'status'
    ]; 
    
    protected $casts = [
        'status' => 'boolean',
    ];
    
    protected $hidden = [
         'remember_token',
    ];

    public function category() {
        return $this->hasMany('App\Models\Category', 'service_type_id')->whereStatus(StatusFlag::ACTIVE);
    }

}
