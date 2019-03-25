<?php

namespace App;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole {

    protected $fillable = [
        'name', 'display_name', 'description',
    ];

    public function user() {
        return $this->belongsToMany('App\User');
    }
    
    public function scopeOfRoleCount($query,$type){
        return $query->find($type['type'])->verifiedUser($type['verify'])
                                          ->get();
    }
    
    private function verifiedUser($verify){
        return $this->belongsToMany('App\User')->whereVerified($verify);
    }
}