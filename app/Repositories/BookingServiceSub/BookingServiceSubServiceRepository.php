<?php

namespace app\Repositories\BookingServiceSub;

use App\Models\BookingServiceSubService;
use App\Repositories\BookingServiceSub\BookingServiceSubInterface as BookingServiceSubInterface;
use Illuminate\Support\Facades\Log;

class BookingServiceSubServiceRepository implements BookingServiceSubInterface {

    protected $bookingServiceSub;

    public function __construct(BookingServiceSubService $bookingServiceSub) {
        $this->bookingServiceSub = $bookingServiceSub;
    }

    /**
     * Get all instance of BookingItems.
     *
     * @return \Illuminate\Database\Eloquent\Collection|\App\BookingItems[]
     */
    public function findAll() {
        return $this->bookingServiceSub->paginate(15);
    }

    /**
     * Find an instance of BookingItems with the given ID.
     *
     * @param  int  $id
     * @return \App\BookingItems
     */
    public function find($id) {
        return $this->bookingServiceSub->find($id);
    }

    /**
     * Create a new instance of BookingItems.
     *
     * @param  array  $attributes
     * @return \App\BookingItems
     */
    public function create(array $attributes = []) {
        try {
            return $this->bookingServiceSub->create($attributes);
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
            return $this->bookingServiceSub->findOrFail($id)->update($attributes);
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
            return $this->bookingServiceSub->findOrFail($id)->delete();
        } catch (\Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);

            throw $ex;
        }
    }

}
