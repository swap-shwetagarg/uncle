<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

Route::get('/', 'Web\QuoteController@home');

/*
  Route::get('/', function () {
  return view('web.blocks.pages.home');
  });
 */

Route::get('/sitemap.xml', 'SitemapController@index');
Route::group(['middleware' => ['prevent-back-history', 'XSS']], function() {
    Auth::routes();
    Route::get('verify-mobile', 'Auth\RegisterController@VerifyMobile');
    Route::get('re-send-otp', 'Auth\RegisterController@sendOtp');
    Route::get('send-verification-link', 'Web\UserController@generatelinkToVerifyAccount')->middleware('auth');
    Route::get('social-register', 'Auth\RegisterController@socialRegister');

    Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'isAdmin', 'isVerified']], function() {
        Route::get('dashboard', 'Admin\AdminController@index');
        Route::get('profile', 'Admin\AdminController@profile');
        Route::get('change-status/{id}/{status}/{type}', 'Admin\AdminController@changeStatus');
        Route::get('change-is-popular/{id}/{status}', 'Admin\AdminController@changeIsPopular');
        Route::get('bookings', 'Admin\BookingController@index');
        
        Route::get('bookings/request-a-quote', 'Admin\BookingController@requestAQuote');
        Route::get('bookings/seach-username', 'Admin\BookingController@searchUser');
        Route::get('bookings/get-user-cars/{user_id?}', 'Admin\BookingController@getUserCars');
        Route::get('bookings/get-categories/{service_type_id?}', 'Admin\BookingController@getCategories');
        Route::get('bookings/get-services/{category_id?}', 'Admin\BookingController@getServices');
        Route::get('bookings/get-sub-services/{service_id?}', 'Admin\BookingController@getSubServices');
        Route::post('bookings/add-services', 'Admin\BookingController@addServices');
        Route::get('bookings/delete-service/{service_id?}', 'Admin\BookingController@deleteService');
        Route::post('bookings/submit-quote', 'Admin\BookingController@submitQuote');
        Route::post('bookings/search-service', 'Admin\BookingController@searchServices');
        
        Route::get('bookings/status/{status}', 'Admin\BookingController@getAllBookings');
        Route::get('bookings/{id}', 'Admin\BookingController@getBookingDetails');
        Route::get('bookings/assign-mechanic/{booking_id}/{mechanic_id}/{from_time}/{to_time}', 'Admin\BookingController@assignMechanic');
        Route::get('bookings/get-mechanic/{id}/{mechanic_id}/{zipcode_id}', 'Admin\BookingController@getMechanics');
        Route::get('bookings/update/{id}/{status}', 'Admin\BookingController@updateBookingStatus');
        Route::get('bookings/update/quote/{id}/{price}', 'Admin\BookingController@updateQuote');
        Route::get('bookings/available-times/{id}/{date}', 'Admin\BookingController@availableTimes');

        Route::get('bookings/update-services/{id}', 'Admin\BookingController@updateBookingServices');

        Route::group(['middleware' => ['auth', 'role:Master', 'isVerified']], function() {
            Route::resource('locations', 'Admin\ZipCodeController');
            Route::resource('car/makes', 'Admin\CarsController');
            Route::resource('car/models', 'Admin\CarModelController');
            Route::resource('car/years', 'Admin\YearController');
            Route::resource('car/trims', 'Admin\CarTrimController');
            Route::resource('service-types', 'Admin\ServiceTypeController');
            Route::resource('services', 'Admin\ServicesController');
            Route::resource('sub-services', 'Admin\SubServiceTypeController');
            Route::resource('sub-service-options', 'Admin\SubServiceOptController');
            Route::resource('categories', 'Admin\CategoryController');
            Route::get('cardata/{id}', 'Admin\CarModelController@getCarData');
            Route::get("get-car-modal/{id}",'Admin\CarModelController@getCarModal');
        });

        Route::resource('user', 'Admin\UserController');
        Route::get('user/role/{userType}', 'Admin\UserController@getUserByType');
        Route::get('user/role/{userType}/{user_id}', 'Admin\UserController@updateUserRole');
        Route::get('user/mechanic/{user_id}', 'Admin\UserController@viewProfile');
        Route::get('importExport', 'ImportExcelController@importExport');
        Route::post('importExcel', 'ImportExcelController@importExcel');
        Route::get('user/add/{user_type}', 'Admin\UserController@addUser');
        Route::post('user/save-user', 'Admin\UserController@saveUser');
        
        Route::get('user/search/{search_user}', 'Admin\UserController@searchUser');

        Route::put('change-password', 'Auth\ChangePasswordController@changePassword');
        Route::resource('payment', 'Admin\PaymentController');

        Route::resource('app-setting', 'Admin\AppSettingController');

        Route::resource('referrals', 'Admin\ReferralController');
        Route::get('referral-settings', 'Admin\ReferralController@referralSettings');
        Route::post('save-referral-settings', 'Admin\ReferralController@saveReferralSettings');

        Route::resource('settings', 'Admin\SettingsController');
        Route::post('save-settings', 'Admin\SettingsController@saveSettings');
        
        Route::get('export/{type}', 'Admin\UserController@exportUsers');        

        // Routes Temporary User Switching
        Route::get('user/switch/start/{id}', 'Admin\UserController@user_switch_start');

    });

    Route::group(['middleware' => ['auth', 'isMechanic', 'isVerified']], function() {
        Route::get('/mechanic/profile', function() {
            return redirect('/');
        });
    });
    
    Route::get('user/bookings/update/{id}/{status}', 'Web\BookingController@updateBookingStatus');
    Route::get('/user/bookings/delete/{id}', 'Web\BookingController@deleteBooking');
        
    Route::group(['middleware' => ['auth', 'isUser', 'isVerified']], function() {
        Route::get('user/bookings', 'Web\BookingController@getAllBookings');
        Route::get('user/bookings/status/{status}', 'Web\BookingController@getAllBookings');
        Route::get('user/bookings/{id}', 'Web\BookingController@getBookingDetails');
        Route::post('change-location','Web\UserController@updateLocation');
        Route::get('user/check-payment/{id}', 'Web\PaymentController@checkPayment');
        Route::get('/user/mechanic-profile/{id}', 'Web\UserController@mechanicProfile');
        Route::get('/user/booking/schedule-booking/{id}', 'Web\BookingController@scheduleBooking');
        Route::get('/user/booking/available-times/{date}/{id}', 'Web\BookingController@availableTimes');
        Route::post('/user/booking/schedule-booking', 'Web\BookingController@saveScheduleTimes');
        Route::get('/user/booking/get-scheduled-bookings/{id}/{sdate}/{edate}', 'Web\BookingController@GetScheduledBookings');
        Route::get('/user/thank-you', 'Web\BookingController@thankyou');
        Route::resource('user/payment', 'Web\PaymentController');
        Route::resource('user/refer', 'Web\ReferController');
        Route::resource('user/send-referral-email', 'Web\ReferController');
        Route::get('user/rate-mechanic/{id}/{bookingid}', 'Web\RatingController@getMechanicRating');
        Route::post('user/submit-rating', 'Web\RatingController@saveMechanicRating');
        Route::resource('user/address', 'Web\UserAddressController');
        Route::get('user/dashboard', 'Web\UserController@index');
        Route::put('change-password', 'Auth\ChangePasswordController@changePassword');
        Route::get('user/cars/{id}', 'Web\UserCarController@destroy');
        Route::get('user/cars/booking/{id}', 'Web\UserCarController@getUserCarServices');
        Route::get('user/cars/car-health/{id}', 'Web\UserCarController@getCarHealth');
        Route::post('user/cars/update-health/{id}', 'Web\UserCarController@updateCarHealth');
        Route::resource('user/cars', 'Web\UserCarController');
        Route::get('user/cars/car-details/{id}', 'Web\UserCarController@getCarDetails');
        Route::post('user/cars-submit-extra-details','Web\UserCarController@updateCarDetails');
        Route::get('caryear/{id}', 'Web\UserCarController@getCarYear');
        Route::get('carmodel/{id}', 'Web\UserCarController@getCarModel');
        Route::get('cartrim/{id}', 'Web\UserCarController@getCarTrim');
        Route::get('user-confirm-booking/{id}', 'Apis\BookingController@getUserProcessing');
        Route::get('payments/slydepay_payment_callback/', 'Web\PaymentController@callbackPayment');
        Route::get('book-service/{trim_id}', 'Web\UserCarController@bookService');
        Route::get('user/check-for-express-pay/{id}', 'Web\ExpressPayController@checkForPayment');
        Route::get('user/express-callback-pay/', 'Web\ExpressPayController@expCallbackPayment');
        Route::resource('user', 'Web\UserController');

        // Routes Temporary User Switching
        Route::get('user/switch/stop', 'Web\UserController@user_switch_stop');
    });

    Route::group(['middleware' => ['guest']], function() {
        Route::get('become/mechanic', function() {
            return view('auth.mechanic_register');
        });

        Route::get('email-verification/error', 'Auth\RegisterController@getVerificationError')->name('email-verification.error');

        Route::get('email-verification/check/{token}', 'Auth\RegisterController@getVerification')->name('email-verification.check');
    });

    Route::resource('zipcode', 'Web\ZipCodeController');
    Route::resource('car', 'Web\CarsController');
    Route::resource('carmodel', 'Web\CarModelController');
    Route::resource('year', 'Web\YearController');
    Route::resource('cartrim', 'Web\CarTrimController');
    Route::resource('servicetype', 'Web\ServiceTypeController');
    Route::resource('service', 'Web\ServicesController');
    Route::resource('subservice', 'Web\SubServiceTypeController');
    Route::resource('subserviceopt', 'Web\SubServiceOptController');
    Route::resource('category', 'Web\CategoryController');

    Route::get('get-ip-details', function (\Illuminate\Http\Request $request) {
        $ip = $request->ip();
        $data = \Location::get($ip);
        dd($data);
    });

    Route::get('welcome', function() {
        return view('web.layouts.registration_verification');
    })->middleware('auth', 'isNotVerified');

    Route::group(['middleware' => ['auth', 'isNotVerified']], function() {
        Route::get('resend-verification-code', 'Web\UserController@reSendVerificationCode');
        Route::post('verify-account', 'Web\UserController@verifyAccount');
    });

    Route::get('request-a-quote', 'Web\QuoteController@index');
    Route::get('check-service-availability/{location}', 'Web\QuoteController@checkLocation');
    Route::get('show-cars/{new?}', 'Web\QuoteController@showCars');
    Route::get('show-years/{car}', 'Web\QuoteController@showYears');
    Route::get('show-models/{year}', 'Web\QuoteController@showCarModels');
    Route::get('show-trims/{model}', 'Web\QuoteController@showCarTrims');
    Route::get('show-car-info/{trim}/{selected?}', 'Web\QuoteController@showCarInfo');
    Route::get('show-service-categories/{service_type}', 'Web\QuoteController@showServiceCategories');
    Route::get('show-services/{service_category}', 'Web\QuoteController@showServices');
    Route::get('show-sub-services/{service}', 'Web\QuoteController@showSubServices');
    Route::get('show-options/{sub_service}', 'Web\QuoteController@showOptions');
    Route::get('reset-quotation', 'Web\QuoteController@resetQuotation');
    Route::post('review-and-book', 'Web\QuoteController@reviewAndBook');
    Route::get('add-more-services', 'Web\QuoteController@addMoreServices');
    Route::get('delete-selected-service/{service}', 'Web\QuoteController@deleteSelectedService');
    Route::post('submit-quotation', 'Web\QuoteController@submitQuotation');
    Route::get('save-option/{service_id}/{sub_service_id}/{option_id}/{action}/{type}', 'Web\QuoteController@saveSubServiceOption');
    Route::get('show-diagnostics-sub-services/{service}', 'Web\QuoteController@showDiagnosticsSubServices');
    Route::get('show-next-sub-services/{sub_service}/{option}/{service}', 'Web\QuoteController@showNextSubServices');
    Route::get('show-recommended-services/{services}', 'Web\QuoteController@showRecommendedServices');
    Route::get('thank-you', 'Web\QuoteController@thankYouForBooking');
    Route::get('delete-selected-services', 'Web\QuoteController@deleteSelectedServices');
    Route::get('reset-services', 'Web\QuoteController@resetServices');
    Route::get('get-selected-services','Web\QuoteController@getSelectedServices');

    Route::get('about-our-mechanics', 'Web\QuoteController@aboutOurMechanic');
    Route::get('faq', 'Web\QuoteController@faq');
    Route::get('services', 'Web\QuoteController@services_all');
    Route::get('services/{id}', 'Web\QuoteController@services_details');
    
    Route::get('search-services/{type}/{search?}', 'Web\QuoteController@searchServices');
    
});
Route::get('get-payable-detail/{id}', 'Apis\PaymentController@checkForPayment');

/* Leagl Pages */
Route::get('customer-terms-and-conditions', 'Web\PostController@getTermsAndConditions');
Route::get('limited-warranty', 'Web\PostController@getLimitedWarranty');
Route::get('privacy-policy', 'Web\PostController@getPrivacyPolicy');
Route::get('trademark-usage-policy', 'Web\PostController@getTrademarkUsagePolicy');

/* Leagl Pages For Web View */
Route::get('web/customer-terms-and-conditions', 'Web\PostController@getTermsAndConditionsWeb');
Route::get('web/limited-warranty', 'Web\PostController@getLimitedWarrantyWeb');
Route::get('web/privacy-policy', 'Web\PostController@getPrivacyPolicyWeb');
Route::get('web/trademark-usage-policy', 'Web\PostController@getTrademarkUsagePolicyWeb');
Route::get('web/about-unclefitter', 'Web\PostController@getAboutUncleFitterWeb');
Route::get('web/how-it-works', 'Web\PostController@getHowItWorksWeb');