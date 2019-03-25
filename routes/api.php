<?php

use Illuminate\Http\Request;

/*
  |--------------------------------------------------------------------------
  | API Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register API routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | is assigned the "api" middleware group. Enjoy building your API!
  |
 */

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'Apis\UserController@login');
Route::post('register', 'Apis\UserController@register');
Route::post('provider/register', 'Apis\AuthController@userSocialregister');
Route::get('auth/{provider}', 'Apis\AuthController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Apis\AuthController@handleProviderCallback');
Route::post('send-otp', 'Apis\AuthController@sendOtp');
Route::post('verify-otp', 'Apis\UserController@verifyOtp');
Route::post('reset-password', 'Apis\UserController@resetPassword');
Route::get('zipcode', 'Apis\ZipCodeController@index');

// Express Payment CallBack Route
Route::get('user/express-callback-pay-app','Apis\PaymentController@expCallbackPayment');

Route::group(['middleware' => ['auth:api']], function() {
    Route::get('get-user-details','Apis\UserController@getUserDetails');
    Route::post('logout', 'Apis\UserController@logout');
    Route::post('change-password', 'Apis\UserController@changePassword');
    Route::resource('user', 'Apis\UserController');    
    Route::resource('car', 'Apis\CarsController');
    Route::resource('year', 'Apis\YearController');
    Route::resource('carmodel', 'Apis\CarModelController');
    Route::resource('cartrim', 'Apis\CarTrimController');
    Route::resource('servicetype', 'Apis\ServiceTypeController');
    Route::resource('service', 'Apis\ServicesController');
    Route::resource('subservice', 'Apis\SubServiceTypeController');
    Route::resource('subserviceopt', 'Apis\SubServiceOptController');
    Route::resource('category', 'Apis\CategoryController');
    Route::resource('booking', 'Apis\BookingController');
    Route::resource('bookingitems', 'Apis\BookingItemsController');
    Route::resource('bookingservicesub', 'Apis\BookingServiceSubController');
    Route::resource('bookingsubopt', 'Apis\BookingServiceSubOptController');
    Route::resource('payment', 'Apis\PaymentController');
    Route::get('user-confirm-booking/{id}', 'Apis\BookingController@getUserProcessing');
    Route::get('cardata/{id}', 'Apis\CarModelController@getCarData');
    Route::put('change-password', 'Auth\ChangePasswordController@changePassword');
    Route::get('user-caryear/{id}', 'Web\UserCarController@getCarYear');
    Route::get('user-carmodel/{id}', 'Web\UserCarController@getCarModel');
    Route::get('user-cartrim/{id}', 'Web\UserCarController@getCarTrim');
    Route::resource('add-user-new-car', 'Apis\UserCarController');

    Route::get('show-service-categories/{service_type}', 'Apis\QuoteController@showServiceCategories');
    Route::get('show-services/{service_category}', 'Apis\QuoteController@showServices');
    Route::get('show-sub-services/{service}', 'Apis\QuoteController@showSubServices');
    Route::get('show-options/{sub_service}', 'Apis\QuoteController@showOptions');
    Route::get('add-more-services', 'Apis\QuoteController@addMoreServices');
    Route::get('delete-selected-service/{service}', 'Apis\QuoteController@deleteSelectedService');
    Route::post('submit-quotation', 'Apis\QuoteController@submitQuotation');
    Route::get('save-option/{option_id}/{action}', 'Apis\QuoteController@saveSubServiceOption');
    Route::get('show-services', 'Apis\QuoteController@showServices');
    Route::get('show-next-sub-services/{sub_service}/{option}/{service}', 'Apis\QuoteController@showNextSubServices');
    Route::get('get-bookings-list', 'Apis\MechanicController@index');
    Route::post('get-bookings-by-date', 'Apis\MechanicController@getBookingByDate');
    Route::post('get-bookings-by-into-date', 'Apis\MechanicController@getBookingIntoDate');
    Route::get('get-booking-details/{id}', 'Apis\MechanicController@show');
    Route::put('mechanic-response/{id}', 'Apis\MechanicController@update');
    Route::post('complete-booking', 'Apis\MechanicController@confirmBookingCompletionStatus');
    Route::get('get-car-health/{id}', 'Apis\MechanicController@getCarHealth');
    Route::post('submit-car-health', 'Apis\MechanicController@updateCarHealth');
    Route::post('register-device-token', 'Apis\UserController@registerDeviceToken');
    Route::get('get-user-car','Apis\UserController@getUserCar');
    Route::get('get-user-bookings','Apis\UserController@getUserBookings');
    Route::post('/user/booking/schedule-booking-details', 'Web\BookingController@saveScheduleTimes');
    Route::post('user/submit-rating', 'Apis\RatingController@saveMechanicRating');
    Route::resource('user/send-referral-email', 'Web\ReferController');
    Route::post('get-booking/available-times', 'Apis\BookingController@availableTimes');
    Route::get('get-scheduling-detail/{id}','Apis\BookingController@scheduleBooking');
    Route::post('getBooking-by-carId','Apis\UserController@getUserBookingsByCarId');
    Route::get('get-expess-pay-credentials','Apis\UserController@getPayCredentials');
    Route::post('get-car-report','Apis\UserCarController@getUserCarHealthReport');
    Route::get('get-booking-billings/{bookingId}','Apis\PaymentController@getPaymentInfo');
    Route::get('get-user-billings','Apis\PaymentController@getAllUserBillings');
    Route::post('user/get-referral-link','Web\ReferController@getReferralLink');
    Route::get('get-device-tokens',function(){
        $tokens = \App\Models\DeviceTokens::all();
        return response()->json(['tokens' => $tokens]);
    });
    Route::post('submit-mech-location','Apis\MechanicController@submitMechanicLocation');
    Route::get('get-mech-location/{id}','Apis\UserController@getMechanicLocation');
    Route::get('get-upcoming-bookings','Apis\UserController@getUpcomingBookings');
    Route::get('get-all-counts','Apis\UserController@getCounts');
    Route::get('get-user-settings','Apis\UserController@getUserSettings');
    Route::get('pay-by-reedem/{id}','Apis\PaymentController@byReedemAmount');
    Route::get('services-counter','Apis\ServicesController@serviceCounter');  
});
