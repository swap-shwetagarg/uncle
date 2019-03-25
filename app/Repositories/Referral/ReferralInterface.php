<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 3/6/17
 * Time: 10:48 PM
 */

namespace App\Repositories\Referral;

interface ReferralInterface {

    //put your code here
    public function find($data);

    public function create(array $data);

    public function update(array $data, $id);

    public function destroy($id);

    public function findAll();
    
    public function availableRedeem($id);
    
    public function getBase64Url($id,$email);
    
    public function getReferrallist($id);
    
    public function saveReferralSettings($array);
    
    public function getReferralSettings();
}
