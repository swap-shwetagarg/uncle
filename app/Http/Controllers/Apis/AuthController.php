<?php

namespace App\Http\Controllers\Apis;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Auth;
use Socialite;
use App\User;
use SocialiteCheck;
use Session;
use Validator;
use App\Services\SmsApiService;
use App\Models\Providers;
use App\Services\UserService;
use App\Traits\UserReponse;
use App\Traits\ApiUser;
use App\Services\OtpAuthenticationService;
use App\Models\OtpAuthentication;
use App\Models\Referral;
use App\Services\AppSettingsService;

class AuthController extends Controller {

    use UserReponse,
        ApiUser;

    protected $smsapi;
    protected $userService;
    protected $otpAuthenticationService;
    protected $provider;
    protected $email;
    protected $name;
    protected $providerId;
    protected $userId;
    protected $verification_code;
    protected $default_location = 1;
    protected $verified = 1;
    protected $checked = true;
    protected $should_next = true;
    protected $is_user_exist = true;
    protected $is_wrong_otp = false;
    public $appSettingsService = '';

    public function __construct(AppSettingsService $appSettingsService,SmsApiService $smsapi, UserService $userService, OtpAuthenticationService $otpAuthenticationService) {
        $this->smsapi = $smsapi;
        $this->userService = $userService;
        $this->otpAuthenticationService = $otpAuthenticationService;
        $this->appSettingsService = $appSettingsService;
    }

    public function redirectToProvider($provider,Request $request) {
        try {
            if (isset($_SERVER["QUERY_STRING"]) && $_SERVER["QUERY_STRING"]) {
                Session::put('isBooking', true);
            }
            if(isset($request->referral_id)){
                Session::put('user_referral_id', $request->referral_id);
            }
            return Socialite::driver($provider)->stateless()->redirect();
        } catch (\Exception $e) {
            return redirect('login');
        }
    }

    /**
     * Obtain the user information from provider.  Check if the user already exists in our
     * database by looking up their provider_id in the database.
     * If the user exists, log them in. Otherwise, create a new user then log them in. After that 
     * redirect them to the authenticated users homepage.
     *
     * @return Response
     */
    public function handleProviderCallback(Request $request, $provider) {
        if(\Session::has('uf_user_social_verification')){
                $user = (object) $request->all();
                $this->validate($request, [
                    'email' => 'required|email',
                    'mobile' => 'required',
                    'verification_code' => 'required',
                    'default_location'  => 'required'
                ],[
                    'email.required' => 'Email is required',
                    'email.email'   => 'Email address must be valid',
                    'default_location.required' => 'Location is required',
                    'verification_code.required' => 'Verification code is required',
                    'mobile.required' => 'Mobile number is required'
                ]);
        }else{
            try {
                $user = Socialite::driver($provider)->stateless()->user();
                $user->provider = $provider;
            } catch (\Exception $e) {
                return redirect('login');
            }
        }
        $this->setSocialUser($user);
        $result = $this->checkProviderToken();

        /*
        if (!$result) {
            return back()->withErrors(['invalid_credentials' => 'Invalid credentials HELLO WORLD']);
        }
        */
        
        \Session::put('uf_user_social_verification', $user);
        $authUser = $this->getUser();
        if($this->is_wrong_otp){
            return redirect('/social-register')->withErrors(['mobile' => 'Verification code or mobile number is wrong']);
        }
        if(!$this->should_next){
            return redirect('/social-register');
        }
        if(!$this->is_user_exist){
            return back()->withErrors(['mobile' => 'Mobile number or Email already in use']);
        }
        if (isset($authUser)) {
            Auth::login($authUser, true);
        } else {
            if($this->mobile && $this->mobile_country_code && $this->verification_code){
                if($this->verifyOtp()){
                    $mobileUser = $this->findUserByMobileAndEmail();
                    if($mobileUser && $this->is_user_exist){
                        $this->user_id = $mobileUser->id;
                        $this->createUserProvider();
                        Auth::login($mobileUser, true);
                    }else if(!isset($mobileUser) && $this->is_user_exist){
                        return back()->withErrors(['mobile' => 'Mobile number or Email already in use']);
                    }else{
                        $authUser = $this->createUser();
                        $authUser->mobile = $this->mobile;
                        $authUser->mobile_country_code = $this->mobile_country_code;
                        if($authUser->save()){
                            Auth::login($authUser, true);
                        }   
                    }
                }else{
                    return redirect('/social-register')->withErrors(['mobile' => 'Verification code or mobile number is wrong']);
                }
            }else{
                return redirect('/social-register');
            }
        }
        if(Auth::check()){
            $this->referralSubmission(Auth::user());
        }
        if (Session::has('isBooking')) {
            Session::forget('isBooking');
            return redirect('request-a-quote');
        }
        \Session::forget('uf_user_social_verification');
        Session::forget('user_referral_id');
        return redirect()->intended('/user/dashboard');
    }

    /**
     * If a user has registered before using social auth, return the user
     * else, create a new user object.
     * @param  $user Socialite user object
     * @param $provider Social auth provider
     * @return  User
     */
    protected function userSocialregister(Request $request) {
        $validator = $this->validator($request);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $this->setSocialUser($request);
        $result = $this->checkProviderToken();
        
        /*
        if (!$result) {
            return $this->failedResponse();
        }
        */

        $authUser = $this->getUser();
        if($this->is_wrong_otp){
            return response()->json(['status' => 'failed', "exist" => false ,'error' => ['messages' => 'Verification code or mobile number is wrong']],422);
        }
        if(!$this->should_next){
            return response()->json(["status"=> "success", "exist" => false ]);
        }
        if(!$this->is_user_exist){
            return response()->json(['status' => 'failed','error' => ['messages' => 'Mobile number or Email already in use']],422);
        }
        if (isset($authUser) && count($authUser)) {
            $authUser = $this->userService->generateAccessToken($authUser);
        } else {
            if($this->mobile && $this->mobile_country_code && isset($request->verification_code)){
                if($this->verifyOtp()){
                    $mobileUser = $this->findUserByMobileAndEmail();
                    if($mobileUser && $this->is_user_exist){
                        $this->user_id = $mobileUser->id;
                        $this->createUserProvider();
                        $authUser = $this->userService->generateAccessToken($mobileUser);
                    }else if(!isset($mobileUser) && $this->is_user_exist){
                        return response()->json(['status' => 'failed','error' => ['messages' => 'Mobile number or Email already in use']],422);
                    }else{
                        $authUser = $this->createUser();
                        $authUser->mobile = $this->mobile;
                        $authUser->mobile_country_code = $this->mobile_country_code;
                        if($authUser->save()){
                            $authUser = $this->userService->generateAccessToken($authUser);
                        }   
                    }
                }else{
                    return response()->json(["status"=> "success", "exist" => false ]);
                }
            }else{
                return response()->json(["status"=> "success", "exist" => false ]);
            }
        }
        if (isset($authUser)) {
            return response()->json(['status' => 'success', "exist" => true,'message' => 'You are logged in', 'user' => $authUser]);
        }
    }

    public function setSocialUser($request) {
        $this->provider = $request->provider;
        $this->provider_id = $request->id;
        $this->default_location = isset($request->default_location)?$request->default_location:1;
        $this->email = isset($request->email) ? $request->email : null;
        $this->name = isset($request->name) ? $request->name : null;
        $this->provider_token = isset($request->provider_token) ? $request->provider_token : null;
        $this->mobile = isset($request->mobile) ? $request->mobile : null;
        $this->mobile_country_code = isset($request->mobile_country_code) ? $request->mobile_country_code : null;
        $this->verification_code = isset($request->verification_code)?$request->verification_code:null;
        
        if(isset($request->token)){
            $this->provider_token = $request->token;
        }
    }

    public function getUser() {
        if (isset($this->email)) {
            $authUser = $this->findByEmail();
        }
        
        if (!isset($authUser) && $this->should_next) {
            $authUser = $this->findByProvider();
        }
        return $authUser;
    }

    public function findByEmail() {
        $authUser = $this->findSocialUser();
        if (isset($authUser)) {
            $provider = $this->findSocialProvider();
            if (!isset($provider)) {
                if(!isset($this->mobile) && !isset($this->mobile_country_code) && !isset($this->verification_code)){
                    $this->should_next = false;
                    return null;
                }
                $user = $this->findUserByMobileAndEmail();
                if($user && $this->is_user_exist){
                    if($this->verifyOtp()){
                        $this->user_id = $authUser->id;
                        $this->createUserProvider();
                    }else{
                        return null;
                    }
                }else{
                    $this->is_user_exist = false;
                    return null;
                }
            }
        }
        return $authUser;
    }
    
    public function verifyOtp() {
        $otp_authentication = OtpAuthentication::whereMobile($this->mobile)->where('code', $this->verification_code)->get();
        if($otp_authentication->isNotEmpty()){
            $this->is_wrong_otp = false;
            return true;
        }else{
            $this->is_wrong_otp = true;
            return false;
        }
    }

    public function findByProvider() {
        $provider = $this->findSocialProvider();
        if (isset($provider)) {
            return $provider->getUser;
        }else{
            $this->checked = false;
            return null;
        }
    }

    public function checkProviderToken() {
        if ($this->provider == 'google') {
            $data = SocialiteCheck::getGoogleUserByToken($this->provider_token);
        } else if ($this->provider == 'facebook') {
            $data = SocialiteCheck::getFacebookUserByToken($this->provider_token);
        } else {
            return false;
        }
        if ($data === false || $data['id'] != $this->provider_id) {
            return false;
        }
        return true;
    }

    protected function findSocialUser() {
        return User::whereEmail($this->email)->first();
    }
    
    protected function findUserByMobile() {
        return User::whereMobile($this->mobile)->first();
    }
    
    protected function findUserByMobileAndEmail() {
        $mobileUser = $this->findUserByMobile();
        $emailUser = $this->findSocialUser();
        if($mobileUser && $emailUser){
            if($mobileUser->id === $emailUser->id){
                return $mobileUser;
            }else{
                return null;
            }
        }else if($mobileUser || $emailUser){
            return null;
        }else{
            $this->is_user_exist = false;
            return null;
        }
    }

    protected function findSocialProvider() {
        return Providers::whereProvider_id($this->provider_id)->first();
    }

    protected function createNewSocialUser() {
        return User::create([
                    'name' => $this->name,
                    'email' => $this->email,
                    'mobile_country_code' => $this->mobile_country_code,
                    'mobile' => $this->mobile,
                    'verified' => $this->verified,
                    'default_location' => $this->default_location
        ]);
    }

    protected function createUserProvider() {
        return Providers::create([
                    'user_id' => $this->user_id,
                    'provider_id' => $this->provider_id,
                    'provider' => $this->provider,
        ]);
    }

    public function createUser() {
        $authUser = $this->createNewSocialUser();
        $role = \App\Role::find(1);
        $authUser->roles()->attach($role);
        if ($authUser) {
            $this->user_id = $authUser->id;
            $this->createUserProvider();
        }
        return $authUser;
    }

    // Validate Request 
    protected function validator(Request $request) {
        return Validator::make($request->all(), [
                    'name' => 'required',
                    'email' => 'sometimes|required|email',
                    'provider' => 'required',
                    'id' => 'required',
                    'provider_token' => 'required',
                    'mobile' => 'sometimes|required|max:10|min:10',
                    'mobile_country_code' => 'sometimes|required',
                    'verification_code' => 'sometimes|required',
                        ], [
                    'name.required' => 'We need your name',
                    'email.email' => 'E-mail Address should be vaild E-mail',
                    'email.required' => 'E-mail Address is required',
                    'provider.required' => 'Provider is required',
                    'provider_token.required' => 'Provider token is required',
                    'mobile.required' => 'We need your mobile number',
                    'mobile.unique' => 'Mobile number already exists',
                    'mobile.max' => 'Mobile number must be 10 digit',
                    'mobile.min' => 'Mobile number must be 10 digit',
                    'mobile_country_code.required' => 'Country Code is required',
                    'verification_code.required' => 'We need verification code Which have been send to your registered mobile number'
        ]);
    }

    protected function failedResponse() {
        return response()->json(['status' => 'failed', 'result' => 'Invalid Credentials'], 401);
    }
    
    public function referralSubmission($user) {
        if ($user) {
            if (Session::has('user_referral_id')) {
                $referral_id = Session::get('user_referral_id');
                if (!empty($referral_id)) {
                    $referral_key = base64_decode($referral_id);
                    $array = explode('|', $referral_key);
                    if (count($array) > 1 && filter_var($array[0], FILTER_VALIDATE_EMAIL) && $this->userService->find($array[1])) {
                        $data = ['sender_id' => $array[1], 'rec_id' => $user->id, 'sender_email' => $array[0], 'rec_email' => $user->email, 'rec_redeem' => false, 'amount' => $this->appSettingsService->get('referral_amount')];
                        if($data['sender_id'] != $data['rec_id']){
                            $is_referral = Referral::where('sender_id',$data['sender_id'])
                                ->where('rec_id',$data['rec_id'])
                                ->where('sender_email',$data['sender_email'])
                                ->where('rec_email',$data['rec_email'])
                                ->first();
                            if(is_null($is_referral)){
                                Referral::create($data);
                            }
                        }
                    }
                }
            }
        }
    }

}
