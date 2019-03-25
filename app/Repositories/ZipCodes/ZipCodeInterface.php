<?php

// app/Repositories/Contracts/ZipCodeRepo.php

namespace App\Repositories\ZipCodes;

use Illuminate\Http\Request;

interface ZipCodeInterface {

    public function find($data);

    public function create(array $data);

    public function update(array $data, $id);

    public function destroy($id);

    public function findAll($flag = 0);
}
