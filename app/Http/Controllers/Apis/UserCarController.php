<?php

namespace App\Http\Controllers\Apis;

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
use App\Utility\BookingStatus;

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
        $authId = Auth::user()->id;
        $user = $this->user->find($authId);
        $userCars = $user->getCars;
        $i =0;
        if(count($userCars) > 0){
            foreach ($userCars as $userCar){
                $result[$i]['car_brand'] = $userCar->usercars->carmodel->years->cars->brand;
                $result[$i]['car_image_url'] = $userCar->usercars->carmodel->years->cars->image_url;
                $result[$i]['year'] = $userCar->usercars->carmodel->years->year;
                $result[$i]['carmodel_name'] = $userCar->usercars->carmodel->modal_name;
                $result[$i]['cartrim_name'] = $userCar->usercars->car_trim_name;
                $result[$i]['cartrim_id'] = $userCar->id;
                $i++;
            }
            return response()->json(['status' => 'success','result' => $result]);
        }
            return response()->json(['status' => 'error','result' => []]);
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
            ];
            $result = $this->usercar->create($data);
            if ($result) {
                return response()->json(['status' => 'success', 'message' => 'Car has been added successfully!'], 200);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Car has not been added!'], 400);
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
                               ->where('status','!=',BookingStatus::COMPLETED); 
            
            if($booking->isEmpty()){
                try {
                    $result = $this->usercar->softDelete($id);
                } catch (Exception $ex) {
                    return response()->json(['status' => 'error', 'message' => 'User car is not deleted'], 400);
                }
            }
        }else{
            return response()->json(['status' => 'error', 'message' => 'We did not found your car'], 404);
        }
        
        if (isset($result) && $result) {
            return response()->json(['status' => 'success', 'message' => 'User car is deleted Successfully'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => "You can't delete this car now because it's scheduled for a service"], 400);
        }
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
    public function getUserCarHealthReport(Request $request) {
        $carHealth = $this->usercar->getUserCarById($request->cartrim_id)->first();  
        if(!is_null($carHealth)){
            $jsonArr = $carHealth->car_health;
            if(!is_null($jsonArr)){
                $result = json_decode($jsonArr, true);
                return response()->json(['status' => 'success' ,'result' =>  $result   ]);
            }
        }
        return response()->json(['status' => 'success' ,'result' =>  []]);
    }

    /** 
     *  This function will update user car health on the basis of user car id. 
     *  This will accept two mandatory parameter -- input data ($request) and id (user car id). 
     */
    public function updateCarHealth(Request $request, $id) {
        $data_array = $request->all();
        unset( $data_array["_token"] );
        $data = json_encode($data_array);
        $array = ['car_health' => $data];
        $result = $this->usercar->update($array, $id);
        if ($result) {
            return response()->json(['status' => 'success', 'message' => 'Car health has been updated successfully'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Car health updation failed'], 200);
        }
    }

}
