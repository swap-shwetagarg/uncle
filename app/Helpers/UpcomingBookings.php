<?php

/**
 * Created by PhpStorm.
 * User: vishal
 * Date: 21/6/17
 * Time: 10:53 PM
 */

namespace App\Helpers;

use Carbon\Carbon;
use App\User;
use App\Models\Booking;
use Auth;
use DB;

class UpcomingBookings extends Helpers {

    public static function ConvertFormat(Carbon $data) {
        return Carbon::createFromFormat('Y-m-d H:i:s', $data)->format('d-m-Y');
    }

    public static function CaluculateDiffer(Booking $date) {
        $created_at = self::ConvertCarbon($date);
        $now = Carbon::now();
        $difference = $created_at->diffInDays($now);
        return $difference;
    }

    public static function CaluculateNextDate(Booking $date) {
        $difference = self::CaluculateDiffer($date);
        //if ($difference == 80 || $difference == 85 || $difference == 90 || ($difference <= 80 && $difference >=90 )) {
        if ($difference >= 80 && $difference <= 90) {
            return self::ConvertFormat(self::ConvertCarbon($date)->addMonths(3));
        } else if ($difference === 350 || $difference === 360 || $difference === 364) {
            return self::ConvertFormat(self::ConvertCarbon($date)->addMonths(12));
        } else {
            return false;
        }
    }

    public static function ConvertCarbon(Booking $date) {
        return new Carbon($date->date_time);
    }

    public static function getUsers() {
        $results = [];
        $dates = [];
        $tamp_user_car_array = [];
        $users = User::all();
        if (count($users) > 0) {
            foreach ($users as $user) {
                if (count($user->getCars) > 0) {
                    $cars[] = $user->getCars;
                }
            }
            foreach ($cars as $car) {
                if (count($car) > 0) {
                    foreach ($car as $item) {
                        $result = Booking::ofBooking($item)->status()->get()->sortByDesc('id');
                        $result = self::filteBookingCollection($result);
                        if ($result->isNotEmpty()) {
                            foreach ($result as $res) {
                                if ($res->bookingItems->isNotEmpty()) {
                                    foreach ($res->bookingItems as $bItems) {
                                        //if($bItems->getService->category_id === 1){
                                        if (isset($bItems->getService->id) && $bItems->getService->id && $bItems->getService->id === 1) {
                                            if( !in_array( $res->cartrim_id.'-'.$res->user_id, $tamp_user_car_array ) ) {
                                                $dates[] = $res;
                                            }
                                            $tamp_user_car_array[] = $res->cartrim_id.'-'.$res->user_id;
                                            //$dates[] = $res;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $dates;
    }

    public static function getAuthNextBooking() {
        $users = Auth::user();
        $tamp_user_car_array = [];
        if (count($users) > 0) {
            $cars[] = $users->getCars;
            foreach ($cars as $car) {
                if (count($car) > 0) {
                    foreach ($car as $item) {
                        $date = Booking::ofBooking($item)->status()->get()->sortByDesc('id');
                        $date = self::filteBookingCollection($date);
                        if ($date->isNotEmpty()) {
                            foreach ($date as $res) {
                                if ($res->bookingItems->isNotEmpty()) {
                                    foreach ($res->bookingItems as $bItems) {
                                        //if($bItems->getService->category_id === 1){
                                        if ($bItems->getService->id === 1) {
                                            if( !in_array( $res->cartrim_id.'-'.$res->user_id, $tamp_user_car_array ) ) {
                                                $dates[] = $res;
                                            }
                                            $tamp_user_car_array[] = $res->cartrim_id.'-'.$res->user_id;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        if (isset($dates) && count($dates) > 0) {
            $i = 0;
            foreach ($dates as $key) {
                if (self::CaluculateAuthNextDate($key)) {
                    $nextDate['booking'][$i][] = self::CaluculateAuthNextDate($key);
                    $nextDate['booking'][$i][] = $key;
                    $i++;
                }
            }
            if (isset($nextDate) && count($nextDate) > 0) {
                return $nextDate;
            }
        }
        return false;
    }

    public static function CaluculateAuthNextDate(Booking $date) {
        $difference = self::CaluculateDiffer($date);
        if ($difference >= 60 && $difference <= 90) {
            return self::ConvertFormat(self::ConvertCarbon($date)->addMonths(3));
        } else if ($difference >= 300 && $difference <= 365) {
            return self::ConvertFormat(self::ConvertCarbon($date)->addMonths(12));
        } else {
            return false;
        }
    }

    public static function filteBookingCollection($booking_collection) {
        if ($booking_collection->isNotEmpty()) {
            foreach ($booking_collection as $booking_key => $booking) {
                if ($booking->getUser->getCars->where('status', 1)->where('car_trim_id', $booking->cartrim_id)->isEmpty()) {
                    unset($booking_collection[$booking_key]);
                }
            }
        }
        return $booking_collection;
    }

    public static function getUserBookingQuoted() {
        $results = DB::select("SELECT * FROM `bookings` WHERE `status` = 3 AND parts_cost != '0.00' AND labour_cost != '0.00' AND price != '0.00' AND updated_at >= (CURRENT_DATE - INTERVAL 3 DAY )");
        $bookings = Booking::hydrate($results);
        return $bookings;
    }

}
