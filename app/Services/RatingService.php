<?php


namespace App\Services;

use App\Repositories\Rating\RatingInterface;

class RatingService extends BaseService{

    protected $ratingInterface;

    public function __construct(RatingInterface $ratingInterface) {
        $this->ratingInterface = $ratingInterface;
    }

    public function findAll() {
        return $this->ratingInterface->findAll();
    }

    public function find($id) {
        return $this->ratingInterface->find($id);
    }

    public function create(array $data) {
        return $this->ratingInterface->create($data);
    }

    public function update(array $data, $id) {
        return $this->ratingInterface->update($data, $id);
    }

    public function destroy($id) {
        return $this->ratingInterface->destroy($id);
    }
    public function getSavedRating($booking_id,$mechanic_id,$user_id) {
        return $this->ratingInterface->getSavedRating($booking_id,$mechanic_id,$user_id);
    }
}
