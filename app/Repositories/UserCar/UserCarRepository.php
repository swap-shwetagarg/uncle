<?php

namespace App\Repositories\UserCar;

use App\Models\UserCar;
use App\Repositories\UserCar\UserCarInterface as UserCarInterface;
use Illuminate\Support\Facades\Log;
use App\Utility\BookingStatus;
use Auth;

class UserCarRepository implements UserCarInterface {

    protected $usercar;

    public function __construct(UserCar $usercar) {
        $this->usercar = $usercar;
    }

    public function find($data) {
        return $this->usercar->find($data);
    }

    public function getUserCarById($data) {
        $id = Auth::user()->id; // Authenticated user id
        return $this->usercar->select('id', 'user_id', 'car_trim_id','car_health','status')
                        ->whereUser_idAndCar_trim_id($id, $data)
                        ->get();
    }

    public function findAll() {
        return $this->usercar->paginate(15);
    }

    public function create(Array $data) {
        try {

            return $this->usercar->insert($data);
        } catch (\Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);

            throw $ex;
        }
    }

    public function update(Array $data, $id) {
        try {
            return $this->usercar->findOrFail($id)->update(['car_health' => json_encode($data)]);
            //return $this->usercar->where('id', $id)->update($data);
        } catch (\Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);

            throw $ex;
        }
    }

    public function destroy($id) {
        try {
            return $this->usercar->findOrFail($id)->delete();
        } catch (\Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);

            throw $ex;
        }
    }

    public function getUserCarServices($id) {
        $user_id = Auth::user()->id; // Authenticated user id 
        $bookings = \BookingCount::whereUser_id($user_id)
                ->whereCartrim_idAndStatus($id, BookingStatus::COMPLETED)
                ->orderBy('id', 'DESC')
                ->get();
        return $bookings;
    }

    public function getUserCarDetails(Array $data) {
        try {
            return $this->usercar->whereUser_idAndCar_trim_id($data['user_id'], $data['cartrim_id'])
                        ->first();
        } catch (\Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);
            throw $ex;
        }
    }
    
    public function softDelete($id) {
        try {
            return $this->usercar->findOrFail($id)->update(['status' => 0]);
        } catch (\Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);

            throw $ex;
        }
    }

}
