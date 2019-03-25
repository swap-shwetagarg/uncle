<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserProfileRequest;
use App\Services\UserService as UserService;
use Auth;
use UpcomingBookings;
use App\Services\SmsApiService;
use App\Services\ZipCodeService;
use Session;

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
class UserController extends Controller {

    protected $user;
    protected $smsapi;
    protected $zipcode;

    public function __construct(UserService $user, SmsApiService $smsapi,ZipCodeService $zipcode) {
        $this->user = $user;
        $this->smsapi = $smsapi;
        $this->zipcode = $zipcode;
    }

    public function index() {
        $data['page'] = 'dashboard';
        if(UpcomingBookings::getAuthNextBooking()){
            $data['upbookings'] = UpcomingBookings::getAuthNextBooking();
        }
        return view('web.user.dashboard', $data);
    }

    public function update(UserProfileRequest $request, $id) {
        try {
            $result = $this->user->update($request->all(), $id);
        } catch (\Exception $ex) {
            $result = false;
        }
        if ($result === true) {
            return response()->json(['status' => 'success', 'message' => 'User is updated Successfully'], 200);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'User is not updated'], 404);
        }
    }

    public function show(Request $request, $id) {
        $user = Auth::user();
        $address = $user->address;
        $locations = $this->zipcode->findAll(1);
        if ($request->address) {
            return view('web.user.user_address', [
                'user' => $user, 
                'address' => $address,
                'locations' => $locations
            ]);
        }
        return view('web.user.user_profile', [
            'user' => $user, 
            'address' => $address,
            'locations' => $locations
        ]);
    }

    public function generatelinkToVerifyAccount() {
        $result = $this->user->generatelinkToVerifyAccount();
        if ($result === true) {
            return back()->with(['alert_msg' => 'We have sent a mail to verify your Account']);
        }
    }

    public function mechanicProfile($id) {
        $result = $this->user->find($id);
        return view('web.user.user_detail', ['user' => $result]);
    }

    // Re-send Verification Code to the User's Mobile Number
    public function reSendVerificationCode() {
        $user = Auth::user();
        if (isset($user) && $user) {
            $this->smsapi->sendVerificationCode($user);
            return response()->json(['status' => 'success', 'message' => 'Please enter the verification code we sent to your mobile number or click the link we sent to your email address to verify your account.'], 200);
        }
    }

    // Verify Account By Verification Code
    public function verifyAccount(Request $request) {
        $user = Auth::user();
        $data_array = $request->all();
        $response = $this->user->verifyUserAccount($data_array);
        if (isset($data_array['ajax_request']) && $data_array['ajax_request']) {
            if ($response) {
                return response()->json(['status' => 'success'], 200);
            } else {
                return response()->json(['status' => 'error', 'message' => 'You have entered wrong verification code. Please re-enter and verify'], 200);
            }
        } else {
            if ($response) {
                return redirect('/user/dashboard');
            } else {
                return redirect('/welcome')->with(["name" => $user->name, "post" => "User", "message" => "You have entered wrong verification code. Please re-enter and verify"]);
            }
        }
    }
    
    public function updateLocation(Request $request) {
        $user = $this->user->find(Auth::id());
        $user->default_location = $request->location;
        $user->save();
        return response()->json(['status' => 'success' ,'message' => 'Location Successfully updated']);
    }

    public function user_switch_stop() {
        try {
            $id = Session::pull( 'orig_user' );
            $orig_user_object = $this->user->find($id);
            Auth::login( $orig_user_object );
            return redirect()->intended('/admin/dashboard');
        } catch(\Exception $ex){
            return redirect()->intended('/');
        }
    }

}
