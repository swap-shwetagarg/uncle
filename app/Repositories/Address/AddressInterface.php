<?php

namespace App\Repositories\Address;

interface AddressInterface {

    public function find($data);

    public function create(array $data);

    public function update(array $data, $id);

    public function destroy($id);

    public function findAll();
}
