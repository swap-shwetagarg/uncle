<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\BookingService;
use Auth;
use App\Utility\BookingStatus;
use App\Services\PaymentService;
use App\Services\ReferralService;
use Illuminate\Support\Facades\Event;
use App\Events\ConfirmedBooking;
use App\Events\SendMail;
use App\Services\BookingMechanicService;
use App\Services\AddressService;
use App\Events\BookingCancelled;
use DateTime;
use App\Facades\AppSettings;

class BookingController extends Controller {

    private $bookingService;
    private $paymentService;
    private $referralService;
    private $bookingMechanicService;
    private $useraddress;

    public function __construct(BookingService $bookingService, PaymentService $paymentService, ReferralService $referralService, BookingMechanicService $bookingMechanicService, AddressService $useraddress) {
        $this->bookingService = $bookingService;
        $this->paymentService = $paymentService;
        $this->referralService = $referralService;
        $this->bookingMechanicService = $bookingMechanicService;
        $this->useraddress = $useraddress;
    }

    public function getAllBookings(Request $request, $status = null) {
        $vat_tax = AppSettings::get('vat_tax');
        if ($status === null) {
            $bookings = $this->bookingService->userBookings($status, Auth::user()->id);
        } else {
            $bookings = $this->bookingService->userBookings($status, Auth::user()->id);
        }
        if ($status) {
            return view('web.user.booking.booking_table', ['bookings' => $bookings, 'vat_tax' => $vat_tax]);
        } else {
            return view('web.user.booking.user_bookings', ['bookings' => $bookings, 'page' => 'my-bookings', 'vat_tax' => $vat_tax]);
        }
    }

    public function getBookingDetails($id) {
        $vat_tax = AppSettings::get('vat_tax');
        $booking = $this->bookingService->find($id);
        return view('web.user.booking.booking_details', ['booking' => $booking, 'vat_tax' => $vat_tax]);
    }

    public function updateBookingStatus($id, $status) {        
        $booking = $this->bookingService->find($id);
        if ($booking->status == 6 && $status == 9) {
           return response()->json(['status' => 'failed', 'message' => 'Booking can not delete'],400);     
        }
        $result = $this->bookingService->changeBookingStatus($id, ['status' => $status]);            
        if ($result && $status == 9) { //This will work only when user cancel a booking
            Event::fire(new BookingCancelled($id, $booking));
            if (!is_null($booking->bookingMechanic) && !((strtotime($booking->bookingMechanic->booked_from) - strtotime(date("Y-m-d H:m A"))) / 3600 > 4)) {
                
            }
            return response()->json(['status' => 'success', 'message' => 'Booking Cancelled']);
        }
        if ($result && $status == 4) { //This will work only when user change booking from saved to request a quote
            Event::fire(new SendMail($booking));                    
            return response()->json(['status' => 'success', 'message' => 'Request Done']);
        }else if ($result && $status == 1) {
            $redeem_amount = $this->paymentService->redeemAmount(Auth::user()->id);
            $all_redeems = $this->referralService->availableRedeem(Auth::user()->id);
            foreach ($all_redeems as $redeem) {
                if ($redeem_amount > 0 && $redeem_amount >= $redeem->amount) {
                    if ($redeem->sender_id == Auth::user()->id)
                        $this->referralService->update(['sender_booking_id' => $id, 'sender_redeem' => 1], $redeem->id);
                    if ($redeem->rec_id == Auth::user()->id)
                        $this->referralService->update(['rec_booking_id' => $id, 'rec_redeem' => 1], $redeem->id);
                    $redeem_amount = $redeem_amount - $redeem->amount;
                } else
                    break;
            }
            return response()->json(['status' => 'success', 'message' => 'Booking confirmed']);
        }else if ($result && $status == 5) {
            return response()->json(['status' => 'success', 'message' => 'Booking Deleted']);
        }else{
            return response()->json(['status' => 'Failed', 'message' => 'Some error occured please call admin'],400);
        }    
    }

    public function deleteBooking($id) {
        try {
            $result = $this->bookingService->destroy($id);
        } catch (\Exception $ex) {
            $result = false;
        }
        if ($result) {
            return response()->json(['status' => 'success', 'message' => 'Booking deleted']);
        }
        return response()->json(['status' => 'failed', 'message' => 'Some error occured please call admin'],400);
    }

    public function availableTimes($date, $id) {
        $available_times = $this->bookingMechanicService->getAvailableTimes($date);
        if ((date("Y-m-d", strtotime(str_replace('/', '-', $date))) < date("Y-m-d"))) {
            $available_times = $this->bookingMechanicService->getDefaultTimes();
        } elseif ((date("Y-m-d", strtotime(str_replace('/', '-', $date))) == date("Y-m-d"))) {
            $arr = array('7' => 'A', '9' => 'B', '11' => 'C', '13' => 'D', '15' => 'E', '17' => 'F');
            for ($i = 7; $i <= 17; $i += 2) {
                if ((date("H") >= $i)) {
                    $available_times[0]->{$arr[$i]} = 0;
                }
            }
        }
        $booking = $this->bookingService->find($id);
        $address_list = $this->useraddress->findAll()->Where('user_id', Auth::user()->id);
        return view('web.user.booking.schedule_availability', ['available_times' => $available_times, 'address' => $booking->address, 'location' => $booking->getZipCode->zip_code . ' ' . $booking->getZipCode->country_code, 'address_list' => $address_list]);
    }

    public function scheduleBooking($id) {
        $vat_tax = AppSettings::get('vat_tax');
        $booking = Auth::user()->getBooking->where('id', $id)->first();
        if (is_null($booking)) {
            return back();
        }
        $dt = new DateTime('tomorrow');
        $redeem_amount = $this->paymentService->redeemAmount(Auth::user()->id);
        if ($booking->status === BookingStatus::QUOTED || $booking->status === BookingStatus::PROGRESSING) {
            return view('web.user.booking.schedule_booking', [
                'booking_id' => $id,
                'booking_status' => $booking->status,
                'booking_price' => $booking->price,
                'redeem_amount' => $redeem_amount,
                'vat_tax' => $vat_tax,
                'actual_time' => $dt->format('Y-m-d H:i:s')
            ]);
        } else {
            return back();
        }
    }

    public function saveScheduleTimes(Request $request) {
        $array = $request->all();
        $address = urldecode($array['address']);
        $booking_id = $array['booking_id'];
        $date = date("Y-m-d", strtotime(str_replace('/', '-', $array['date'])));
        $schedule_start_time = $array['sTime'];
        $result = $this->bookingService->update(['status' => BookingStatus::PROGRESSING,'address' => $address, 'schedule_date' => $date, 'schedule_start_time' => $schedule_start_time, 'schedule_end_time' => $schedule_start_time], $booking_id);
        if (isset($array['payment_mode']) && $array['payment_mode']) {
            $data = [
                'booking_id' => $booking_id,
                'status' => 4,
                'mode' => $array['payment_mode']
            ];
            $this->paymentService->create($data);
        }
        if ($result) {
            Event::fire(new ConfirmedBooking($this->bookingService->find($booking_id)));
            return response()->json(['status' => 'success', 'message' => 'Booking Scheduled']);
        }
        return response()->json(['status' => 'Failed', 'message' => 'Some error occured please call admin']);
    }

    public function GetScheduledBookings($id, $start_date, $end_date) {
        $bookings = $this->bookingService->getScheduledBookings(Auth::user()->id, $start_date, $end_date);
        return response()->json(['bookings' => $bookings]);
    }

    public function thankyou() {
        return view('web.user.thank_you');
    }

}
