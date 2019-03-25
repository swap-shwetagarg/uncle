<?php

namespace App\Repositories\Referral;

use App\Repositories\Referral\ReferralInterface;
use Illuminate\Support\Facades\Log;
use App\Models\Referral;
use App\Facades\AppSettings;
use DB;

class ReferralRepository implements ReferralInterface {

    protected $referral;

    public function __construct(Referral $referral) {
        $this->referral = $referral;
    }

    /**
     * Get all instance of BookingItems.
     *
     * @return \Illuminate\Database\Eloquent\Collection|\App\BookingItems[]
     */
    public function findAll() {
        return $this->referral->paginate(15);
    }

    /**
     * Find an instance of BookingItems with the given ID.
     *
     * @param  int  $id
     * @return \App\BookingItems
     */
    public function find($id) {
        return $this->referral->find($id);
    }

    /**
     * Create a new instance of BookingItems.
     *
     * @param  array  $attributes
     * @return \App\BookingItems
     */
    public function create(array $attributes = []) {
        try {
            return $this->referral->insert($attributes);
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
            return $this->referral->findOrFail($id)->update($attributes);
        } catch (\Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);
            dd($ex);
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
            return $this->referral->findOrFail($id)->delete();
        } catch (\Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);

            throw $ex;
        }
    }

    public function availableRedeem($id) {
        $result = DB::select('SELECT * FROM referral 
                              WHERE (sender_id = ? And sender_redeem = 0 And rec_redeem = 1) 
                                    Or (rec_id = ? And rec_redeem =0) 
                              Order by created_at ASC'
                        , array($id, $id));
        return $result;

//        $result = Referral::whereSender_id($id)
//                          ->whereSender_redeemAndRec_redeem(0,1)
//                          ->orWhere(function ($query){
//                              $query->whereRec_idAndRec_redeem($id,0);
//                            })
//                          ->orderBy('created_at','ASC')->get();
    }

    public function getBase64Url($id, $email) {
        $url = base64_encode($email . '|' . $id);
        return $url;
    }

    public function getReferrallist($id) {
        $referrals = Referral::whereRec_idOrSender_id($id, $id)->get();
        return $referrals;
    }

    public function saveReferralSettings($request_array = array()) {
        AppSettings::set('referral_amount', $request_array['referral_amount']);
        AppSettings::set('referral_link_text', $request_array['referral_link_text']);
        AppSettings::set('referral_content', $request_array['referral_content']);
        AppSettings::set('referral_heading', $request_array['referral_heading']);
        AppSettings::set('referral_share_text', $request_array['referral_share_text']);
        return true;
    }

    public function getReferralSettings() {
        $data = [];
        $data['referral_amount'] = AppSettings::get('referral_amount');
        $data['referral_link_text'] = AppSettings::get('referral_link_text');
        $data['referral_content'] = AppSettings::get('referral_content');
        $data['referral_heading'] = AppSettings::get('referral_heading');
        $data['referral_share_text'] = AppSettings::get('referral_share_text');
        return $data;
    }

}
