<?php

namespace App\Repositories\OtpAuthentication;

interface OtpAuthenticationInterface {

    public function find($data);

    public function create(array $data);

    public function update(array $data, $id);

    public function destroy($id);
}
