<?php

namespace App\Repositories\SubServiceOptions;

interface SubServiceOptInterface {

    public function find($data);

    public function create(array $data);

    public function update(array $data, $id);

    public function destroy($id);

    public function findAll();

    public function getOptionsFromId($id);
}
