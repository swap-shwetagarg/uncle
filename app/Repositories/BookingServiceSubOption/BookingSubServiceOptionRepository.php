<?php

namespace App\Repositories\BookingServiceSubOption;

use App\Models\BookingSubServiceOption;
use App\Repositories\BookingServiceSubOption\BookingServiceSubOptionInterface as BookingServiceSubOptionInterface;
use Log;

class BookingSubServiceOptionRepository implements BookingServiceSubOptionInterface {

    protected $bookingServiceSubOption;

    public function __construct(BookingSubServiceOption $bookingServiceSubOption) {
        $this->bookingServiceSubOption = $bookingServiceSubOption;
    }

    /**
     * Get all instance of BookingItems.
     *
     * @return \Illuminate\Database\Eloquent\Collection|\App\BookingItems[]
     */
    public function findAll() {
        return $this->bookingServiceSubOption->paginate(15);
    }

    /**
     * Find an instance of BookingItems with the given ID.
     *
     * @param  int  $id
     * @return \App\BookingItems
     */
    public function find($id) {
        return $this->bookingServiceSubOption->find($id);
    }

    /**
     * Create a new instance of BookingItems.
     *
     * @param  array  $attributes
     * @return \App\BookingItems
     */
    public function create(array $attributes = []) {
        try {
            return $this->bookingServiceSubOption->insert($attributes);
        } catch (\Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);
            throw $ex;
        }
    }

    /**
     * Update the BookingItems with the given attributes.
     *
     * @param  int    $id
     * @param  array  $attributes
     * @return bool|int
     */
    public function update(array $attributes = [], $id) {
        try {
            return $this->bookingServiceSubOption->findOrFail($id)->update($attributes);
        } catch (\Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);

            throw $ex;
        }
    }

    /**
     * Delete an entry with the given ID.
     *
     * @param  int  $id
     * @return bool|null
     * @throws \Exception
     */
    public function destroy($id) {
        try {
            return $this->bookingServiceSubOption->findOrFail($id)->delete();
        } catch (\Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);

            throw $ex;
        }
    }

}
