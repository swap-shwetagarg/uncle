<?php

// app/Repositories/Contracts/UserRepo.php

namespace App\Repositories\Users;

interface UserInterface {

    public function find($data);

    public function create(array $data);

    public function update(array $data, $id);

    public function destroy($id);

    public function findAll();
    
    public function verifyUserAccount($data);
    
    public function searchUser($input);
}
