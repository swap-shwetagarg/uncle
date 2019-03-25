<?php

namespace App\Http\Controllers\Apis;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ZipCodeService as ZipCodeService;
use App\Services\CarService as CarService;
use App\Services\YearService as YearService;
use App\Services\ModelService as ModelService;
use App\Services\CarTrimService as CarTrimService;
use App\Services\ServiceTypeService as ServiceTypeService;
use App\Services\CategoryService as CategoryService;
use App\Services\CarServiceService as CarServiceService;
use App\Services\SubServiceService as SubServiceService;
use App\Services\UserService as UserService;
use App\Services\BookingService as BookingService;
use Jrean\UserVerification\Traits\VerifiesUsers;
use App\Services\UserCarService as UserCarService;
use App\Services\SubServiceOptService as SubServiceOptService;
use Cookie;
use Auth;
use Illuminate\Support\Facades\Log;

class QuoteController extends Controller {

    use VerifiesUsers;

    protected $zipcode;
    protected $cars;
    protected $years;
    protected $carmodel;
    protected $cartrim;
    protected $servicetype;
    protected $category;
    protected $services;
    protected $subservices;
    protected $bookingService;
    protected $user;
    protected $usercar;
    protected $subservicesopt;

    public function __construct(ZipCodeService $zipcode, CarService $cars, YearService $years, ModelService $carmodel, CarTrimService $cartrim, ServiceTypeService $servicetype, CategoryService $category, CarServiceService $services, SubServiceService $subservices, UserService $user, BookingService $bookingService, UserCarService $usercar, SubServiceOptService $subservicesopt) {
        $this->zipcode = $zipcode;
        $this->cars = $cars;
        $this->years = $years;
        $this->carmodel = $carmodel;
        $this->cartrim = $cartrim;
        $this->servicetype = $servicetype;
        $this->category = $category;
        $this->services = $services;
        $this->subservices = $subservices;
        $this->user = $user;
        $this->bookingService = $bookingService;
        $this->usercar = $usercar;
        $this->subservicesopt = $subservicesopt;
    }

    /**
     * Submit Quotation
     */
    public function submitQuotation(Request $request) {
        //$data = $request->all();
        $request_array = $request->all();
        $response_user = Auth::user();
        if ($request_array && sizeof($request_array)) {

            if (isset($response_user) && $response_user) {

                $cookie_data = Cookie::get('uf_car_info');
                if ($cookie_data) {
                    $cookie_array = json_decode($cookie_data, true);
                    if ($cookie_array && sizeof($cookie_array)) {

                        // Get Car Trim ID
                        if (isset($cookie_array['trim_id']) && $cookie_array['trim_id']) {
                            $car_trim_id = $cookie_array['trim_id'];
                        } elseif (isset($request_array['selected_user_car']) && $request_array['selected_user_car']) {
                            $car_trim_id = $request_array['selected_user_car'];
                        } elseif (isset($request_array['selected_trim']) && $request_array['selected_trim']) {
                            $car_trim_id = $request_array['selected_trim'];
                        }

                        // Add User Car for Future Use
                        $check_user_car = $this->usercar->getUserCarById($car_trim_id);
                        if ($check_user_car->isEmpty()) {
                            $data_user_car = [
                                'car_trim_id' => $car_trim_id,
                                'user_id' => $response_user->id,
                                'remember_token' => $request_array['_token']
                            ];
                            $result_car = $this->usercar->create($data_user_car);

                            Log::useDailyFiles(storage_path() . '/logs/debug.log');
                            Log::info(["User's Car Added {Car Trim ID: " . $car_trim_id . " User ID: " . $response_user->id . "}"]);
                        }

                        // Get Location/Zipcode ID
                        if (isset($cookie_array['location_id']) && $cookie_array['location_id']) {
                            $location_id = $cookie_array['location_id'];
                        } elseif (isset($request_array['location']) && $request_array['location']) {
                            $location = $request_array['location'];
                            $result = $this->zipcode->find($location);
                            if (!$result->isEmpty()) {
                                $location_id = $result[0]->id;
                            }
                        }

                        // Prepare Booking Data
                        $booking_data = [];
                        $booking_data['user_id'] = $response_user->id;
                        $booking_data['cartrim_id'] = $car_trim_id;
                        $booking_data['zipcode_id'] = $location_id;
                        $booking_data['own_service_description'] = $request_array['own_service_description'];

                        if (isset($request_array['service_id']) && $request_array['service_id'] && sizeof($request_array['service_id'])) { // [S1, S2, S3]
                            $temp_services_array = [];
                            $temp_s_array = [];
                            $temp_ss_array = [];
                            $temp_array1 = [];
                            foreach ($request_array['service_id'] as $skey => $service_id) { // [ S1 ]
                                if (isset($request_array['sub_service_id_' . $service_id]) && $request_array['sub_service_id_' . $service_id]) {
                                    $sub_service_id_array = $request_array['sub_service_id_' . $service_id];
                                    if ($sub_service_id_array && sizeof($sub_service_id_array)) { // [ S1 => SS1, S1 => SS2 ]
                                        $temp_array2 = [];
                                        foreach ($sub_service_id_array as $sskey => $sub_service_id) {
                                            $temp_array3 = [];
                                            if (isset($request_array['sub_service_option_' . $sub_service_id]) && $request_array['sub_service_option_' . $sub_service_id]) {
                                                $sub_service_options_array = $request_array['sub_service_option_' . $sub_service_id];
                                                if ($sub_service_options_array && sizeof($sub_service_options_array)) { // [ SS1 => [O1, O2], SS2 => [O1]                                                    
                                                    foreach ($sub_service_options_array as $okey => $sub_service_option_id) {
                                                        $temp_array = [];
                                                        $temp_array['sub_service_option_id'] = $sub_service_option_id; // O1 
                                                        $temp_array3[] = $temp_array;
                                                    }
                                                }
                                            }
                                            $temp_array2['sub_service_id'] = $sub_service_id;
                                            $temp_array2['sub_option'] = $temp_array3;
                                            $temp_ss_array[] = $temp_array2;
                                        }
                                    }
                                }
                                $temp_array1['service_id'] = $service_id;
                                $temp_array1['service_sub'] = $temp_ss_array;
                                $temp_s_array[] = $temp_array1;
                            }

                            $booking_data['service'] = $temp_s_array;
                        }

                        // Create a Booking
                        $response_booking = $this->bookingService->booking($booking_data);
                        if ($response_booking) {
                            Log::useDailyFiles(storage_path() . '/logs/debug.log');
                            Log::info(["Booking Added {Booking: " . $response_booking . " User ID: " . $response_user->id . "}"]);
                            return redirect('book')->with(['type' => 'success', 'message' => 'Thanks for requesting a quote, we will get back to you with a quote shortly.'])->withCookie(Cookie::forget('uf_car_info'));
                        } else {
                            return redirect('book')->with(['type' => 'danger', 'message' => 'Your request a quote failed! Please try again later.']);
                        }
                    }
                }
            }
        }
        return redirect('book')->with("error", "Something wrong! Please try again later.");
    }

    // Show Diagnostics Type Services
    public function showServices() {
        $count = 0;
        $array_collection = [];
        
        $serviceTypes = $this->servicetype->findAll(1);
        if ($serviceTypes->isNotEmpty()) {
            foreach ($serviceTypes as $serviceType) {
                if ($serviceType->category->isNotEmpty()) {
                    foreach ($serviceType->category as $category) {
                        if ($category->service->isNotEmpty()) {
                            foreach ($category->service as $service) {
                                if ($service->subservice->isNotEmpty()) {
                                    foreach ($service->subservice as $subservice) {
                                        if ($subservice->subserviceopt->isNotEmpty()) {
                                            $subservice->subserviceopt;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $popular_services = $this->services->getPopularServiceIds();
        
        return response()->json([
            'status' => 'success',
            'result' => $serviceTypes,
            'popular_service' => $popular_services
        ]);
    }

}
