<?php

namespace App\Repositories\UserRole;

use App\Repositories\UserRole\UserRoleInterface;
use Illuminate\Support\Facades\Log;
use App\Models\UserRole;
use DB;

class UserRoleRepository implements UserRoleInterface {

    protected $userrole;

    public function __construct(UserRole $userrole) {
        $this->userrole = $userrole;
    }

    public function update($role_id , $user_id) {
        try {
            $results = DB::table('role_user')->where('user_id', $user_id)->update(array('role_id' => $role_id));
            return $results;        
        } catch (\Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);
            dd($ex);
            throw $ex;
        }
    }

}
