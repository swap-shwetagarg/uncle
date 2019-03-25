<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Utility\StatusFlag;

class Category extends Model {

    protected $table = 'categories';
    protected $fillable = [
        'service_type_id', 'category_name', 'remember_token', 'status'
    ];
    
    protected $casts = [
        'status' => 'boolean',
    ];
    
    protected $hidden = [
         'remember_token',
    ];

    public function servicetype() {
        return $this->belongsTo('App\Models\ServicesType', 'service_type_id');
    }

    public function service() {
        return $this->hasMany('App\Models\Services', 'category_id')->whereStatus(StatusFlag::ACTIVE);
    }

}
