<?php

namespace App\Repositories\Booking;

use App\Models\Booking;
use App\Models\BookingMechanic;
use App\Repositories\Booking\BookingInterface as BookingInterface;
use Illuminate\Support\Facades\Log;
use App\Services\BookingItemsService as BookingItemsService;
use App\Services\BookingServiceSubService as BookingServiceSubService;
use App\Services\BookingServiceSubOptionService as BookingServiceSubOptionService;
use App\Services\CarTrimService as CarTrimService;
use Auth;
use Event;
use App\Events\SendMail;
use App\Events\StatusLiked;
use App\Services\CarServiceService as CarServiceService;
use App\Services\SubServiceService as SubServiceService;
use App\Services\SubServiceOptService as SubServiceOptService;
use Jrean\UserVerification\Traits\VerifiesUsers;
use ConvertIntoArray;
use DB;
use App\Utility\BookingStatus;
use App\Models\Rating;
use App\Models\UserCar;
use App\User;

class BookingRepository implements BookingInterface {

    protected $booking;
    protected $bookingItems;
    protected $bookingServiceSub;
    protected $bookingSubOption;
    protected $payment;
    protected $cartrim;
    protected $service;
    protected $servicesub;
    protected $suboption;
    protected $user;

    use VerifiesUsers;

    public function __construct(Booking $booking, SubServiceOptService$suboption, SubServiceService $servicesub, CarServiceService $service, CarTrimService $cartrim, BookingItemsService $bookingItems, BookingServiceSubService $bookingServiceSub, BookingServiceSubOptionService $bookingSubOption, User $user) {
        $this->bookingItems = $bookingItems;
        $this->bookingServiceSub = $bookingServiceSub;
        $this->bookingSubOption = $bookingSubOption;
        $this->cartrim = $cartrim;
        $this->service = $service;
        $this->servicesub = $servicesub;
        $this->suboption = $suboption;
        $this->booking = $booking;
        $this->user = $user;
    }

    /**
     * Get all instance of Booking.
     *
     * @return \Illuminate\Database\Eloquent\Collection|\App\Booking[]
     */
    public function findAll() {
        $car_trim_ids = [];
        $user_ids = [];
        $car_trim_ids_array = UserCar::whereStatus(1)->get();
        if ($car_trim_ids_array->isNotEmpty()) {
            foreach ($car_trim_ids_array as $value) {
                $car_trim_ids[] = $value->car_trim_id;
                $user_ids[] = $value->user_id;
            }
        }
        $booking_collection = $this->booking->where('status', '!=', 10)
                ->whereIn('user_id', $user_ids)
                ->whereIn('cartrim_id', $car_trim_ids)
                ->orderBy("id", 'DESC')
                ->paginate(10);
        return $booking_collection;
    }

    public function findByStatus($status) {
        $car_trim_ids = [];
        $user_ids = [];
        $car_trim_ids_array = UserCar::whereStatus(1)->get();
        if ($car_trim_ids_array->isNotEmpty()) {
            foreach ($car_trim_ids_array as $value) {
                $car_trim_ids[] = $value->car_trim_id;
                $user_ids[] = $value->user_id;
            }
        }
        $booking_collection = $this->booking->whereStatus($status)
                ->whereIn('user_id', $user_ids)
                ->whereIn('cartrim_id', $car_trim_ids)
                ->orderBy("id", 'DESC')
                ->paginate(15);
        return $booking_collection;
    }

    public function searchWithStatus($status, $booking_id, $user_name) {
        $car_trim_ids = [];
        $user_ids = [];
        $car_trim_ids_array = UserCar::whereStatus(1)->get();
        if ($car_trim_ids_array->isNotEmpty()) {
            foreach ($car_trim_ids_array as $value) {
                $car_trim_ids[] = $value->car_trim_id;
                $user_ids[] = $value->user_id;
            }
        }
        try {
            if ($status && $status != BookingStatus::ALL) {
                if ($booking_id != 0) {
                    $result = $this->booking->whereStatus($status)
                            ->whereId($booking_id)
                            ->whereIn('user_id', $user_ids)
                            ->whereIn('cartrim_id', $car_trim_ids)
                            ->orderBy("bookings.id", 'DESC')
                            ->paginate(15);
                } else {
                    $users = $this->user->where('name', 'Like', '%' . $user_name . '%')->get()->pluck('id')->toArray();
                    $result = $this->booking->whereIn('user_id', $users)->whereStatus($status)->orderBy("bookings.id", 'DESC')->paginate(15);
                }
            } else {
                if ($booking_id != 0) {
                    $result = $this->booking->whereId($booking_id)
                            ->whereIn('user_id', $user_ids)
                            ->whereIn('cartrim_id', $car_trim_ids)
                            ->orderBy("bookings.id", 'DESC')
                            ->paginate(15);
                } else {
                    $users = $this->user->where('name', 'Like', '%' . $user_name . '%')->get()->pluck('id')->toArray();
                    $result = $this->booking->whereIn('user_id', $users)->orderBy("bookings.id", 'DESC')->paginate(15);
                }
            }
            return $result;
        } catch (\Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);
            throw $ex;
        }
    }

    public function userBookings($status, $user_id) {
        $car_trim_ids = [];
        $car_trim_ids_array = UserCar::whereUser_id($user_id)->whereStatus(1)->get();
        if ($car_trim_ids_array->isNotEmpty()) {
            foreach ($car_trim_ids_array as $value) {
                $car_trim_ids[] = $value->car_trim_id;
            }
        }
        if ($status === null || $status == BookingStatus::QUOTATION) {
            $booking_collection = $this->booking->where('user_id', '=', $user_id)
                    ->whereIn('status', [BookingStatus::PENDING, BookingStatus::QUOTED])
                    ->whereIn('cartrim_id', $car_trim_ids)
                    ->orderBy("id", 'DESC')
                    ->paginate(15);
        } else {
            $booking_collection = $this->booking->whereIn('status', [BookingStatus::COMPLETED, BookingStatus::SCHEDULED, BookingStatus::PROGRESSING])
                    ->where('user_id', '=', $user_id)
                    ->whereIn('cartrim_id', $car_trim_ids)
                    ->orderBy("id", 'DESC')
                    ->paginate(10);
        }
        return $booking_collection;
    }

    /**
     * Find an instance of Booking with the given ID.
     *
     * @param  int  $id
     * @return \App\Booking
     */
    public function find($id) {
        return $this->booking->findOrFail($id);
    }

    /**
     * Create a new instance of Booking.
     *
     * @param  array  $attributes
     * @return \App\Booking
     */
    public function create(array $attributes = []) {
        try {
            return $this->booking->create($attributes);
        } catch (\Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);
            throw $ex;
        }
    }

    /**
     * Update the Booking with the given attributes.
     *
     * @param  int    $id
     * @param  array  $attributes
     * @return bool|int
     */
    public function update(array $attributes = [], $id) {
        try {
            return $this->booking->findOrFail($id)->update($attributes);
        } catch (\Exception $ex) {
            dd($ex);
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request (UPDATE BOOKINGS) ' => $ex->getMessage()]);
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
            return $this->booking->findOrFail($id)->delete();
        } catch (\Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);
            throw $ex;
        }
    }

    public function booking(array $booking_details) {
        $exception = DB::transaction(function () use($booking_details) {
                    $booking_data = ConvertIntoArray::booking($booking_details);
                    $booking_result = $this->booking->create($booking_data);
                    if (isset($booking_details['service']) && $booking_details['service'] && count($booking_details['service']) > 0) {

                        foreach ($booking_details['service'] as $key) {
                            $bookingitem_data = ConvertIntoArray::bookingItem($booking_result, $key);
                            $bookingitem_result = $this->bookingItems->create($bookingitem_data);

                            if (isset($key['service_sub']) && count($key['service_sub']) > 0) {
                                foreach ($key['service_sub'] as $service_sub) {
                                    $bookingservicesub_data = ConvertIntoArray::bookingServiceSub($bookingitem_result, $service_sub);
                                    $bookingservicesub_result = $this->bookingServiceSub->create($bookingservicesub_data);

                                    if (isset($service_sub['sub_option']) && count($service_sub['sub_option']) > 0) {
                                        foreach ($service_sub['sub_option'] as $sub_option) {
                                            $bookingsuboption_data = ConvertIntoArray::bookingSubOption($bookingservicesub_result, $sub_option);
                                            $bookingsuboption_result = $this->bookingSubOption->create($bookingsuboption_data);
                                        }
                                    }
                                }
                            }
                        }
                    }
                    return $booking_result;
                });
        if (!is_null($exception)) {
            if (Auth::user()->verified) {
                if ($exception instanceof $this->booking) {
                    if (Auth::user()->email)
                        Event::fire(new SendMail($exception));
                    Event::fire(new StatusLiked(Auth::user()->name));
                }
            }
            return true;
        }
        return false;
    }

    public function getBooking($id) {
        try {
            $result = $this->booking->findOrFail($id);
        } catch (\Exception $ex) {
            return false;
        }
        $results['booking'] = $result->toArray();
        if ($result && sizeof($result)) {
            if ($result->getZipCode && sizeof($result->getZipCode)) {
                $results['booking']['zipcode_id'] = $result->getZipCode->zip_code;
            }
        }
        $results['user'] = $result->getUser->toArray();
        $results['car']['trim'] = $result->carTrim->car_trim_name;
        $results['car']['modal'] = $result->carTrim->carmodel->modal_name;
        $results['car']['year'] = $result->carTrim->carmodel->years->year;
        $results['car']['brand'] = $result->carTrim->carmodel->years->cars->brand;
        $resultss['bookingItems'] = $result->bookingItems;
        $results['rating'] = Rating::select('ratings', 'overall_rating')
                        ->whereBooking_id($result->id)->first();

        $temp_s_array = [];
        $temp_ss_array = [];
        $temp_sso_array = [];
        if ($resultss['bookingItems'] && sizeof($resultss['bookingItems'])) {
            $temp_s_array = [];
            foreach ($resultss['bookingItems'] as $value) {
                if (isset($value->bookingServiceSub) && $value->bookingServiceSub && sizeof($value->bookingServiceSub)) {
                    $temp_ss_array = [];
                    foreach ($value->bookingServiceSub as $sub_option_key) {
                        if (isset($sub_option_key->bookingSubOption) && $sub_option_key->bookingSubOption && sizeof($sub_option_key->bookingSubOption)) {
                            $temp_sso_array = [];
                            foreach ($sub_option_key->bookingSubOption as $key) {
                                if ($key->getSubOption) {
                                    $temp_sso_array[] = $key->getSubOption->toArray();
                                }
                            }
                            if (isset($sub_option_key->getServiceSub) && $sub_option_key->getServiceSub && sizeof($sub_option_key->getServiceSub)) {
                                $sub_option_key->getServiceSub->suboption = $temp_sso_array;
                            }
                        }
                        if (isset($sub_option_key->getServiceSub) && $sub_option_key->getServiceSub && sizeof($sub_option_key->getServiceSub)) {
                            $temp_ss_array[] = $sub_option_key->getServiceSub->toArray();
                        }
                    }
                    $value->getService->subService = $temp_ss_array;
                }
                if ($value->getService) {
                    $temp_s_array[] = $value->getService->toArray();
                }
            }
            $results['service'] = $temp_s_array;
        }
        if ($result->payment) {
            $results['payment'] = $result->payment->toArray();
        }
        if (!is_null($result->bookingMechanic)) {
            $results['bookingMechanic'] = $result->bookingMechanic->mechanic->toArray();
            $ratings = User::find($result->bookingMechanic->mechanic_id)->getRating;
            if ($ratings->isNotEmpty()) {
                $results['mean_overAllRating'] = $ratings->avg('overall_rating');
            } else {
                $results['mean_overAllRating'] = 0;
            }
        } else {
            $results['bookingMechanic'] = [];
        }

        // Whole Ghana
        $results['area_coordinates'] = [
            'swLat' => '5.00516180947638',
            'neLat' => '8.014526551921673',
            'swlng' => '-1.187302276367177',
            'nelng' => '0.859085723632802'
        ];

        // Accra Region Only
        /*
          $results['area_coordinates'] = [
          'swLat' => '5.535376410047374',
          'neLat' => '5.672049193031923',
          'swlng' => '-0.3510726763671528',
          'nelng' => '-0.02285612363277778'
          ];
         */
        /*
          $results['area_coordinates'] = [
          'swLat' => '7.878516180947638',
          'neLat' => '8.014526551921673',
          'swlng' => '0.0302354',
          'nelng' => '0.0302354'
          ];
         */

        return $results;
    }

    public function getBookinglistDetails(BookingMechanic $data) {
        try {
            $result = $this->booking->findOrFail($data->booking_id);
            $results = $this->getSingleBookingDetails($result);

            $results['mech_response'] = $data->mech_response;
            $results['booking_mechanic_id'] = $data->id;

            return $results;
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function getSingleBookingDetails(Booking $result) {
        $results['address'] = $result->getZipCode->zip_code;
        $results['booking_id'] = $result->id;
        $results['booking_date_time'] = $result->date_time;
        if ($result->schedule_date) {
            $results['booking_date_time'] = $result->schedule_date;
        }
        $results['booking_status'] = $result->status;
        $results['booking_price'] = $result->price;
        $results['car_year'] = $result->carTrim->carmodel->years->year;
        $results['car_brand'] = $result->carTrim->carmodel->years->cars->brand;
        $results['car_trim'] = $result->carTrim->car_trim_name;
        $results['car_model'] = $result->carTrim->carmodel->modal_name;
        $resultss['bookingItems'] = $result->bookingItems;

        if ($resultss['bookingItems'] && sizeof($resultss['bookingItems'])) {
            foreach ($resultss['bookingItems'] as $value) {
                $results['category_id'] = $value->getService->category->id;
                if ($value->getService->category->id == 1) {
                    $results['service_name'] = $value->getService->title;
                } elseif ($value->getService->category->id == 3) {
                    $results['service_name'] = 'Inspection Service';
                }
                $results['service'] = $value->getService->title;
            }
        } else {
            $results['category_id'] = 0;
            $results['service_name'] = 'Custom Service';
            $results['service'] = '';
        }

        return $results;
    }

    public function filteBookingCollection($booking_collection) {
        if ($booking_collection->isNotEmpty()) {
            foreach ($booking_collection as $booking_key => $booking) {
                if (!$this->checkCarStatusByBooking($booking->id)) {
                    unset($booking_collection[$booking_key]);
                }
            }
        }
        return $booking_collection;
    }

    public function checkCarStatusByBooking($booking_id) {
        $booking = $this->find($booking_id);
        if ($booking->getUser->getCars->where('status', 1)->where('car_trim_id', $booking->cartrim_id)->isEmpty()) {
            return false;
        }
        return true;
    }

    public function getBookingsList($user_id, $start_date, $end_date) {
        $results = DB::select('SELECT * 
                               FROM bookings
                               Where status not in (3,4,5) And user_id =? And schedule_date between ? and ?'
                        , array($user_id, $start_date, $end_date));
        return $results;

//        $result = Booking::whereNotIn('status',[3, 4,5])
//                         ->whereUser_id($user_id)
//                         ->whereBetween('schedule_date',[$start_date,$end_date])
//                         ->get();
    }

    public function bookingFromAdmin(array $booking_details) {
        $user_id = (isset($booking_details['user_id']) && $booking_details['user_id']) ? $booking_details['user_id'] : 0;
        $exception = DB::transaction(function () use($booking_details) {
                    $booking_data = ConvertIntoArray::bookingFromAdmin($booking_details);
                    $booking_result = $this->booking->create($booking_data);
                    if (isset($booking_details['service']) && $booking_details['service'] && count($booking_details['service']) > 0) {

                        foreach ($booking_details['service'] as $key) {
                            $bookingitem_data = ConvertIntoArray::bookingItem($booking_result, $key);
                            $bookingitem_result = $this->bookingItems->create($bookingitem_data);

                            if (isset($key['service_sub']) && count($key['service_sub']) > 0) {
                                foreach ($key['service_sub'] as $service_sub) {
                                    $bookingservicesub_data = ConvertIntoArray::bookingServiceSub($bookingitem_result, $service_sub);
                                    $bookingservicesub_result = $this->bookingServiceSub->create($bookingservicesub_data);

                                    if (isset($service_sub['sub_option']) && count($service_sub['sub_option']) > 0) {
                                        foreach ($service_sub['sub_option'] as $sub_option) {
                                            $bookingsuboption_data = ConvertIntoArray::bookingSubOption($bookingservicesub_result, $sub_option);
                                            $bookingsuboption_result = $this->bookingSubOption->create($bookingsuboption_data);
                                        }
                                    }
                                }
                            }
                        }
                    }
                    return $booking_result;
                });
        if (!is_null($exception)) {
            if ($user_id) {
                if ($exception instanceof $this->booking) {
                    $user = $this->user->find($user_id);
                    if ($user) {
                        if ($user->email)
                            Event::fire(new SendMail($exception));
                        Event::fire(new StatusLiked($user->name));
                    }
                }
            }
            return true;
        }
        return false;
    }

    public function bookingFromAdminUpdate(array $booking_details) {
        $user_id = (isset($booking_details['user_id']) && $booking_details['user_id']) ? $booking_details['user_id'] : 0;
        $booking_id = (isset($booking_details['booking_id']) && $booking_details['booking_id']) ? $booking_details['booking_id'] : 0;
        $exception = DB::transaction(function () use($booking_details, $booking_id) {
                    $booking_data = ConvertIntoArray::bookingFromAdmin($booking_details, 'update');
                    $booking_result = $this->booking->update($booking_data, array('id' => $booking_id));
                    $booking_result = [];
                    $booking_result['id'] = $booking_id;
                    if (isset($booking_details['service']) && $booking_details['service'] && count($booking_details['service']) > 0) {

                        foreach ($booking_details['service'] as $key) {
                            $bookingitem_data = ConvertIntoArray::bookingItem($booking_result, $key);
                            $bookingitem_result = $this->bookingItems->create($bookingitem_data);

                            if (isset($key['service_sub']) && count($key['service_sub']) > 0) {
                                foreach ($key['service_sub'] as $service_sub) {
                                    $bookingservicesub_data = ConvertIntoArray::bookingServiceSub($bookingitem_result, $service_sub);
                                    $bookingservicesub_result = $this->bookingServiceSub->create($bookingservicesub_data);

                                    if (isset($service_sub['sub_option']) && count($service_sub['sub_option']) > 0) {
                                        foreach ($service_sub['sub_option'] as $sub_option) {
                                            $bookingsuboption_data = ConvertIntoArray::bookingSubOption($bookingservicesub_result, $sub_option);
                                            $bookingsuboption_result = $this->bookingSubOption->create($bookingsuboption_data);
                                        }
                                    }
                                }
                            }
                        }
                    }
                    return $booking_result;
                });
        if (!is_null($exception)) {
            if ($user_id) {
                if ($exception instanceof $this->booking) {
                    $user = $this->user->find($user_id);
                    if ($user) {
                        if ($user->email)
                            Event::fire(new SendMail($exception));
                        Event::fire(new StatusLiked($user->name));
                    }
                }
            }
            return true;
        }
        return false;
    }

}
