<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\YearService as YearService;
use App\Services\CarService as CarService;
use App\Services\ModelService as ModelService;
use App\Services\UserCarService as UserCarService;
use App\Services\CarTrimService as CarTrimService;
use App\Services\UserService as userService;
use App\Http\Requests\UserCarTrimRequest;
use Illuminate\Http\Request;
use Request as RequestFacade;
use Auth;
use Cookie;
use App\Utility\BookingStatus;
use App\Models\UserCarDetails;
use App\Models\AppSettings;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AdminController
 *
 * @author Mahesh
 */
class UserCarController extends Controller {

    protected $year;
    protected $cars;
    protected $carmodel;
    protected $usercar;
    protected $cartrim;
    protected $user;

    public function __construct(YearService $year, CarService $cars, ModelService $carmodel, UserCarService $usercar, CarTrimService $cartrim, userService $user) {
        $this->year = $year;
        $this->cars = $cars;
        $this->carmodel = $carmodel;
        $this->usercar = $usercar;
        $this->cartrim = $cartrim;
        $this->user = $user;
    }

    public function index() {
        $result['page'] = 'user-car';
        $result['cars'] = $this->cars->findAll(1);
        $authId = Auth::user()->id;
        $user = $this->user->find($authId);
        $userCars = $user->getActiveCars;
        $result['usercars'] = $userCars;
        if (RequestFacade::ajax()) {
            return view('web/user/car/user_car_list', $result);
        }
        return view('web/user/car/user_car', $result);
    }

    public function create() {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(UserCarTrimRequest $request) {
        $user_id = Auth::user()->id;
        $check_user_car = $this->usercar->getUserCarById($request->car_trim_id);

        if ($check_user_car->isEmpty()) {
            $data = [
                'car_trim_id' => $request->car_trim_id,
                'user_id' => $user_id,
                'car_health' => '',
                'remember_token' => $request->_token,
            ];
            $result = $this->usercar->create($data);
            if ($result) {
                return response()->json(['status' => 'success', 'message' => 'Car has been added successfully!'], 200);
            } else {
                return response()->json(['status' => 'failed', 'message' => 'Car has not been added!'], 400);
            }
        } else {
            if(isset($check_user_car[0])){
                $car = $check_user_car[0];
                if($car->status){
                    return response()->json(['status' => 'failed', 'message' => 'This car is already added by you!'], 400);
                }else{
                    $car->status = 1;
                    $car->save();
                    return response()->json(['status' => 'success', 'message' => 'Car has been added successfully!'], 200);
                }
            }else{
                return response()->json(['status' => 'failed', 'message' => 'Car has not been added!'], 400);
            }
        }
    }

    public function getCarDetails($id) {
        $data = [];
        $check_user_car = $this->usercar->find($id);
        $data['check_user_car'] = $check_user_car;
        $jsonArray = AppSettings::select('value')
                                ->whereName('car_attributes_collection')
                                ->first();
        $blank_decoded_car_details = json_decode($jsonArray->value,true);
        if(is_null($check_user_car->car_attributes_details)){
            $data['decoded_car_details'] = $blank_decoded_car_details;
        }else{
            $fetched_decoded_car_details = json_decode($check_user_car->car_attributes_details,true);
            if(count($blank_decoded_car_details) > count($fetched_decoded_car_details)){
                $diff_keys = array_diff_key($blank_decoded_car_details, $fetched_decoded_car_details);
                if(count($diff_keys)){
                    foreach ($diff_keys as $key => $value) {
                        $fetched_decoded_car_details[$key] = $value;
                    }
                }
            }
            $data['decoded_car_details'] = $fetched_decoded_car_details;
        }
        return view('web/user/car/user_car_extra_details',$data);
    }
    
    public function updateCarDetails(Request $request) {
        $this->validate($request,[
            "vin" => 'required',
            "license_number" => "required"
        ]);
        try {
            $check_user_car = $this->usercar->find($request->id);
            $check_user_car->car_attributes_details = json_encode($request->except('id','_token'));
            $check_user_car->remember_token = $request->_token;
            $check_user_car->save();
        } catch (\Exception $ex) {
            return response()->json(['status' => 'failed', 'message' => 'Something went worong!'], 400);
        }
        return response()->json(['status' => 'success', 'message' => 'Car Details has been added successfully!'], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        
    }

    /**
     * This function will delete user car on the basis of id (user car id) and 
     * return json response.
     * 
     */
    public function destroy($id) {
        $carId = $this->usercar->find($id);
        if(!is_null($carId)){
            $booking = Auth::user()->getBooking
                               ->where('cartrim_id',$carId->car_trim_id)
                               ->whereNotIn('status',[BookingStatus::COMPLETED,BookingStatus::CANCELLED,BookingStatus::DELETED]); 
            if($booking->isEmpty()){
                try {
                    $result = $this->usercar->softDelete($id);
                } catch (Exception $ex) {
                    return response()->json(['status' => 'failed', 'message' => 'User car is not deleted'], 400);
                }
            }
        }else{
            return response()->json(['status' => 'failed', 'message' => 'We did not found your car'], 404);
        }
        
        if (isset($result) && $result) {
            return response()->json(['status' => 'success', 'message' => 'User car is deleted Successfully'], 200);
        } else {
            return response()->json(['status' => 'failed', 'message' => "You can't delete this car now because it's scheduled for a service"], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(updateCarRequest $request, $id) {
        
    }

    /**
     * 
     * This function will get car year on the basis of car id and return json response.
     * This will accept one mandatory parameter -- car id.
     * 
     */
    public function getCarYear($id) {
        $cars = $this->cars->find($id);

        $result = $cars[0]->years;

        if (count($result) > 0 && $result != []) {
            return response()->json(['status' => 'success', 'result' => $result], 200);
        } else {
            return response()->json(['status' => 'error', 'result' => $result], 404);
        }
    }

    /**
     * 
     * This function will get car modal on the basis of year id and return json response.
     * This will accept one mandatory parameter -- year id.
     * 
     */
    public function getCarModel($id) {
        $year = $this->year->findById($id);
        $result = $year[0]->model;
        if (count($result) > 0 && $result != []) {
            return response()->json(['status' => 'success', 'result' => $result], 200);
        } else {
            return response()->json(['status' => 'error', 'result' => $result], 404);
        }
    }

    /**
     * This function will get car trim on the basis of id (Car modal id) and return json response.
     * This will accept one mandatory parameter -- id.
     */
    public function getCarTrim($id) {
        $carmodal = $this->carmodel->find($id);
        $result = $carmodal[0]->carTrim;
        if (count($result) > 0 && $result != []) {
            return response()->json(['status' => 'success', 'result' => $result], 200);
        } else {
            return response()->json(['status' => 'error', 'result' => $result], 404);
        }
    }

    /*
     * This function will get user car services on the basis of id (car trim id).
     * This will accept one mandatory parameter -- id.
     */

    public function getUserCarServices($id) {
        $result['booking'] = $this->usercar->getUserCarServices($id);
        return view('web.user.car.user_car_service', $result);
    }

    /**
     * This function will fetch user car health on the basis of user car id ($id). 
     */
    public function getCarHealth($id) {
        $carHealth = $this->usercar->find($id);        
        $jsonArr = json_decode($carHealth->car_health);
        if(!is_null($jsonArr)){
            $result['userCarHealth'] = json_decode(json_encode($jsonArr->car_health_report), true);
            return view('web.user.car.user_car_health', $result);
        }
        return view('web.user.car.user_car_health');
    }

    /**
     *  This function will update user car health on the basis of user car id. 
     *  This will accept two mandatory parameter -- input data ($request) and id (user car id). 
     */
    public function updateCarHealth(Request $request, $id) {
        $data_array = $request->all();
        unset($data_array["_token"]);
        $data = json_encode($data_array);
        $array = ['car_health' => $data];
        $result = $this->usercar->update($array, $id);
        if ($result) {
            return response()->json(['status' => 'success', 'message' => 'Car health has been updated successfully'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Car health updation failed'], 200);
        }
    }

    public function bookService($trim_id = 0) {
        if ($trim_id) {
            $user_id = Auth::user()->id;
            $user = $this->user->find($user_id);
            
            $trim = $this->cartrim->find($trim_id);           
            $model_id = $trim[0]->carmodel->id;
            $year_id = $trim[0]->carmodel->years->id;
            $car_id = $trim[0]->carmodel->years->cars->id;

            $cookie_array['location_id'] = $user->default_location;
            $cookie_array['car_id'] = $car_id;
            $cookie_array['year_id'] = $year_id;
            $cookie_array['model_id'] = $model_id;
            $cookie_array['trim_id'] = $trim_id;
            Cookie::queue('uf_car_info', json_encode($cookie_array), 600);
            return redirect('/request-a-quote');
        }
        return redirect('user/cars');
    }

}
