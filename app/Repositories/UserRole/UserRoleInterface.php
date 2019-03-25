<?php

// app/Repositories/Contracts/UserRepo.php

namespace App\Repositories\UserRole;

interface UserRoleInterface {

    public function update($role_id, $user_id);

}
