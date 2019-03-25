<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\Users\UserInterface as UserInterface;
use Auth;

class userService extends BaseService {

    protected $userInterface;

    public function __construct(UserInterface $userInterface) {
        $this->userInterface = $userInterface;
    }

    public function login(array $data) {
        return $this->userInterface->login($data);
    }

    public function register(array $data) {
        return $this->userInterface->register($data);
    }

    public function logout(array $data) {
        return $this->userInterface->logout($data);
    }

    public function findAll() {
        return $this->userInterface->findAll();
    }

    public function create(array $data) {
        return $this->userInterface->create($data);
    }

    public function update(array $data, $id) {
        return $this->userInterface->update($data, $id);
    }

    public function find($id) {
        return $this->userInterface->find($id);
    }

    public function destroy($id) {
        return $this->userInterface->destroy($id);
    }
    
    public function generatelinkToVerifyAccount()
    {
        return $this->userInterface->generatelinkToVerifyAccount();
    }
    
    public function checkAuthBooking()
    {
        return count(Auth::user()->getBookings);
    }
    
    public function checkAuthBookingStatus()
    {
        return Auth::user()->getBookings[0]->status;
    }

}
