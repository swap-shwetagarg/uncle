<?php

namespace App\Repositories\SubService;

interface SubServiceInterface {

    public function find($data);

    public function create(array $data);

    public function update(array $data, $id);

    public function destroy($id);

    public function findAll($flag=0);
}
