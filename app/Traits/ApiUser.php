<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Traits;

use Illuminate\Http\Request;
use Validator;
use Auth;
use App\User;
use App\Models\OtpAuthentication;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Http\JsonResponse;
use App\Services\OtpAuthenticationService;
use Illuminate\Support\Facades\Log;

/**
 * Description of ApiUser
 *
 * @author vishal
 */
trait ApiUser {

    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
                    'email' => 'required',
                    'password' => 'required',
                        ], [
                    'email.required' => 'We need your E-mail/Mobile to login',
                    'password.required' => 'We need your password to login',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        Log::info(['LoginUsernamePassword' => $request->all()]);

        $result = $this->user->login($request->all());
        $results = json_decode($result);

        if ($result) {
            return response()->json(['status' => 'success', 'message' => 'You are logged in', 'user' => $results]);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Invalid Credentials', 'user' => $results], 403);
        }
    }

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request) {
        $validator = $this->validator($request);

        if ($validator->fails()) {
            $message = $this->createError($validator->errors(), $request);
            return response()->json(['error' => $message], 422);
        }
        if (!isset($request->verification_code) && !$request->verification_code) {
            $status = $this->checkMobileSendOtp($request);
            Log::info(['sendOtpResponse' => $status]);
            if ($status) {
                return response()->json(['status' => 'success', 'message' => 'verification code have been sent to your registered mobile number']);
            } else {
                return response()->json(['status' => 'failed'], 500);
            }
        }
        $otp_authentication = OtpAuthentication::whereMobile($request->mobile)->where('code', $request->verification_code)->get();
        if($otp_authentication->isNotEmpty()){
            $result = $this->user->register($request->all());
        } else {
            $result = false;
        }

        if ($result) {
            return response()->json(['status' => 'success', 'message' => 'You are registered', 'user' => $result]);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'You are not registered', 'result' => []], 403);
        }
    }

    public function logout(Request $request) {
        // Destroy Device Token After Logged out from APP
        if (isset($request->device_token)) {
            $device_token = $request->device_token;
            $this->deviceToken->destroy($device_token);
        }

        try {
            $token = Auth::user()->token();
        } catch (\Exception $ex) {
            return $this->sessionDestroyed();
        }
        if ($this->token->isAccessTokenRevoked($token->id)) {
            return $this->sessionDestroyed();
        }
        $updateResult = $this->token->revokeAccessToken($token->id);
        return ( $updateResult ) ? $this->logoutSuccessResponse() : $this->logoutFailedResponse();
    }

    public function changePassword(ChangePasswordRequest $request) {
        $result = $this->user->changePassword($request->all());
        if ($result) {
            $user = Auth::user();
            $token = $user->createToken('MyApp');
            $user->token = $token->accessToken;
            $user->tokenId = $token->token->id;
            return response()->json(['status' => 'success', 'newToken' => $user]);
        }
        return response()->json(['status' => 'failed', 'message' => trans('customResponse.changePasswordFailed')]);
    }

    public function resetPassword(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required|min:6|dumbpwd|confirmed',
            'password_confirmation' => 'required',
            'verification_code' => 'sometimes|required'
                ], [
            'email.required' => 'E-mail/Mobile address is required',
            'password.required' => 'Please enter password it is required',
            'password.dumbpwd' => 'Please Use strong password at least 6 characters',
            'password_confirmation.required' => 'Please enter confirm password it is required',
            'password_confirmation.same' => 'Passwords do not match',
            'verification_code.required'    => 'Verification code is required'
        ]);
        
        if($validator->fails()){
            $errorList = $validator->errors()->getMessages();
            if (isset($errorList['email'])) {
                $message = ['messages' => $errorList['email'][0]];
                return response()->json(['status' => 'failed','error' => $message], 422);
            }
            if (isset($errorList['password'])) {
                $message = ['messages' => $errorList['password'][0]];
                return response()->json(['status' => 'failed','error' => $message], 422);
            }
            if (isset($errorList['password_confirmation'])) {
                $message = ['messages' => $errorList['password_confirmation'][0]];
                return response()->json(['status' => 'failed','error' => $message], 422);
            }
            if (isset($errorList['verification_code'])) {
                $message = ['messages' => $errorList['verification_code'][0]];
                return response()->json(['status' => 'failed','error' => $message], 422);
            }
        }
        
        $user = User::whereEmail($request->email)
                    ->orWhere('mobile', $request->email)
                    ->first();
        
        if (!is_null($user)) {
            if(!isset($request->verification_code)){
                $status = $this->checkMobileSendOtp($user);
                if ($status) {
                    return response()->json(['status' => 'success', 'message' => 'Verification code have been sent to your registered mobile number']);
                } else {
                    return response()->json(['status' => 'failed' ,'error' => ['messages' => 'Reset password request is failed']],500);
                }
            }
            
            if(isset($request->verification_code) && $request->verification_code){
                $user->verification_code = $request->verification_code;
                $status = $this->checkMobileandVerificationCode($user);
                if($status){
                    $user->password = bcrypt($request->password);
                    $this->user->deleteAllToken($user);

                    if ($user->save()) {
                        return response()->json(['status' => 'success', 'message' => 'Your password is successfully reset .']);
                    }else{
                        return response()->json(['status' => 'failed' ,'error' => ['messages' => 'Reset password request is failed']],500);
                    }
                }else{
                    return response()->json(['status' => 'failed' ,'error' => ['messages' => 'Verification code is wrong']],400);
                }
            }
        }
        return new JsonResponse(['status' => 'failed', 'error' => ['messages' => 'User does not exist in our record']], 422);
    }

    // Register a Device Token
    public function registerDeviceToken(Request $request) {

        $validator = Validator::make($request->all(), [
                    'device_token' => 'required|unique:device_tokens'
                        ], [
                    'device_token.required' => 'Device Token is required',
                    'device_token.unique' => 'Device Token alerady exists'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'success']);
        } else {
            $data_array = $request->all();
            $user_id = Auth::user()->id;
            $data_array['user_id'] = $user_id;
            $response = $this->deviceToken->create($data_array);
            if ($response) {
                return response()->json(['status' => 'success']);
            } else {
                return response()->json(['status' => 'failed'], 403);
            }
        }
    }

    public function validator(Request $request) {
        return Validator::make($request->all(), [
                    'name' => 'required',
                    'email' => 'nullable|email|unique:users',
                    'password' => 'required|dumbpwd',
                    'c_password' => 'required|same:password',
                    'role' => 'nullable|in:Mechanic,User',
                    'mobile' => 'required|unique:users|max:10|min:10',
                    'mobile_country_code' => 'required',
                    'verification_code' => 'sometimes|required',
                    'default_location' => 'sometimes|required'
                        ], [
                    'name.required' => 'We need your name',
                    'email.email' => 'E-mail Address should be vaild E-mail',
                    'email.unique' => 'E-mail Address already registered with us',
                    'password.required' => 'Please enter password it is required',
                    'password.dumbpwd' => 'Please Use strong password at least 6 characters',
                    'c_password.required' => 'Please enter confirm password it is required',
                    'c_password.same' => 'Passwords do not match',
                    'mobile.required' => 'We need your mobile number',
                    'mobile.unique' => 'Mobile number already exists',
                    'mobile.max' => 'Mobile number must be 10 digit',
                    'mobile.min' => 'Mobile number must be 10 digit',
                    'mobile_country_code.required' => 'Country Code is required',
                    'role.in' => 'Role can be User or Mechanic.Please check!',
                    'default_location.required' => 'Please enter your location',
                    'verification_code.required' => 'OTP is required',
        ]);
    }

    public function createError($errors, $request) {
        $errorList = $errors->getMessages();
        if (isset($errorList['name'])) {
            return ['messages' => $errorList['name'][0]];
        }

        if (isset($errorList['email'])) {
            return ['messages' => $errorList['email'][0]];
        }

        if (isset($errorList['mobile_country_code'])) {
            return ['messages' => $errorList['mobile_country_code'][0]];
        }

        if (isset($errorList['mobile'])) {
            return ['messages' => $errorList['mobile'][0]];
        }

        if (isset($errorList['verification_code'])) {
            return ['messages' => $errorList['verification_code'][0]];
        }

        if (isset($errorList['password'])) {
            return ['messages' => $errorList['password'][0]];
        }

        if (isset($errorList['c_password'])) {
            return ['messages' => $errorList['c_password'][0]];
        }

        if (isset($errorList['default_location'])) {
            return ['messages' => $errorList['default_location'][0]];
        }
    }

    public function sendOtp(Request $request) {
        $validator = Validator::make($request->all(), [
                    'mobile' => 'required|max:10|min:10',
                    'mobile_country_code' => 'required',
                        ], [
                    'mobile.required' => 'We need your mobile number',
                    'mobile.unique' => 'Mobile number already exists',
                    'mobile.max' => 'Mobile number must be 10 digit',
                    'mobile.min' => 'Mobile number must be 10 digit',
                    'mobile_country_code.required' => 'Country Code is required',
        ]);

        if ($validator->fails()) {
            $errorList = $validator->errors()->getMessages();
            if (isset($errorList['mobile'])) {
                $message = ['messages' => $errorList['mobile'][0]];
                return response()->json(['error' => $message], 422);
            }
            if (isset($errorList['mobile_country_code'])) {
                $message = ['messages' => $errorList['mobile_country_code'][0]];
                return response()->json(['error' => $message], 422);
            }
        }
        try {
            $response = $this->checkMobileSendOtp($request);
        } catch (\Exception $ex) {
            return response()->json(['status' => 'failed'], 500);
        }
        if ($response) {
            return response()->json(['status' => 'success', 'message' => trans('customResponse.otpSend')]);
        }

        return new JsonResponse(['status' => 'failed', 'error' => $this->notFoundUser()], 404);
    }

    public function checkMobileSendOtp($request) {
        $response = 0;
        $otp_authentication = OtpAuthentication::whereMobile($request->mobile)->first();
        if (collect($otp_authentication)->isNotEmpty()) {
            $verification_code = $this->smsapi->sendOTPCode($request);
            if ($verification_code) {
                $data_array = ['code' => $verification_code];
                $response = $this->otpAuthenticationService->update($data_array, $otp_authentication->id);
            }
        } else {
            $verification_code = $this->smsapi->sendOTPCode($request);
            if ($verification_code) {
                $data_array = ['mobile' => $request->mobile, 'code' => $verification_code];
                $response = $this->otpAuthenticationService->create($data_array);
            }
        }
        return $response;
    }

    public function verifyOtp(Request $request) {
        $this->validate($request, [
            'mobile' => 'required',
            'verification_code' => 'required',
                ], [
            'mobile.required' => 'Mobile number is required',
            'verification_code.required' => 'We need verification code Which have been send to your registered mobile number'
        ]);

        $otp_authentication = $this->checkMobileandVerificationCode($request);
        if ($otp_authentication) {
            return response()->json(['status' => 'success', 'message' => trans('customResponse.otpVerified')]);
        } else {
            return response()->json(['status' => 'failed', 'error' => $this->notFoundOtp()], 404);
        }
    }
    
    public function checkMobileandVerificationCode($request) {
        $otp_authentication = OtpAuthentication::whereMobile($request->mobile)->where('code', $request->verification_code)->first();
        if (collect($otp_authentication)->isNotEmpty()) {
            return true;
        } else {
            return false;
        }
    }

}
