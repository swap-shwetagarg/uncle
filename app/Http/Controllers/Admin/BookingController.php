<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\BookingService;
use App\Services\BookingMechanicService;
use App\Services\UserService;
use App\User;
use Event;
use Cookie;
use Auth;
use App\Events\MechanicAssignEmail;
use App\Events\MechanicReAssignEmail;
use App\Utility\BookingStatus;
use App\Events\BookingQuoted;
use App\Events\AssignMechanic;
use DateTime;
use App\Events\SendQuotedMail;
use App\Facades\AppSettings;
use App\Services\ZipCodeService;
use Illuminate\Support\Facades\Input;
use App\Services\CarService as CarService;
use App\Services\UserCarService as UserCarService;
use App\Services\ServiceTypeService as ServiceTypeService;
use App\Services\CategoryService as CategoryService;
use App\Services\CarServiceService as CarServiceService;
use App\Services\SubServiceService as SubServiceService;
use App\Services\SubServiceOptService as SubServiceOptService;
use App\Services\BookingItemsService as BookingItemsService;

class BookingController extends Controller {

    private $bookingService;
    private $bookingMechanic;
    private $userService;
    protected $zipcode;
    protected $cars;
    protected $usercar;
    protected $servicetype;
    protected $user;
    protected $category;
    protected $services;
    protected $subservices;
    protected $subservicesopt;
    protected $bookingItemsService;

    public function __construct(BookingService $bookingService, BookingMechanicService $bookingMechanic, UserService $userService, ZipCodeService $zipcode, CarService $cars, UserCarService $usercar, UserService $user, ServiceTypeService $servicetype, CategoryService $category, CarServiceService $services, SubServiceService $subservices, SubServiceOptService $subservicesopt, BookingItemsService $bookingItemsService) {
        $this->bookingService = $bookingService;
        $this->bookingMechanic = $bookingMechanic;
        $this->userService = $userService;
        $this->zipcode = $zipcode;
        $this->cars = $cars;
        $this->usercar = $usercar;
        $this->user = $user;
        $this->servicetype = $servicetype;
        $this->category = $category;
        $this->services = $services;
        $this->subservices = $subservices;
        $this->subservicesopt = $subservicesopt;
        $this->bookingItemsService = $bookingItemsService;
    }

    public function index(Request $request) {
        $vat_tax = AppSettings::get('vat_tax');
        $bookings = $this->bookingService->findAll();
        if ($request->ajax())
            return view('admin.booking.booking_table', ['bookings' => $bookings, 'vat_tax' => $vat_tax]);
        else
            return view('admin.booking.bookings', ['bookings' => $bookings, 'page' => 'bookings', 'vat_tax' => $vat_tax]);
    }

    public function getAllBookings(Request $request, $status = null) {
        $vat_tax = AppSettings::get('vat_tax');
        $booking_id = 0;
        $user_name = '';
        $ser_booking = '';
        $ser_string = isset($_GET['search']) ? $_GET['search'] : '';
        if (is_numeric($ser_string))
            $booking_id = $ser_string;
        else
            $user_name = $ser_string;
        if ($booking_id != 0 || $user_name != '') {
            $bookings = $this->bookingService->searchWithStatus($status, $booking_id, $user_name);
        } else if (!$status || $status == BookingStatus::ALL)
            $bookings = $this->bookingService->findAll();
        else
            $bookings = $this->bookingService->findByStatus($status);
        if ($status || $request->page) {
            return view('admin.booking.booking_table', ['bookings' => $bookings, 'vat_tax' => $vat_tax]);
        } else {
            return view('admin.booking.bookings', ['bookings' => $bookings, 'page' => 'bookings', 'vat_tax' => $vat_tax]);
        }
    }

    public function getBookingDetails($id) {
        $vat_tax = AppSettings::get('vat_tax');
        $booking = $this->bookingService->find($id);
        return view('admin.booking.booking_details', ['booking' => $booking, 'vat_tax' => $vat_tax]);
    }

    public function updateBookingStatus($id, $status) {
        $result = $this->bookingService->changeBookingStatus($id, ['status' => $status]);
        if ($result) {
            return response()->json(['status' => 'success', 'message' => 'Booking confirmed']);
        }
        return response()->json(['status' => 'Failed', 'message' => 'Some error occured please call admin']);
    }

    public function updateQuote($id, $price, Request $request) {
        $data = $request->all();
        $data['price'] = $price;

        // Calculate VAT Tax START
        $vat_tax = AppSettings::get('vat_tax');
        $vat_tax_price = ($price * $vat_tax) / 100;
        $data['vat_cost'] = number_format($vat_tax_price, 2);
        // Calculate VAT Tax END

        $result = $this->bookingService->update($data, $id);
        $event['details'] = $this->bookingService->find($id);
        Event::fire(new SendQuotedMail($event));
        $booking_service = $this->bookingService->find($id);
        Event::fire(new BookingQuoted($booking_service->getUser, $booking_service));
        if ($result) {
            return response()->json(['status' => 'success', 'message' => 'Quote updated']);
        }
        return response()->json(['status' => 'Failed', 'message' => 'Some error occured please call admin']);
    }

    public function availableTimes($mechanic_id, $date) {
        $available_times = $this->bookingMechanic->getAvailableTimesByMechanicId($mechanic_id, $date);
        if ((date("Y-m-d", strtotime(str_replace('/', '-', $date))) < date("Y-m-d"))) {
            $available_times = $this->bookingMechanic->getDefaultTimes();
        } elseif ((date("Y-m-d", strtotime(str_replace('/', '-', $date))) == date("Y-m-d")) && $mechanic_id != 0) {
            $arr = array('7' => 'A', '9' => 'B', '11' => 'C', '13' => 'D', '15' => 'E', '17' => 'F');
            for ($i = 7; $i <= 17; $i += 2) {
                if ((date("H") >= $i)) {
                    $available_times[0]->{$arr[$i]} = 0;
                }
            }
        }
        return view('admin.booking.schedule_availability', ['available_times' => $available_times]);
    }

    public function getMechanics($booking_id, $mechanic_id, $zipcode_id) {
        $dt = new DateTime();
        $booking = $this->bookingService->find($booking_id);
        $bookedMechanic = $this->bookingMechanic->getBookingMechanicById($booking_id);
        $isReassign = ($bookedMechanic->isEmpty() ? 0 : $bookedMechanic[0]->booking_id) == $booking_id;
        // if($isReassign)
        $users = $this->bookingMechanic->getAllNonRejectedMechanic($booking_id);
        // else
        //   $users = \App\Role::find(3);
        return view('admin.mechanic_list', ['mechanics' => $users, 'booking' => $booking, 'mechanic_id' => $mechanic_id, 'booked_mechanic' => $bookedMechanic, 'actual_time' => $dt->format(env('DATE_TIME_FORMAT'))]);
    }

    public function assignMechanic($booking_id, $mechanic_id, $from_time, $to_time) {
        $schedule_date = date("Y-m-d", strtotime(str_replace('/', '-', $_GET['schedule_date'])));
        $booked_from = $schedule_date . ' ' . date("H:i", strtotime($from_time));
        $booked_to = $schedule_date . ' ' . date("H:i", strtotime($to_time));
        $bookingMechanic = $this->bookingMechanic->getBookingMechanicById($booking_id);
        $isReassign = ($bookingMechanic->isEmpty() ? 0 : $bookingMechanic[0]->booking_id) == $booking_id;
        $isReAssign = false;
        if ($bookingMechanic->isEmpty() || (!$bookingMechanic->isEmpty() && $bookingMechanic[0]->mech_response && $bookingMechanic[0]->mech_response == 0 )) {
            $result = $this->bookingMechanic->create(['booking_id' => $booking_id, 'mechanic_id' => $mechanic_id, 'booked_from' => $booked_from, 'booked_to' => $booked_to]);

            $bookingMechanic = $this->bookingMechanic->getBookingMechanicById($booking_id);

            Event::fire(new MechanicAssignEmail(['bookingMechanic' => $bookingMechanic[0], 'old_mechanic' => 0]));
            Event::fire(new AssignMechanic($bookingMechanic[0]->booking));
        } else {
            $isReAssign = true;
            $old_mechanic = $bookingMechanic[0];

            $result = $this->bookingMechanic->update(['mechanic_id' => $mechanic_id, 'booked_from' => $booked_from, 'booked_to' => $booked_to], $old_mechanic->id);

            $bookingMechanic = $this->bookingMechanic->getBookingMechanicById($booking_id);

            Event::fire(new MechanicReAssignEmail(['bookingMechanic' => $bookingMechanic[0], 'old_mechanic' => $old_mechanic]));
            Event::fire(new AssignMechanic($bookingMechanic[0]->booking));
        }

        if ($result) {
            $rslt = $this->bookingService->update(['schedule_date' => date('Y-m-d H:i:s', strtotime($schedule_date)), 'schedule_start_time' => $from_time, 'schedule_end_time' => $to_time], $booking_id);
            if ($rslt)
                $this->bookingService->changeBookingStatus($booking_id, ['status' => BookingStatus::SCHEDULED]);
            return response()->json(['status' => 'success', 'message' => ($isReAssign ? 'Mechanic Assigned' : 'Mechanic Changed')]);
        }
        return response()->json(['status' => 'Failed', 'message' => 'Some error occured please call admin']);
    }

    // Request A Quote on Behalf of a User
    public function requestAQuote() {
        Cookie::queue(Cookie::forget('services_cookie'));
        Cookie::queue(Cookie::forget('service_ids'));
        Cookie::queue(Cookie::forget('services_cookie_client'));
        $data = [];
        $data['locations'] = $this->zipcode->findAll(1);
        $data['service_types'] = $this->servicetype->findAll(1);
        $data['page'] = 'bookings';
        return view('admin.booking.request-a-quote', $data);
    }

    // Search User Name
    public function searchUser() {
        $input = Input::get('keyword');
        if ($input) {
            return $this->userService->searchUser($input);
        }
        return false;
    }

    public function getUserCars($user_id = '') {
        $user = $this->user->find($user_id);
        $user_cars = $user->getActiveCars;
        if (isset($user_cars) && $user_cars && !$user_cars->isEmpty()) {
            $data['type'] = 'user_cars';
            $data['user_cars'] = $user_cars;
            return view('admin.booking.user-ajax-list', $data);
        }
        return false;
    }

    public function getCategories($service_type_id = '') {
        if ($service_type_id == 'popular') {
            $data['services'] = $this->services->getPopularServices();
            $data['type'] = 'services';
            return view('admin.booking.user-ajax-list', $data);
        } elseif ($service_type_id == 'custom') {
            $data['type'] = 'custom';
            return view('admin.booking.user-ajax-list', $data);
        } elseif ($service_type_id == 'search') {
            $data['type'] = 'search';
            return view('admin.booking.user-ajax-list', $data);
        } else {
            $categories = $this->category->getCategoryByServiceType($service_type_id);
            if (isset($categories) && $categories && !$categories->isEmpty()) {
                $data['type'] = 'category';
                $data['categories'] = $categories;
                return view('admin.booking.user-ajax-list', $data);
            }
        }
        return false;
    }

    public function getServices($category_id) {
        $services = $this->services->getServicesByCategory($category_id);
        if (isset($services) && $services && !$services->isEmpty()) {
            $data['type'] = 'services';
            $data['services'] = $services;
            return view('admin.booking.user-ajax-list', $data);
        }
        return false;
    }

    public function getSubServices($service_id) {
        $selected_services_array = [];
        $selected_service_ids = Cookie::get('service_ids');
        if (isset($selected_service_ids) && $selected_service_ids) {
            $selected_services_array = json_decode($selected_service_ids, true);
        }

        $sub_services = $this->subservices->getSubServicesByService($service_id);
        if (isset($sub_services) && $sub_services && !$sub_services->isEmpty()) {
            $result_array = [];
            foreach ($sub_services as $key => $sub_service) {
                $temp_array = [
                    'id' => $sub_service->id,
                    'title' => $sub_service->title,
                    'description' => $sub_service->description,
                    'selection_type' => $sub_service->selection_type,
                    'display_text' => $sub_service->display_text,
                    'optional' => $sub_service->optional
                ];
                $sub_service_options = $this->subservicesopt->getSubServicesOptuionsBySService($sub_service->id);
                if (isset($sub_service_options) && $sub_service_options && !$sub_service_options->isEmpty()) {
                    $temp_array['sub_service_options'] = $sub_service_options;
                }
                $result_array[] = $temp_array;
            }
            $service = $this->services->find($service_id);
            if (isset($service) && $service && !$service->isEmpty()) {
                $data['service_description'] = $service[0]->description;
                $data['service_title'] = $service[0]->title;
            }
            $data['type'] = 'sub_services';
            $data['service_id'] = $service_id;
            $data['sub_services'] = $result_array;
            $data['selected_services_array'] = $selected_services_array;
            return view('admin.booking.user-ajax-list', $data);
        } else {
            $service = $this->services->find($service_id);
            if (isset($service) && $service && !$service->isEmpty()) {
                $data['service_description'] = $service[0]->description;
                $data['service_title'] = $service[0]->title;
            }
            $data['type'] = 'sub_services';
            $data['service_id'] = $service_id;
            $data['selected_services_array'] = $selected_services_array;
            return view('admin.booking.user-ajax-list', $data);
        }
        return false;
    }

    public function addServices(Request $request) {
        $temp_array_view = [];
        $service_array_client = [];
        if (isset($request['service_id']) && $request['service_id']) {
            $service_id = $request['service_id'];
            $service_ids_cookie = Cookie::get('service_ids');
            if (isset($service_ids_cookie) && $service_ids_cookie) {
                $cookie_array = [];
                $cookie_array = json_decode($service_ids_cookie, true);
                $cookie_array[] = $service_id;
                $temp_array_view = $cookie_array;
                $cookie_array = array_filter($cookie_array);
                Cookie::queue('service_ids', json_encode($cookie_array), 600);
            } else {
                $cookie_array = [];
                $cookie_array[] = $service_id;
                Cookie::queue('service_ids', json_encode($cookie_array), 600);
            }
        }

        if (isset($request['service_json_server']) && $request['service_json_server']) {
            $service_json_server = json_decode($request['service_json_server']);
            if ($service_json_server && sizeof($service_json_server)) {
                $services_cookie = Cookie::get('services_cookie');
                if (isset($services_cookie) && $services_cookie) {
                    $cookie_array = [];
                    $temp_array = [];
                    $temp_array = json_decode($services_cookie, true);
                    $cookie_array = array_merge($temp_array, json_decode($request['service_json_server'], true));
                    $cookie_array = array_filter($cookie_array);
                    Cookie::queue('services_cookie', json_encode($cookie_array), 600);
                } else {
                    $cookie_array = [];
                    $cookie_array = $service_json_server;
                    Cookie::queue('services_cookie', json_encode($cookie_array), 600);
                }
            }
        }

        if (isset($request['service_json_client']) && $request['service_json_client']) {
            $service_array_client = json_decode($request['service_json_client']);
            if ($service_array_client && sizeof($service_array_client)) {
                $services_cookie_client = Cookie::get('services_cookie_client');
                if (isset($services_cookie_client) && $services_cookie_client) {
                    $cookie_array = [];
                    $temp_array = [];
                    $temp_array = json_decode($services_cookie_client, true);
                    $cookie_array = array_merge($temp_array, json_decode($request['service_json_client'], true));
                    Cookie::queue('services_cookie_client', json_encode($cookie_array), 600);
                } else {
                    $cookie_array = [];
                    $cookie_array = json_decode($request['service_json_client'], true);
                    Cookie::queue('services_cookie_client', json_encode($cookie_array), 600);
                }
            }
        }

        if (isset($request['custom_service_description']) && $request['custom_service_description']) {
            $custom_service_description = $request['custom_service_description'];
            $custom_service_description = str_replace('\n', '&#92;&#110;', $custom_service_description);
            $custom_service_description = nl2br($custom_service_description);
            $data['custom_service_description'] = $custom_service_description;
            Cookie::queue('custom_service_description_cookie', json_encode($custom_service_description), 600);
        }

        $service_array_client = array_filter($service_array_client);
        if ($service_array_client) {
            $data['service_array_client'] = $service_array_client;
            $data['type'] = 'add_services';
            return view('admin.booking.user-ajax-list', $data);
        }
        return false;
    }

    public function deleteService($service_id) {
        $temp_array = [];
        if ($service_id == 'custom') {
            Cookie::queue(Cookie::forget('custom_service_description_cookie'));

            $services_cookie_client = Cookie::get('services_cookie_client');
            if (isset($services_cookie_client) && $services_cookie_client) {
                $temp_array = json_decode($services_cookie_client);
            }
            $temp_array = array_filter($temp_array);
            if (!$temp_array && sizeof($temp_array) == 0) {
                Cookie::queue(Cookie::forget('services_cookie_client'));
            } else {
                Cookie::queue('services_cookie_client', json_encode($temp_array), 600);
            }
        } else {
            $service_ids_cookie = Cookie::get('service_ids');
            if (isset($service_ids_cookie) && $service_ids_cookie) {
                $temp_array_1 = [];
                $temp_array_1 = json_decode($service_ids_cookie, true);
                if (in_array($service_id, $temp_array_1)) {
                    $key = array_search($service_id, $temp_array_1);
                    unset($temp_array_1[$key]);
                }
                if (!$service_ids_cookie && sizeof($temp_array_1) == 0) {
                    Cookie::queue(Cookie::forget('service_ids'));
                } else {
                    Cookie::queue('service_ids', json_encode($temp_array_1), 600);
                }
            }

            $services_cookie_client = Cookie::get('services_cookie_client');
            $services_cookie = Cookie::get('services_cookie');
            if (isset($services_cookie) && $services_cookie) {
                $temp_array_2 = [];
                $temp_array_2 = json_decode($services_cookie);
                $temp_array = json_decode($services_cookie_client);
                foreach ($temp_array_2 as $key => $element) {
                    if ($element->id == $service_id) {
                        unset($temp_array_2[$key]);
                        unset($temp_array[$key]);
                    }
                }
                if (!$temp_array_2 && sizeof($temp_array_2) == 0) {
                    Cookie::queue(Cookie::forget('services_cookie'));
                } else {
                    Cookie::queue('services_cookie', json_encode($temp_array_2), 600);
                }
                if (!$temp_array && sizeof($temp_array) == 0) {
                    Cookie::queue(Cookie::forget('services_cookie_client'));
                } else {
                    Cookie::queue('services_cookie_client', json_encode($temp_array), 600);
                }
            }
        }

        $data['service_array_client'] = $temp_array;
        $data['type'] = 'add_services';
        return view('admin.booking.user-ajax-list', $data);
    }

    public function submitQuote(Request $request) {
        $service_counter = 0;
        $booking_data = [];
        $custom_service_description = '';
        $user_id = $request->user_id;
        $services_cookie = Cookie::get('services_cookie');
        if ($services_cookie) {
            $service_counter++;
            $temp_services_array = json_decode($services_cookie, true);
            if ($temp_services_array && sizeof($temp_services_array)) {
                $temp_services_array = array_filter($temp_services_array);
                $temp_s_array = [];
                foreach ($temp_services_array as $key => $service) {
                    $temp_ss_array = [];
                    if ($service && sizeof($service)) {
                        $temp_array1 = [];
                        $temp_array1['service_id'] = $service['id'];
                        if (isset($service['sub_services']) && $service['sub_services']) {
                            $temp_array2 = [];
                            foreach ($service['sub_services'] as $key => $sub_service) {
                                if (isset($sub_service[0]['sub_service_options']) && $sub_service[0]['sub_service_options']) {
                                    $temp_array3 = [];
                                    foreach ($sub_service[0]['sub_service_options'] as $key => $sub_service_option) {
                                        $temp_array = [];
                                        $temp_array['sub_service_option_id'] = $sub_service_option[0]['id']; // O1 
                                        $temp_array3[] = $temp_array;
                                    }
                                    $temp_array2['sub_option'] = $temp_array3;
                                    $temp_array2['sub_service_id'] = $sub_service[0]['id'];
                                }
                                $temp_ss_array[] = $temp_array2;
                            }
                            $temp_array1['service_sub'] = $temp_ss_array;
                        }
                        $temp_s_array[] = $temp_array1;
                    }
                }
                $booking_data['service'] = $temp_s_array;
            }
        }
        $custom_service_description_cookie = Cookie::get('custom_service_description_cookie');
        if (isset($custom_service_description_cookie) && $custom_service_description_cookie) {
            $service_counter++;
            $custom_service_description = $custom_service_description_cookie;
        }

        if ($request->action_type && $request->action_type == 'add') {
            $default_location = $request->default_location;
            $user_cars = $request->user_cars;

            if ($service_counter == 0) {
                return redirect('/admin/bookings/request-a-quote')->with(['error_type' => 'error_message', 'message' => 'Please select at least one service.']);
            } else {
                // Prepare Booking Data
                $booking_data['user_id'] = $user_id;
                $booking_data['cartrim_id'] = $user_cars;
                $booking_data['zipcode_id'] = $default_location;

                /*
                  echo $custom_service_description . "<br/>";
                  $custom_service_description = str_replace('\n', '&#92;&#110;', $custom_service_description);
                  echo $custom_service_description . "<br/>";
                  $booking_data['own_service_description'] = nl2br($custom_service_description);
                 */

                $custom_service_description = str_replace('\n', '', $custom_service_description);
                $booking_data['own_service_description'] = $custom_service_description;

                $booking_data = array_map("unserialize", array_unique(array_map("serialize", $booking_data)));

                // Create a Booking
                $response_booking = $this->bookingService->bookingFromAdmin($booking_data);
                if ($response_booking) {
                    //Log::useDailyFiles(storage_path() . '/logs/debug.log');
                    //Log::info(["Booking Added {Booking: " . $response_booking . " User ID: " . $response_user->id . "}"]);
                    Cookie::queue(Cookie::forget('service_ids'));
                    Cookie::queue(Cookie::forget('services_cookie'));
                    Cookie::queue(Cookie::forget('services_cookie_client'));
                    Cookie::queue(Cookie::forget('custom_service_description_cookie'));
                    return redirect('/admin/bookings')->with(['error_type' => 'success', 'error_message' => 'Thanks for requesting a quote, we will get back to you with a quote shortly.']);
                } else {
                    return redirect('/admin/bookings/request-a-quote')->with(['error_type' => 'danger', 'error_message' => 'Your request a quote failed! Please try again later.']);
                }
            }
        } elseif ($request->action_type && $request->action_type == 'update') {
            $booking_id = $request->booking_id;
            if ($booking_id) {
                // Prepare Booking Data
                $booking_data['user_id'] = $user_id;
                $booking_data['booking_id'] = $booking_id;

                // Delete All Booking Items on the Basis of Booking ID
                $services = $this->bookingItemsService->deleteBookingItems($booking_id);

                $custom_service_description = str_replace('\n', '', $custom_service_description);
                $booking_data['own_service_description'] = $custom_service_description;

                $booking_data = array_map("unserialize", array_unique(array_map("serialize", $booking_data)));

                // Create a Booking
                $response_booking = $this->bookingService->bookingFromAdminUpdate($booking_data);
                if ($response_booking) {
                    //Log::useDailyFiles(storage_path() . '/logs/debug.log');
                    //Log::info(["Booking Added {Booking: " . $response_booking . " User ID: " . $response_user->id . "}"]);
                    Cookie::queue(Cookie::forget('service_ids'));
                    Cookie::queue(Cookie::forget('services_cookie'));
                    Cookie::queue(Cookie::forget('services_cookie_client'));
                    Cookie::queue(Cookie::forget('custom_service_description_cookie'));
                    return redirect('/admin/bookings')->with(['error_type' => 'success', 'error_message' => "User's quote updated successfully!"]);
                } else {
                    return redirect('/admin/bookings/request-a-quote')->with(['error_type' => 'danger', 'error_message' => 'Your request a quote failed! Please try again later.']);
                }
            }
        }
    }

    public function searchServices(Request $request) {
        $search_service = $request->search_service;
        if ($search_service) {
            $services = $this->services->searchAllServices($search_service);
            if (isset($services) && $services && !$services->isEmpty()) {
                $data['type'] = 'services';
                $data['services'] = $services;
                return view('admin.booking.user-ajax-list', $data);
            }
        }
    }

    public function updateBookingServices($booking_id) {
        Cookie::queue(Cookie::forget('service_ids'));
        Cookie::queue(Cookie::forget('services_cookie'));
        Cookie::queue(Cookie::forget('services_cookie_client'));
        Cookie::queue(Cookie::forget('custom_service_description_cookie'));
        $booking = $this->bookingService->find($booking_id);
        $service_id_array = [];
        $service_json_server = [];
        $service_json_client = [];
        if ($booking) {
            if (isset($booking->bookingItems) && $booking->bookingItems && !$booking->bookingItems->isEmpty()) {
                foreach ($booking->bookingItems as $bookingItem) {
                    $temp_array1_service = [];
                    $temp_array2_service = [];
                    $service_id = $bookingItem->service_id;
                    $service_title = $bookingItem->getService->title;
                    $service_id_array[] = $service_id;

                    $array1_sservice = [];
                    $array2_sservice = [];

                    if (isset($bookingItem->bookingServiceSub) && $bookingItem->bookingServiceSub && !$bookingItem->bookingServiceSub->isEmpty()) {
                        foreach ($bookingItem->bookingServiceSub as $subSurvice) {
                            $temp_array1_sservice = [];
                            $temp_array2_sservice = [];

                            $array1_sservice_option = [];
                            $array2_sservice_option = [];
                            $sub_service_id = $subSurvice->sub_service_id;
                            $display_text = $subSurvice->getServiceSub->display_text;
                            if (isset($subSurvice->bookingSubOption) && $subSurvice->bookingSubOption && !$subSurvice->bookingSubOption->isEmpty()) {
                                foreach ($subSurvice->bookingSubOption as $option) {
                                    $temp_array1_sservice_option = [];
                                    $temp_array2_sservice_option = [];

                                    $sub_service_option_id = $option->sub_service_option_id;
                                    $sub_service_option_name = $option->getSubOption->option_name;

                                    $temp_array1_sservice_option[] = ['id' => $sub_service_option_id];
                                    $temp_array2_sservice_option[] = ['id' => $sub_service_option_id, 'option_name' => $sub_service_option_name];

                                    if ($temp_array1_sservice_option) {
                                        $array1_sservice_option[] = $temp_array1_sservice_option;
                                    }
                                    if ($temp_array2_sservice_option) {
                                        $array2_sservice_option[] = $temp_array2_sservice_option;
                                    }
                                }
                            }
                            if ($array1_sservice_option) {
                                $temp_array1_sservice[] = ['id' => $sub_service_id, 'sub_service_options' => $array1_sservice_option];
                            } else {
                                $temp_array1_sservice[] = ['id' => $sub_service_id];
                            }
                            $array1_sservice[] = $temp_array1_sservice;

                            if ($array2_sservice_option) {
                                $temp_array2_sservice[] = ['id' => $sub_service_id, 'display_text' => $display_text, 'sub_service_options' => $array2_sservice_option];
                            } else {
                                $temp_array2_sservice[] = ['id' => $sub_service_id, 'display_text' => $display_text];
                            }
                            $array2_sservice[] = $temp_array2_sservice;
                        }
                    }
                    if ($array1_sservice) {
                        $temp_array1_service = ['id' => $service_id, 'sub_services' => $array1_sservice];
                    } else {
                        $temp_array1_service = ['id' => $service_id];
                    }
                    if ($array2_sservice) {
                        $temp_array2_service = ['id' => $service_id, 'service_title' => $service_title, 'sub_services' => $array2_sservice];
                    } else {
                        $temp_array2_service = ['id' => $service_id, 'service_title' => $service_title];
                    }

                    $service_json_server[] = $temp_array1_service;
                    $service_json_client[] = $temp_array2_service;
                }
            }
            // Store Service ID's into Cookie
            if ($service_id_array && sizeof($service_id_array)) {
                $cookie_array = [];
                $cookie_array = array_filter($service_id_array);
                Cookie::queue('service_ids', json_encode($cookie_array), 600);
            }
            // Store Custom Service Description into Cookie
            if (isset($booking->own_service_description) && $booking->own_service_description) {
                $custom_service_description = $booking->own_service_description;
                $custom_service_description = str_replace('\n', '&#92;&#110;', $custom_service_description);
                $custom_service_description = nl2br($custom_service_description);
                Cookie::queue('custom_service_description_cookie', json_encode($custom_service_description), 600);
            }
            if ($service_json_server && sizeof($service_json_server)) {
                $cookie_array = array_filter($service_json_server);
                Cookie::queue('services_cookie', json_encode($cookie_array), 600);
            }
            if ($service_json_client && sizeof($service_json_client)) {
                $cookie_array = array_filter($service_json_client);
                Cookie::queue('services_cookie_client', json_encode($cookie_array), 600);
            }
        }
        $data['service_types'] = $this->servicetype->findAll(1);
        $data['booking'] = $booking;
        $data['booking_id'] = $booking_id;
        $data['page'] = 'bookings';
        $data['page_type'] = 'update-services';
        return view('admin.booking.request-a-quote', $data);
    }

}
