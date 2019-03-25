<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Utility\StatusFlag;

class SubServices extends Model {

    protected $table = 'sub_services';
    protected $fillable = [
        'category_id', 'title', 'description', 'order', 'selection_type', 'status', 'optional', 'display_text'
    ];
    
    protected $casts = [
        'status' => 'boolean',
    ];
    
    protected $hidden = [
         'remember_token',
    ];

    public function subserviceopt() {
        return $this->hasMany('App\Models\SubServicesOptions', 'sub_service_id')->whereStatus(StatusFlag::ACTIVE);
    }

    public function service() {
        return $this->belongsTo('App\Models\Services', 'service_id');
    }

}
