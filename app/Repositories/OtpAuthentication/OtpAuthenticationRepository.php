<?php

namespace App\Repositories\OtpAuthentication;

use App\Models\OtpAuthentication;
use App\Repositories\OtpAuthentication\OtpAuthenticationInterface as OtpAuthenticationInterface;
use Illuminate\Support\Facades\Log;
use Auth;
use Carbon\Carbon;
use AppSettings;
use DB;

class OtpAuthenticationRepository implements OtpAuthenticationInterface {

    protected $otp_authentication;

    public function __construct(OtpAuthentication $otp_authentication) {
        $this->otp_authentication = $otp_authentication;
    }

    /**
     * Find an instance of BookingItems with the given ID.
     *
     * @param  int  $id
     * @return \App\BookingItems
     */
    public function find($id) {
        return $this->otp_authentication->find($id);
    }

    /**
     * Create a new instance of BookingItems.
     *
     * @param  array  $attributes
     * @return \App\BookingItems
     */
    public function create(array $attributes = []) {
        try {
            return $this->otp_authentication->insert($attributes);
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
            return $this->otp_authentication->findOrFail($id)->update($attributes);
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
            return $this->otp_authentication->findOrFail($id)->delete();
        } catch (\Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);

            throw $ex;
        }
    }

}
