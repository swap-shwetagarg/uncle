<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubServicesOptions extends Model {

    protected $table = 'sub_services_options';
    protected $fillable = [
        'sub_service_id', 'option_name', 'option_description', 'option_order', 'status', 'sub_service_id_ref', 'option_type', 'option_image',
        'recommend_service_id'
    ];
    
    protected $casts = [
        'status' => 'boolean',
    ];
    
    protected $hidden = [
         'remember_token',
    ];

    public function subservice() {
        return $this->belongsTo('App\Models\SubServices', 'sub_service_id');
    }

}
