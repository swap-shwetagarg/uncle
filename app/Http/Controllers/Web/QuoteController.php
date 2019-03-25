<?php

namespace App\Http\Controllers\Web;

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
use App\Http\Controllers\Web\Mobile_Detect;
use App\Models\Services;
use Illuminate\Support\Facades\App;

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
    protected $mobile_detect;

    public function __construct(ZipCodeService $zipcode, CarService $cars, YearService $years, ModelService $carmodel, CarTrimService $cartrim, ServiceTypeService $servicetype, CategoryService $category, CarServiceService $services, SubServiceService $subservices, UserService $user, BookingService $bookingService, UserCarService $usercar, SubServiceOptService $subservicesopt, Mobile_Detect $mobile_detect) {
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
        $this->mobile_detect = $mobile_detect;
    }

    public function home() {
        $iosDevice = false;
        if ($this->mobile_detect->isiOS()) {
            $iosDevice = true;
        }
        $androidDevice = false;
        if ($this->mobile_detect->isAndroidOS()) {
            $androidDevice = true;
        }
        $data['iosDevice'] = $iosDevice;
        $data['androidDevice'] = $androidDevice;
        return view('web.blocks.pages.home', $data);
    }

    /**
     * Show Location Form
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        if (isset($request->request_book) && $request->request_book) {
            $cookie_encoded_service = Cookie::get('uf_services');
            if (isset($cookie_encoded_service) && $cookie_encoded_service) {
                Cookie::queue(Cookie::forget('uf_services'));
                $cookie_array = json_decode($cookie_encoded_service, true);
                if (!in_array($request->request_book, $cookie_array)) {
                    $temp_array[] = $this->services->find($request->request_book);
                    $data['services'] = $temp_array;
                    $data['selected_service_view'] = $this->showSubServices($request->request_book, $request);
                    $ids_array[] = $request->request_book;
                    Cookie::queue('uf_services', json_encode($ids_array), 600);
                } else {
                    return redirect('request-a-quote');
                }
            } else {
                $temp_array[] = $this->services->find($request->request_book);
                $data['services'] = $temp_array;
                $data['selected_service_view'] = $this->showSubServices($request->request_book, $request);
                $ids_array[] = $request->request_book;
                Cookie::queue('uf_services', json_encode($ids_array), 600);
            }
        } else {
            Cookie::queue(Cookie::forget('uf_services'));
            Cookie::queue(Cookie::forget('uf_services_alt'));
            Cookie::queue(Cookie::forget('uf_sub_service_options'));
        }
        $data['popular_services'] = $this->services->getPopularServices();

        $auth_user = Auth::user();

        $car_info_data = [];
        // Read Cookie
        $cookie_data = Cookie::get('uf_car_info');
        if (isset($cookie_data) && $cookie_data) {
            $cookie_array = json_decode($cookie_data, true);
            // If Car Trim Id in Cookie
            if (isset($cookie_array['trim_id']) && $cookie_array['trim_id']) {
                $trim_id = $cookie_array['trim_id'];
                $trim = $this->cartrim->find($trim_id);
                $car_info_data['trim'] = $trim;
                $car_info_data['model'] = $trim[0]->carmodel;
                $car_info_data['year'] = $trim[0]->carmodel->years;
                $car_info_data['car'] = $trim[0]->carmodel->years->cars;
            }
            // If Location Id in Cookie
            if (isset($cookie_array['location_id']) && $cookie_array['location_id']) {
                $location = $cookie_array['location_id'];
                $car_info_data['location'] = $this->zipcode->find($location);

                // Get User's Cars
                if ($auth_user) {
                    $user_cars = $auth_user->getActiveCars;
                    if ($user_cars && !$user_cars->isEmpty()) {
                        $data['user_cars'] = $user_cars;
                    } else {
                        $car_info_data['cars'] = $this->cars->findAll(1);
                    }
                } else {
                    $car_info_data['cars'] = $this->cars->findAll(1);
                }
            }
            $data['car_info_data'] = $car_info_data;
        }

        $data['locations'] = $this->zipcode->findAll(1);

        $servicetypes = $this->servicetype->findAll(1);
        if ($servicetypes) {
            $data['service_types'] = view('web.blocks.pages.show-services', ['service_types' => $servicetypes, 'popular_services' => $data['popular_services']]);
        }

        $service_types_diagnostics = $this->servicetype->find(2);
        $data['service_types_diagnostics'] = $service_types_diagnostics;
        return view('web.blocks.pages.booking', $data);
    }

    /**
     * Check the service availability at particular location.
     *
     * @return \Illuminate\Http\Response
     */
    public function checkLocation($location = "") {
        if ($location && $location != '') {
            $result = $this->zipcode->find($location);
            if (!$result->isEmpty()) {

                $cookie_data = Cookie::get('uf_car_info');
                if (isset($cookie_data) && $cookie_data) {
                    $cookie_array = json_decode($cookie_data, true);
                    $cookie_array['location_id'] = $result[0]->id;
                    Cookie::queue('uf_car_info', json_encode($cookie_array), 600);
                } else {
                    $cookie_array['location_id'] = $result[0]->id;
                    Cookie::queue('uf_car_info', json_encode($cookie_array), 600);
                }
                $response = "Great! We have certified mobile mechanics in " . $result[0]->zip_code;
                return response()->json(['status' => 'success', 'data' => $response], 200);
            } else {
                $response = "UncleFitter's mechanic does not yet service your area.";
                return response()->json(['status' => 'failed', 'data' => $response], 200);
            }
        }
        return FALSE;
    }

    /**
     * Show all the Car's listing
     *
     * @return \Illuminate\Http\Response
     */
    public function showCars($new = 0) {
        // Add New Car
        if ($new) {
            $data['cars'] = $this->cars->findAll(1);
            return view('web.blocks.pages.car-listings', $data);
        } else {
            // Get User's Cars
            if (Auth::check()) {
                $user_cars = Auth::user()->getActiveCars;
                if ($user_cars && sizeof($user_cars)) {
                    $data['user_cars'] = $user_cars;
                    return view('web.blocks.pages.user-cars', $data);
                } else {
                    $data['cars'] = $this->cars->findAll(1);
                    return view('web.blocks.pages.car-listings', $data);
                }
            } else {
                $data['cars'] = $this->cars->findAll(1);
                return view('web.blocks.pages.car-listings', $data);
            }
        }
    }

    /**
     * Show all the Car's year
     *
     * @return \Illuminate\Http\Response
     */
    public function showYears($car_id = 0) {
        if ($car_id && $car_id != 0) {
            $car = $this->cars->find($car_id);
            if ($car) {
                $years = $car[0]->years->sortByDesc('year');
                if (count($years) > 0 && $years != []) {
                    $data['years'] = $years;
                    $data['car_id'] = $car_id;
                    $cookie_data = Cookie::get('uf_car_info');
                    if (isset($cookie_data) && $cookie_data) {
                        $cookie_array = json_decode($cookie_data, true);
                        $cookie_array['car_id'] = $car_id;
                        Cookie::queue('uf_car_info', json_encode($cookie_array), 600);
                    }
                    return view('web.blocks.pages.year-listings', $data);
                } else {
                    return 0;
                }
            }
        }
        return false;
    }

    /**
     * Show all the Car's models
     *
     * @return \Illuminate\Http\Response
     */
    public function showCarModels($year_id = 0) {
        if ($year_id && $year_id != 0) {
            $year = $this->years->find($year_id);
            if ($year) {
                $carmodels = $year[0]->model;
                if (count($carmodels) > 0 && $carmodels != []) {
                    $data['car_models'] = $carmodels;
                    $data['year_id'] = $year_id;

                    $cookie_data = Cookie::get('uf_car_info');
                    if (isset($cookie_data) && $cookie_data) {
                        $cookie_array = json_decode($cookie_data, true);
                        $cookie_array['year_id'] = $year_id;
                        Cookie::queue('uf_car_info', json_encode($cookie_array), 600);
                    }
                    return view('web.blocks.pages.model-listings', $data);
                } else {
                    return 0;
                }
            }
        }
        return false;
    }

    /**
     * Show all the Car's models
     *
     * @return \Illuminate\Http\Response
     */
    public function showCarTrims($model_id = 0) {
        if ($model_id && $model_id != 0) {
            $model = $this->carmodel->find($model_id);
            if ($model) {
                $cartrims = $model[0]->carTrim;
                if (count($cartrims) > 0 && $cartrims != []) {
                    $data['car_trims'] = $cartrims;
                    $data['model_id'] = $model_id;

                    $cookie_data = Cookie::get('uf_car_info');
                    if (isset($cookie_data) && $cookie_data) {
                        $cookie_array = json_decode($cookie_data, true);
                        $cookie_array['model_id'] = $model_id;
                        Cookie::queue('uf_car_info', json_encode($cookie_array), 600);
                    }
                    return view('web.blocks.pages.trim-listings', $data);
                } else {
                    return 0;
                }
            }
        }
        return false;
    }

    /**
     * Show Full car info (Brand, Year, Model and Trim) as well as Service Types
     *
     * @return \Illuminate\Http\Response
     */
    public function showCarInfo($trim_id = 0, $selected_car = 0) {
        if ($trim_id && $trim_id != 0) {
            // If Choose Selected Car
            if ($selected_car) {
                $trim = $this->cartrim->find($trim_id);
                $data['car_trim'] = $trim;
                $data['car_model'] = $trim[0]->carmodel;
                $data['year'] = $trim[0]->carmodel->years;
                $data['car'] = $trim[0]->carmodel->years->cars;

                $cookie_data = Cookie::get('uf_car_info');
                if ($cookie_data) {
                    $cookie_array = json_decode($cookie_data, true);
                    if ($cookie_array && sizeof($cookie_array)) {
                        $cookie_array = json_decode($cookie_data, true);
                        $cookie_array['trim_id'] = $trim_id;
                        Cookie::queue('uf_car_info', json_encode($cookie_array), 600);
                    }
                }
                $cookie_data_service = Cookie::get('uf_services');
                if (isset($cookie_data_service) && $cookie_data_service) {
                    return $this->getServiceCarInfo($cookie_data_service, $trim);
                }
                return view('web.blocks.pages.selected-car-info', $data);
            } else {
                $data = [];
                $cookie_data = Cookie::get('uf_car_info');
                if ($cookie_data) {
                    $cookie_array = json_decode($cookie_data, true);
                    if ($cookie_array && sizeof($cookie_array)) {

                        if (isset($cookie_array['car_id']) && $cookie_array['car_id']) {
                            $car_id = $cookie_array['car_id'];
                            $car = $this->cars->find($car_id);
                            if ($car) {
                                $data['car'] = $car[0]->brand;
                            }
                        }

                        if (isset($cookie_array['year_id']) && $cookie_array['year_id']) {
                            $year_id = $cookie_array['year_id'];
                            $year = $this->years->find($year_id);
                            if ($year) {
                                $data['year'] = $year[0]->year;
                            }
                        }

                        if (isset($cookie_array['model_id']) && $cookie_array['model_id']) {
                            $model_id = $cookie_array['model_id'];
                            $model = $this->carmodel->find($model_id);
                            if ($model) {
                                $data['model'] = $model[0]->modal_name;
                            }
                        }

                        $trim = $this->cartrim->find($trim_id);
                        if ($trim) {
                            if (strpos($trim[0]->car_trim_name, '(') !== false) {
                                $car_trim_name = substr(strstr($trim[0]->car_trim_name, '('), strlen('('));
                                $data['trim'] = str_replace(')', '', $car_trim_name);
                            } else {
                                $data['trim'] = $trim[0]->car_trim_name;
                            }
                        }

                        $cookie_array = json_decode($cookie_data, true);
                        $cookie_array['trim_id'] = $trim_id;
                        Cookie::queue('uf_car_info', json_encode($cookie_array), 600);

                        $servicetypes = $this->servicetype->findAll();
                        if ($servicetypes) {
                            $data['service_types'] = $servicetypes;
                        }

                        $cookie_data_service = Cookie::get('uf_services');
                        if (isset($cookie_data_service) && $cookie_data_service) {
                            return $this->getServiceCarInfo($cookie_data_service, $trim);
                        }
                        return 1;
                    }
                }
            }
        }
        return false;
    }

    /* Get Service Car Info */

    public function getServiceCarInfo($cookie_data_service, $trim) {
        $data_cookie['uf_services_cookie'] = $cookie_data_service;
        $service_array = json_decode($cookie_data_service, true);
        if ($service_array && sizeof($service_array)) {
            Cookie::queue(Cookie::forget('uf_services'));
            $data_cookie['car_trim'] = $trim;
            $data_cookie['car_model'] = $trim[0]->carmodel;
            $data_cookie['year'] = $trim[0]->carmodel->years;
            $data_cookie['car'] = $trim[0]->carmodel->years->cars;
            foreach ($service_array as $key => $service_id) {
                $car_info_view = view('web.blocks.pages.selected-car-info', $data_cookie);
                $contents = $car_info_view->render();
                return response()->json([
                            'status' => true,
                            'service_id' => $service_id,
                            'car_info_view' => $contents
                ]);
            }
        }
    }

    /**
     * Show all the Sub-Services
     *
     * @return \Illuminate\Http\Response
     */
    public function showSubServices($service_id = 0, Request $request) {
        if ($service_id && $service_id != 0) {
            $service = $this->services->find($service_id);
            if ($service) {
                $cookie_data = Cookie::get('uf_services');
                if (isset($cookie_data) && $cookie_data) {
                    $cookie_array = json_decode($cookie_data, true);
                    if (!in_array($service_id, $cookie_array)) {
                        $cookie_array[] = $service_id;
                    }
                    $cookie_array = array_unique($cookie_array);
                    Cookie::queue('uf_services', json_encode($cookie_array), 600);
                    $_SESSION['uf_services'] = json_encode($cookie_array);
                } else {
                    $cookie_array = [];
                    $cookie_array[] = $service_id;
                    $cookie_array = array_unique($cookie_array);
                    Cookie::queue('uf_services', json_encode($cookie_array), 600);
                    $_SESSION['uf_services'] = json_encode($cookie_array);
                }
                $cookie_data_sservice_options = Cookie::get('uf_sub_service_options');
                if (isset($cookie_data_sservice_options) && $cookie_data_sservice_options) {
                    $data_sservice_options = json_decode($cookie_data_sservice_options, true);
                    if (is_array($data_sservice_options) && count($data_sservice_options)) {
                        foreach ($data_sservice_options as $_key => $_val) {
                            foreach ($_val['service_sub'] as $val) {
                                foreach ($val['sub_option'] as $value) {
                                    $_Sub_Service = $this->subservicesopt->find($value['sub_service_option_id']);
                                    $_ids_arry_[$_val['service_id']][] = $_Sub_Service[0];
                                }
                            }
                        }
                    }
                    if (isset($_ids_arry_)) {
                        $selected_arry['sservice_options'] = $_ids_arry_;
                    }
                }
                $data['selected_services'] = $cookie_array;
                $selected_arry['services'] = Services::whereIn('id', $cookie_array)
                        ->get();

                $slectd_ser_html = view('web.blocks.pages.show_selected_services', $selected_arry);
                $data['selected_service'] = $cookie_array;
                $data['service'] = $service;
                $service_listing = view('web.blocks.pages.sub-services-listings', $data);
                if (isset($request->request_book) && !$request->ajax()) {
                    $view_html['slectd_ser_html'] = $slectd_ser_html;
                    $view_html['service_listing'] = $service_listing;
                    return $view_html;
                }

                return response()->json([
                            'service_listing' => $service_listing->render(),
                            'selected' => isset($slectd_ser_html) ? $slectd_ser_html->render() : ''
                ]);
            }
        }
        return false;
    }

    public function getSelectedServices() {
        $cookie_data = Cookie::get('uf_services');
        if (isset($cookie_data) && $cookie_data) {
            $cookie_array = json_decode($cookie_data, true);
            $data['selected_service'] = array_unique($cookie_array);
            return view('web.blocks.pages.sub-services-listings', $data);
        }
    }

    /**
     * Reset form
     */
    public function resetQuotation() {
        $cookie_data = Cookie::get('uf_car_info');
        if (isset($cookie_data) && $cookie_data) {
            return redirect('request-a-quote')->withCookie(Cookie::forget('uf_car_info'));
        }
    }

    /**
     * Review And Book
     */
    public function reviewAndBook(Request $request) {
        $request_array = $request->all();

        $data = [];
        // Get Car Info From Cookie
        $cookie_data_car = Cookie::get('uf_car_info');
        if (isset($cookie_data_car) && $cookie_data_car) {
            $car_array = json_decode($cookie_data_car, true);
            if (isset($car_array['location_id']) && $car_array['location_id']) {
                $data['location_id'] = $car_array['location_id'];
            }
        }

        if (isset($request_array['service_ids']) && $request_array['service_ids']) {
            $services_array = explode(',', $request_array['service_ids']);
            $services_array = array_unique($services_array);
            if (isset($services_array) && $services_array && is_array($services_array) && sizeof($services_array)) {
                $temp_array = [];
                foreach ($services_array as $key => $service_id) {
                    $temp_array[] = $this->services->find($service_id);
                }
                $data['services'] = $temp_array;
                Cookie::queue(Cookie::forget('uf_services_alt'));
                Cookie::queue('uf_services', json_encode($services_array), 600);
                Cookie::queue('uf_services_alt', json_encode($services_array), 600);
            }
        } else {
            $data['services'] = false;
        }

        // Get Service Info From Cookie
        $cookie_data_sservice_options = Cookie::get('uf_sub_service_options');
        if (isset($cookie_data_sservice_options) && $cookie_data_sservice_options) {
            $data_sservice_options = json_decode($cookie_data_sservice_options, true);
            if (is_array($data_sservice_options) && count($data_sservice_options)) {
                foreach ($data_sservice_options as $_key => $_val) {
                    foreach ($_val['service_sub'] as $val) {
                        foreach ($val['sub_option'] as $value) {
                            $_Sub_Service = $this->subservicesopt->find($value['sub_service_option_id']);
                            $_ids_arry_[$_val['service_id']][] = $_Sub_Service[0];
                        }
                    }
                }
            }
            if (isset($_ids_arry_)) {
                $data['sservice_options'] = $_ids_arry_;
            }
        }

        $data['locations'] = $this->zipcode->findAll(1);

        if (isset($request_array['own_service_description']) && $request_array['own_service_description']) {
            $data['own_service_description'] = $request_array['own_service_description'];
        }
        return view('web.blocks.pages.review-and-book', $data);
    }

    /**
     * Add More Services
     */
    public function addMoreServices($action = 0) {
        $slectd_ser_html = null;
        if ($action) {
            Cookie::queue(
                    Cookie::forget('uf_services')
            );
        } else {
            $sservice_options = [];
            $cookie_data = Cookie::get('uf_services');

            $cookie_data_sservice_options = Cookie::get('uf_sub_service_options');
            if (isset($cookie_data_sservice_options) && $cookie_data_sservice_options) {
                $data_sservice_options = json_decode($cookie_data_sservice_options, true);
                if (is_array($data_sservice_options) && count($data_sservice_options)) {
                    foreach ($data_sservice_options as $_key => $_val) {
                        foreach ($_val['service_sub'] as $val) {
                            foreach ($val['sub_option'] as $value) {
                                $_Sub_Service = $this->subservicesopt->find($value['sub_service_option_id']);
                                $_ids_arry_[$_val['service_id']][] = $_Sub_Service[0];
                            }
                        }
                    }
                }
                if (isset($_ids_arry_)) {
                    $sservice_options = $_ids_arry_;
                }
            }
            if (isset($cookie_data) && $cookie_data) {
                $cookie_array = json_decode($cookie_data, true);
                $cookie_array = array_unique($cookie_array);
                $data['selected_services'] = $cookie_array;
                $slted_ser_obj_c = Services::whereIn('id', $cookie_array)
                        ->get();
                $slectd_ser_html = view('web.blocks.pages.show_selected_services', [
                    'services' => $slted_ser_obj_c,
                    'sservice_options' => $sservice_options,
                ]);
            }
        }
        $servicetypes = $this->servicetype->findAll();
        $data['popular_services'] = $this->services->getPopularServices();
        if ($servicetypes) {
            $data['service_types'] = $servicetypes;
        }
        $show_services = view('web.blocks.pages.show-services', $data);
        return response()->json([
                    'status' => 'success',
                    'show_services' => $show_services->render(),
                    'selected' => (isset($slted_ser_obj_c)) ? $slectd_ser_html->render() : ''
        ]);
    }

    /**
     * Delete Selected Service From Front End
     */
    public function deleteSelectedService($service_id = 0, Request $request) {
        if (isset($service_id) && $service_id) {
            $cookie_data_sservice_options = Cookie::get('uf_sub_service_options');
            if (isset($cookie_data_sservice_options) && $cookie_data_sservice_options) {
                $data_sservice_options = json_decode($cookie_data_sservice_options, true);
                if (is_array($data_sservice_options) && count($data_sservice_options)) {
                    foreach ($data_sservice_options as $_key => $_val) {
                        if ($_val['service_id'] == $service_id) {
                            unset($data_sservice_options[$_key]);
                            Cookie::queue('uf_sub_service_options', json_encode($data_sservice_options), 600);
                        }
                    }
                }
            }

            $cookie_data = Cookie::get('uf_services');
            if (isset($cookie_data) && $cookie_data) {
                $cookie_array = json_decode($cookie_data, true); // 0->[1, 2], 1-> [2], 2-> []
                if (in_array($service_id, $cookie_array)) {
                    $search_key = array_search($service_id, $cookie_array);
                    unset($cookie_array[$search_key]);
                    if (sizeof($cookie_array)) {
                        Cookie::queue('uf_services', json_encode($cookie_array), 600);
                        return response()->json(['status' => 'success', 'tag' => 'single_delete']);
                    } else {
                        return $this->addMoreServices(1);
                    }
                }
            }
        }
        Cookie::queue(
                Cookie::forget('uf_services')
        );
        return $this->addMoreServices(1);
    }

    /**
     * Save Sub Service Option into Cookie
     */
    public function saveSubServiceOption($service_id, $sub_service_id, $option_id = 0, $action = '', $type) {
        $cookie_data = Cookie::get('uf_sub_service_options');
        if (isset($cookie_data) && $cookie_data) {
            $new_service = true;
            $new_sub_service_id = true;
            $new_sub_service_option_id = true;
            $cookie_array = json_decode($cookie_data, true);
            if ($type == 1) {
                foreach ($cookie_array as $service_arr_key => $service_arr) {
                    if ($service_arr['service_id'] == $service_id) {
                        $new_service = false;
                        foreach ($service_arr['service_sub'] as $service_sub_key => $service_sub) {
                            if ($service_sub['sub_service_id'] == $sub_service_id) {
                                $new_sub_service_id = false;
                                foreach ($service_sub['sub_option'] as $sub_option_key => $sub_option) {
                                    $cookie_array[$service_arr_key]['service_sub'][$service_sub_key]['sub_option'][$sub_option_key]['sub_service_option_id'] = $option_id;
                                }
                            }
                        }
                        if ($new_sub_service_id) {
                            $sub_service_index = count($service_arr['service_sub']);
                            $cookie_array[$service_arr_key]['service_sub'][$sub_service_index]['sub_service_id'] = $sub_service_id;
                            $cookie_array[$service_arr_key]['service_sub'][$sub_service_index]['sub_option'][0]['sub_service_option_id'] = $option_id;
                        }
                    }
                }
                if ($new_service) {
                    $index = count($cookie_array);
                    $service_array['service_id'] = $service_id;
                    $service_array['service_sub'][0]['sub_service_id'] = $sub_service_id;
                    $service_array['service_sub'][0]['sub_option'][0]['sub_service_option_id'] = $option_id;
                    $cookie_array[] = $service_array;
                }
            } else {
                if ($action == 'remove') {
                    foreach ($cookie_array as $service_arr_key => $service_arr) {
                        if ($service_arr['service_id'] == $service_id) {
                            foreach ($service_arr['service_sub'] as $service_sub_key => $service_sub) {
                                if ($service_sub['sub_service_id'] == $sub_service_id) {
                                    foreach ($service_sub['sub_option'] as $sub_option_key => $sub_option) {
                                        if ($sub_option['sub_service_option_id'] == $option_id) {
                                            unset($cookie_array[$service_arr_key]['service_sub'][$service_sub_key]['sub_option'][$sub_option_key]);
                                        }
                                    }
                                }
                            }
                        }
                    }
                } elseif ($action == 'add') {
                    foreach ($cookie_array as $service_arr_key => $service_arr) {
                        if ($service_arr['service_id'] == $service_id) {
                            $new_service = false;
                            foreach ($service_arr['service_sub'] as $service_sub_key => $service_sub) {
                                if ($service_sub['sub_service_id'] == $sub_service_id) {
                                    $new_sub_service_id = false;
                                    foreach ($service_sub['sub_option'] as $sub_option_key => $sub_option) {
                                        if ($sub_option['sub_service_option_id'] == $option_id) {
                                            $new_sub_service_option_id = false;
                                            $cookie_array[$service_arr_key]['service_sub'][$service_sub_key]['sub_option'][$sub_option_key]['sub_service_option_id'] = $option_id;
                                        }
                                    }
                                    if ($new_sub_service_option_id) {
                                        $sub_service_option_index = count($service_sub['sub_option']);
                                        $cookie_array[$service_arr_key]['service_sub'][$service_sub_key]['sub_option'][$sub_service_option_index]['sub_service_option_id'] = $option_id;
                                    }
                                }
                            }
                            if ($new_sub_service_id) {
                                $sub_service_index = count($service_arr['service_sub']);
                                $cookie_array[$service_arr_key]['service_sub'][$sub_service_index]['sub_service_id'] = $sub_service_id;
                                $cookie_array[$service_arr_key]['service_sub'][$sub_service_index]['sub_option'][0]['sub_service_option_id'] = $option_id;
                            }
                        }
                    }
                    if ($new_service) {
                        $index = count($cookie_array);
                        $service_array['service_id'] = $service_id;
                        $service_array['service_sub'][0]['sub_service_id'] = $sub_service_id;
                        $service_array['service_sub'][0]['sub_option'][0]['sub_service_option_id'] = $option_id;
                        $cookie_array[] = $service_array;
                    }
                }
            }
            Cookie::queue('uf_sub_service_options', json_encode($cookie_array), 600);
        } else {
            $i = 0;
            $service_array[$i]['service_id'] = $service_id;
            $service_array[$i]['service_sub'][$i]['sub_service_id'] = $sub_service_id;
            $service_array[$i]['service_sub'][$i]['sub_option'][$i]['sub_service_option_id'] = $option_id;
            $cookie_array = $service_array;
            Cookie::queue('uf_sub_service_options', json_encode($cookie_array), 600);
        }
    }

    // Show Diagnostics Type Services
    public function showDiagnosticsSubServices($service_id = 0) {
        if ($service_id && $service_id != 0) {
            $service = $this->services->find($service_id);
            if ($service && !$service->isEmpty()) {
                $sub_services = $service[0]->subservice;
                if ($service[0]->recommend_service_id) {
                    $data['recommended_service'] = $this->services->find($service[0]->recommend_service_id)[0];
                }
                $cookie_data = Cookie::get('uf_services');
                if (isset($cookie_data) && $cookie_data) {
                    $cookie_array = json_decode($cookie_data, true);
                    $cookie_array[] = $service_id;
                    //Cookie::queue('uf_services', json_encode($cookie_array), 600);
                } else {
                    $cookie_array = [];
                    $cookie_array[] = $service_id;
                    //Cookie::queue('uf_services', json_encode($cookie_array), 600);
                }
                $data['service'] = $service;
                return view('web.blocks.pages.diagnostics-sub-services-listings', $data);
            }
        }
        return false;
    }

    // Show Next Sub-Service with options
    public function showNextSubServices($sub_service_id = 0, $option_id = 0, $service_id = 0) {
        if ($sub_service_id && $sub_service_id != 0 && $option_id && $option_id != 0 && $service_id && $service_id != 0) {
            $sub_service = $this->subservices->find($sub_service_id);
            if ($sub_service) {
                $data['service_id'] = $service_id;
                $data['option_id'] = $option_id;
                $data['sub_service'] = $sub_service;
                return view('web.blocks.pages.next-sub-services-listings', $data);
            }
        }
        return false;
    }

    // Show Recommended Services
    public function showRecommendedServices($services = '') {
        if ($services && $services != '') {
            $services_array = array_filter(explode(',', $services));
            $cookie_array = [];
            if ($services_array && sizeof($services_array)) {
                $cookie_data = Cookie::get('uf_services');
                if (isset($cookie_data) && $cookie_data) {
                    $cookie_array = json_decode($cookie_data, true);
                }
                $temp_array = [];
                foreach ($services_array as $key => $service) {
                    if (!in_array($service, $cookie_array)) {
                        $cookie_array[] = $service;
                        $temp_array[] = $this->services->find($service);
                    }
                }
                $cookie_array = array_unique($cookie_array);
                Cookie::queue('uf_services', json_encode($cookie_array), 600);
                $data['recommended_services'] = $temp_array;
                $data['selected_service'] = $cookie_array;
                return view('web.blocks.pages.show-recommended-service', $data);
            }
        }
        return false;
    }

    /**
     * Submit Quotation
     */
    public function submitQuotation(Request $request) {
        //$data = $request->all();
        $exist_service_id = [];
        $request_array = $request->all();
        $cookie_data = Cookie::get('uf_car_info');
        $cookie_data_services = Cookie::get('uf_services_alt');
        $response_user = Auth::user();

        if (isset($cookie_data_services) && $cookie_data_services) {
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

                            $uf_options_cookie_data = Cookie::get('uf_sub_service_options');
                            if ($uf_options_cookie_data) {
                                $uf_options_cookie_array = json_decode($uf_options_cookie_data, true);
                                foreach ($uf_options_cookie_array as $uf_options_cookie_array_value) {
                                    $exist_service_id[] = $uf_options_cookie_array_value['service_id'];
                                    $temp_s_array[] = $uf_options_cookie_array_value;
                                    $booking_data['service'] = $temp_s_array;
                                }
                            }
                            $cookie_data_services = Cookie::get('uf_services_alt');
                            if (isset($cookie_data_services) && $cookie_data_services) {
                                $services_array = json_decode($cookie_data_services, true);
                                if (isset($services_array) && $services_array && sizeof($services_array)) {
                                    $temp_services_array = [];
                                    $temp_ss_array = [];
                                    $temp_array1 = [];
                                    foreach ($services_array as $key => $service_id) {
                                        if (in_array($service_id, $exist_service_id)) {
                                            $search_key = array_search($service_id, $services_array);
                                            unset($services_array[$search_key]);
                                        } else {
                                            $services = $this->services->find($service_id);
                                            if ($services && !$services->isEmpty()) {
                                                foreach ($services as $key => $service) {
                                                    $sub_services = $service->subservice;
                                                    if ($sub_services && !$sub_services->isEmpty()) {
                                                        $temp_array2 = [];
                                                        foreach ($sub_services as $sskey => $sub_service_id) {
                                                            $sub_service_options = $sub_service_id->subserviceopt;
                                                            if ($sub_service_options && !$sub_service_options->isEmpty()) { // [ SS1 => [O1, O2], SS2 => [O1]
                                                                $temp_array3 = [];
                                                                foreach ($sub_service_options as $okey => $sub_service_option_id) {
                                                                    $temp_array = [];
                                                                    $temp_array['sub_service_option_id'] = $sub_service_option_id->id; // O1 
                                                                    $temp_array3[] = $temp_array;
                                                                }
                                                                $temp_array2['sub_option'] = $temp_array3;
                                                            }
                                                            $temp_array2['sub_service_id'] = $sub_service_id->id;
                                                            $temp_ss_array[] = $temp_array2;
                                                        }
                                                        $temp_array1['service_sub'] = $temp_ss_array;
                                                    }
                                                    $temp_array1['service_id'] = $service->id;
                                                    $temp_s_array[] = $temp_array1;
                                                }
                                            }
                                        }
                                    }
                                    $booking_data['service'] = $temp_s_array;
                                }
                            }
                            $booking_data = array_map("unserialize", array_unique(array_map("serialize", $booking_data)));
                            // Create a Booking
                            $response_booking = $this->bookingService->booking($booking_data);
                            if ($response_booking) {
                                Log::useDailyFiles(storage_path() . '/logs/debug.log');
                                Log::info(["Booking Added {Booking: " . $response_booking . " User ID: " . $response_user->id . "}"]);
                                Cookie::queue(Cookie::forget('uf_car_info'));
                                Cookie::queue(Cookie::forget('sservice_options'));
                                Cookie::queue(Cookie::forget('uf_services'));
                                Cookie::queue(Cookie::forget('uf_services_alt'));
                                Cookie::queue(Cookie::forget('uf_sub_service_options'));
                                return redirect('thank-you')->with(['type' => 'success', 'message' => 'Thanks for requesting a quote, we will get back to you with a quote shortly.']);
                            } else {
                                return redirect('thank-you')->with(['type' => 'danger', 'message' => 'Your request a quote failed! Please try again later.']);
                            }
                        }
                    }
                }
            }
            return redirect('thank-you')->with("error", "Something wrong! Please try again later.");
        } else {
            return redirect('request-a-quote');
        }
    }

    // Thank you page after booking success
    public function thankYouForBooking() {
        return view('web.blocks.pages.thank-you');
    }

    // Delete All Selected Services
    public function deleteSelectedServices() {
        Cookie::queue(
                Cookie::forget('uf_services')
        );
        return $this->addMoreServices(1);
    }

    // Reset Services From Cookies
    public function resetServices() {
        $cookie_data = Cookie::get('uf_services');
        if (isset($cookie_data) && $cookie_data) {
            Cookie::forget('uf_services');
            Cookie::forget('uf_services_alt');
            Cookie::forget('uf_sub_service_options');
            return redirect('request-a-quote');
        } else {
            return redirect('request-a-quote');
        }
    }

    // About Our Mechanic
    public function aboutOurMechanic() {
        return view('web.blocks.pages.about-our-mechanic');
    }

    // FAQ
    public function faq() {
        return view('web.blocks.pages.faq');
    }

    // Show All Services
    public function services_all() {
        $categories = $this->category->findAll(1)->sortBy('category_name');
        return view('web.blocks.pages.services_all')->withData($categories);
    }

    // Show Each Service Detail
    public function services_details($id) {
        $service = $this->services->find($id);
        return view('web.blocks.pages.services_details')->withData($service[0]);
    }

    // Search Service
    public function searchServices($type = null, $search = null) {
        if ($type && $type == 'broader') {
            if ($search) {
                $data['services'] = $this->services->searchServices($search);
                return view('web.blocks.pages.services-lists', $data);
            } else {
                $data['data'] = $this->category->findAll(1)->sortBy('category_name');
                return view('web.blocks.pages.services-lists', $data);
            }
        } elseif ($type && $type == 'repair') {
            $cookie_data = Cookie::get('uf_services');
            if (isset($cookie_data) && $cookie_data) {
                $cookie_array = json_decode($cookie_data, true);
                $cookie_array = array_unique($cookie_array);
                $data['selected_services'] = $cookie_array;
            }
            if ($search) {
                $data['search'] = 1;
                $data['services'] = $this->services->searchServices($search, $type);
                return view('web.blocks.pages.search-repair-services-lists', $data);
            } else {
                $data['search'] = 0;
                $servicetypes = $this->servicetype->findAll(1);
                if ($servicetypes) {
                    $data['service_types'] = $servicetypes;
                }
                return view('web.blocks.pages.search-repair-services-lists', $data);
            }
        } elseif ($type && $type == 'diagnostic') {
            $cookie_data = Cookie::get('uf_services');
            if (isset($cookie_data) && $cookie_data) {
                $cookie_array = json_decode($cookie_data, true);
                $cookie_array = array_unique($cookie_array);
                $data['selected_services'] = $cookie_array;
            }
            if ($search) {
                $data['search'] = 1;
                $data['services'] = $this->services->searchServices($search, $type);
                return view('web.blocks.pages.search-diagnostic-services-lists', $data);
            } else {
                $data['search'] = 0;
                $servicetypes = $this->servicetype->findAll(1);
                if ($servicetypes) {
                    $data['service_types'] = $servicetypes;
                }
                return view('web.blocks.pages.search-diagnostic-services-lists', $data);
            }
        }
    }

}
