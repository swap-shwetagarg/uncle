<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 3/6/17
 * Time: 10:48 PM
 */

namespace App\Repositories\Rating;

interface RatingInterface {

    //put your code here
    public function find($data);

    public function create(array $data);

    public function update(array $data, $id);

    public function destroy($id);

    public function findAll();
}
