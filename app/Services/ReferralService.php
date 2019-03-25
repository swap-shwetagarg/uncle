<?php


namespace App\Services;

use App\Repositories\Referral\ReferralInterface;

class ReferralService extends BaseService{

    protected $referralInterface;

    public function __construct(ReferralInterface $referralInterface) {
        $this->referralInterface = $referralInterface;
    }

    public function findAll() {
        return $this->referralInterface->findAll();
    }

    public function find($id) {
        return $this->referralInterface->find($id);
    }

    public function create(array $data) {
        return $this->referralInterface->create($data);
    }

    public function update(array $data, $id) {
        return $this->referralInterface->update($data, $id);
    }

    public function destroy($id) {
        return $this->referralInterface->destroy($id);
    }
    
    public function availableRedeem($id)
    {
        return $this->referralInterface->availableRedeem($id);
    }
    
    public function getBase64Url($id,$email) {
        return $this->referralInterface->getBase64Url($id,$email);
    }

    public function getReferrallist($id) {
        return $this->referralInterface->getReferrallist($id);
    }
    
    public function saveReferralSettings($request_array) {
        return $this->referralInterface->saveReferralSettings($request_array);
    }
    
    public function getReferralSettings() {
        return $this->referralInterface->getReferralSettings();
    }
}
