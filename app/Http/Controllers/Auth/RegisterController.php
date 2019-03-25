<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Jrean\UserVerification\Traits\VerifiesUsers;
use Jrean\UserVerification\Facades\UserVerification;
use App\Http\Requests\RegisterFormRequest as RegisterFormRequest;
use App\Services\CarTrimService as CarTrimService;
use Event;
use App\Events\SendMail;
use App\Events\WelComeEmail;
use App\Events\StatusLiked;
use App\Services\UserService;
use App\Services\ZipCodeService as ZipCodeService;
use Cookie;
use App\Utility\BookingStatus;
use App\Services\ReferralService;
use App\Services\AppSettingsService;
use App\Services\SmsApiService;
use Illuminate\Support\Facades\Session;
use Jrean\UserVerification\Exceptions\UserIsVerifiedException;
use Jrean\UserVerification\Exceptions\UserNotFoundException;
use Jrean\UserVerification\Exceptions\TokenMismatchException;
use App\Services\OtpAuthenticationService;
use App\Models\OtpAuthentication;
use App\Models\ZipCode;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Register Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles the registration of new users as well as their
      | validation and creation. By default this controller uses a trait to
      | provide this functionality without requiring any additional code.
      |
     */

use RegistersUsers;

    use VerifiesUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';
    protected $userService;
    protected $zipcode;
    protected $referral;
    protected $smsapi;
    public $referralId = '';
    public $appSettingsService = '';
    protected $otpAuthenticationService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(OtpAuthenticationService $otpAuthenticationService, UserService $userService, CarTrimService $cartrim, ZipCodeService $zipcode, ReferralService $referral, SmsApiService $smsapi, AppSettingsService $appSettingsService) {
        $this->middleware('guest', ['except' => ['getVerification', 'getVerificationError']]);
        $this->cartrim = $cartrim;
        $this->userService = $userService;
        $this->zipcode = $zipcode;
        $this->referral = $referral;
        $this->appSettingsService = $appSettingsService;
        $this->smsapi = $smsapi;
        $this->otpAuthenticationService = $otpAuthenticationService;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        return Validator::make($data, [
                    'name' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255|unique:users',
                    'password' => 'required|string|min:6|dumbpwd|confirmed',
                    'mobile' => 'required|regex:/[0-9]/|unique:users|phone',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data) {
        $default_location = (isset($data['default_location']) && $data['default_location']) ? $data['default_location'] : 1;
        $mobile_country_code = (isset($data['mobile_country_code']) && $data['mobile_country_code']) ? $data['mobile_country_code'] : '+233';
        $user = User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => bcrypt($data['password']),
                    'mobile_country_code' => $mobile_country_code,
                    'mobile' => $data['mobile'],
                    'default_location' => $default_location,
                    'verified' => 1
        ]);
        // Get Car Info From Cookie
        $cookie_data_car = Cookie::get('uf_car_info');
        if (isset($cookie_data_car) && $cookie_data_car) {
            $cookie_array = json_decode($cookie_data_car, true);
            if (isset($data['default_location'])) {
                $cookie_array['location_id'] = $data['default_location'];
                Cookie::queue('uf_car_info', json_encode($cookie_array), 600);
            }
        } else {
            if (isset($data['default_location'])) {
                $cookie_array['location_id'] = $data['default_location'];
                Cookie::queue('uf_car_info', json_encode($cookie_array), 600);
            }
        }

        if (isset($data['role']) && $data['role'] != 'Admin') {
            $role = Role::where('name', '=', $data['role'])->get();
            $user->roles()->attach($role);
        } else {
            $role = Role::find(1);
            $user->roles()->attach($role);
        }
        if ($user) {
            if (isset($data['referral_id']) && $data['referral_id']) {
                $referral_id = $data['referral_id'];
                if (!empty($referral_id)) {
                    $referral_key = base64_decode($referral_id);
                    $array = explode('|', $referral_key);
                    if (count($array) > 1 && filter_var($array[0], FILTER_VALIDATE_EMAIL) && $this->userService->find($array[1])) {
                        $data = ['sender_id' => $array[1], 'rec_id' => $user->id, 'sender_email' => $array[0], 'rec_email' => $user->email, 'rec_redeem' => false, 'amount' => $this->appSettingsService->get('referral_amount')];
                        $this->referral->create($data);
                    }
                }
            }
        }
        return $user;
    }

    public function showRegistrationForm() {
        $data['locations'] = $this->zipcode->findAll(1);
        \Session::forget('uf_user_verification');
        \Session::forget('uf_user_social_verification');
        return view('auth.register', $data);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterFormRequest $request) {
        $request_data = $request->all();
        if (!isset($request->verification_code)) {
            if ($this->sendOtp($request)) {
                \Session::push('uf_user_verification', $request_data);
                return redirect('verify-mobile');
            } else {
                return redirect()->back()->withErrors([]);
            }
        }
        $otp_authentication = OtpAuthentication::whereMobile($request->mobile)->where('code', $request->verification_code)->get();
        if ($otp_authentication->isNotEmpty()) {
            event(new Registered($user = $this->create($request->all())));
        } else {
            return redirect()->back()->withErrors(['verification_code' => 'verification code is wrong']);
        }
        \Session::forget('uf_user_verification');
        $this->guard()->login($user);

        if (isset($request_data['request_from']) && $request_data['request_from'] && $request_data['request_from'] == 'AJAX') {
            return response()->json(['status' => 'success'], 200);
        }
        return redirect('/user');
    }

    public function VerifyMobile(Request $request) {
        if (\Session::has('uf_user_verification')) {
            return view('auth.verify_before_register');
        } else {
            return redirect('/register');
        }
    }

    public function sendOtp(Request $request) {
        $response = 0;
        $otp_authentication = OtpAuthentication::whereMobile($request->mobile)->first();
        try {
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
        } catch (\Exception $ex) {
            if ($request->ajax()) {
                return response()->json(false, 400);
            } else {
                return false;
            }
        }
        if ($response) {
            if ($request->ajax()) {
                return response()->json(true);
            } else {
                return true;
            }
        }
        if ($request->ajax()) {
            return response()->json(false, 400);
        } else {
            return false;
        }
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard() {
        return Auth::guard();
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user) {
        
    }

    protected function validateEmail(Request $request) {
        $this->validate($request, ['email' => 'required|email']);
    }

    public function getVerification(Request $request, $token) {
        if (!$this->validateRequest($request)) {
            return redirect($this->redirectIfVerificationFails());
        }

        try {
            $user = UserVerification::process($request->input('email'), $token, $this->userTable());
        } catch (UserNotFoundException $e) {
            return redirect('register');
        } catch (UserIsVerifiedException $e) {
            $userId = User::whereEmail($request->input('email'))->first()->getRole->first()->id;
            if ($userId === 1) {
                return redirect()->intended('/user/dashboard');
            } else {
                return redirect()->intended('/');
            }
        } catch (TokenMismatchException $e) {
            return redirect('login');
        }

        if (config('user-verification.auto-login') === true) {
            auth()->loginUsingId($user->id);
        }
        Event::fire(new WelComeEmail($user));
        if ($this->userService->checkAuthBooking() > 0 && $this->userService->checkAuthBookingStatus() == BookingStatus::PENDING) {
            foreach (User::find($user->id)->getBookings as $value) {
                $event = $value;
            }

            if ($user->verified) {
                Event::fire(new SendMail($event));
                Event::fire(new StatusLiked(Auth::user()->name));
            }
        }
        return redirect($this->redirectAfterVerification());
    }

    public function getVerificationError() {
        return view($this->verificationErrorView());
    }

    public static function socialRegister() {
        $data['locations'] = ZipCode::whereStatusAndService_availability(1, 1)->get();
        if (\Session::has('uf_user_social_verification')) {
            $data['data'] = \Session::get('uf_user_social_verification');
            return view('auth.social-register', $data);
        } else {
            return redirect('/login');
        }
    }

}
