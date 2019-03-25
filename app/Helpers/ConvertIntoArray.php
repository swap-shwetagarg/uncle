<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Helpers;

use Auth;
use Carbon\Carbon;
use App\Utility\BookingStatus;

/**
 * Description of ConvertIntoArray
 *
 * @author vishal
 */
class ConvertIntoArray {

    public static function booking(array $booking_details) {

        return array(
            'user_id' => Auth::user()->id,
            'cartrim_id' => $booking_details['cartrim_id'],
            'zipcode_id' => isset($booking_details['zipcode_id']) ? $booking_details['zipcode_id'] : Auth::user()->default_location,
            'status' => ((Auth::user()->email == null || Auth::user()->email == "") ? BookingStatus::SAVED : BookingStatus::PENDING), //we will just save the booking and will not sent email to admin or user
            'own_service_description' => isset($booking_details['own_service_description']) ? $booking_details['own_service_description'] : null,
            'date_time' => Carbon::now()->toDateTimeString(),
        );
    }

    public static function bookingFromAdmin(array $booking_details, $action_type = '') {
        if ($action_type == 'update') {
            return array(
                'user_id' => $booking_details['user_id'],
                'own_service_description' => isset($booking_details['own_service_description']) ? $booking_details['own_service_description'] : null
            );
        } else {
            return array(
                'user_id' => $booking_details['user_id'],
                'cartrim_id' => $booking_details['cartrim_id'],
                'zipcode_id' => isset($booking_details['zipcode_id']) ? $booking_details['zipcode_id'] : Auth::user()->default_location,
                'status' => ((Auth::user()->email == null || Auth::user()->email == "") ? BookingStatus::SAVED : BookingStatus::PENDING), //we will just save the booking and will not sent email to admin or user
                'own_service_description' => isset($booking_details['own_service_description']) ? $booking_details['own_service_description'] : null,
                'date_time' => Carbon::now()->toDateTimeString(),
            );
        }
    }

    public static function bookingItem($booking_result, array $key) {

        return array(
            'booking_id' => $booking_result['id'],
            'service_id' => $key['service_id'],
        );
    }

    public static function bookingServiceSub($bookingitem_result, array $service_sub) {

        return array(
            'booking_items_id' => ($bookingitem_result && sizeof($bookingitem_result)) ? $bookingitem_result['id'] : '',
            'sub_service_id' => ($service_sub && sizeof($service_sub)) ? $service_sub['sub_service_id'] : '',
        );
    }

    public static function bookingSubOption($bookingservicesub_result, array $sub_option) {

        return array(
            'booking_sub_service_id' => $bookingservicesub_result['id'],
            'sub_service_option_id' => $sub_option['sub_service_option_id'],
        );
    }

    public static function paymentDetails($request) {
        return array(
            'transaction_id' => $request->transac_id,
            'booking_id' => $request->booking_id,
            'mode' => $request->mode,
            'status' => $request->status,
            'payment_token' => $request->pay_token
        );
    }

    public static function makePayment($id) {
        return [
            'booking_id' => $id,
            'mode' => 'COS',
            'status' => 6,
            'transaction_id' => 'UF-COS-' . rand(1000000, 1000000000),
        ];
    }

}
