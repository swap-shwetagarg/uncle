<?php

namespace App\Services;

use App\Repositories\UserRole\UserRoleInterface;

class UserRoleService extends BaseService {

    protected $userRoleInterface;

    public function __construct(UserRoleInterface $userRoleInterface) {
        $this->userRoleInterface = $userRoleInterface;
    }

    public function update($role_id, $user_id) {
        return $this->userRoleInterface->update($role_id, $user_id);
    }

}
