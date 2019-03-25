<?php

namespace App\Repositories\Years;

interface YearInterface {

    public function find($data);
    
    public function findById($data);

    public function create(array $data);

    public function update(array $data, $id);

    public function destroy($id);

    public function findAll();
}
