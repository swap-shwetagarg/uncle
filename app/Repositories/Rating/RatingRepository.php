<?php

namespace App\Repositories\Rating;

use App\Repositories\Rating\RatingInterface;
use Illuminate\Support\Facades\Log;
use App\Models\Rating;
use DB;

class RatingRepository implements RatingInterface {

    protected $rating;

    public function __construct(Rating $rating) {
        $this->rating = $rating;
    }
    
    public function findAll() {
        return $this->rating->paginate(15);
    }

    
    public function find($id) {
        return $this->rating->find($id);
    }

    
    public function create(array $attributes = []) {
        try {
            return $this->rating->insert($attributes);
        } catch (\Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);

            throw $ex;
        }
    }

    
    public function update(array $attributes = [], $id) {
        try {
            return $this->rating->findOrFail($id)->update($attributes);
        } catch (\Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);
            dd($ex);
            throw $ex;
        }
    }

    
    public function destroy($id) {
        try {
            return $this->rating->findOrFail($id)->delete();
        } catch (\Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);

            throw $ex;
        }
    }
    
    public function getSavedRating($booking_id,$mechanic_id,$user_id) {
        return $this->rating->whereBooking_id($booking_id)->whereMechanic_id($mechanic_id)->whereUser_id($user_id)->first();
    }
}
