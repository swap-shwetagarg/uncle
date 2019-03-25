<?php

// app/Repositories/Contracts/UserRepo.php

namespace App\Repositories\UserCar;

interface UserCarInterface {

    public function find($data);

    public function create(Array $data);

    public function update(Array $data, $id);

    public function destroy($id);

    public function findAll();
    
    public function getUserCarById($id);
    
    public function getUserCarServices($id);
}

?>
