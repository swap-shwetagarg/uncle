<?php

namespace App\Repositories\Services;

interface ServicesInterface {

    public function find($data);

    public function create(array $data);

    public function update(array $data, $id);

    public function destroy($id);

    public function findAll();

    public function getInspectionServices();

    public function searchServices($search, $type);
}
