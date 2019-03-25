<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Utility\StatusFlag;

class Services extends Model {

    protected $table = 'services';
    protected $fillable = [
        'service_type_id', 'title', 'description', 'remember_token', 'status', 'recommend_service_id', 'is_popular'
    ];
    protected $casts = [
        'status' => 'boolean',
    ];
    protected $hidden = [
        'remember_token',
    ];

    public function subservice() {
        return $this->hasMany('App\Models\SubServices', 'service_id')->whereStatus(StatusFlag::ACTIVE);
    }

    public function category() {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

}
