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
use App\Booking;
use Hamcrest\Type\IsInteger;
use phpDocumentor\Reflection\Types\Integer;


class GetNextBooking extends Helpers
{
    public static function ConvertFormat(Carbon $data)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $data)->format('d-m-Y');
    }

    public static function CaluculateDiffer(Booking $date)
    {
        $created_at = self::ConvertCarbon($date);
        $now = Carbon::now();
        $difference = $created_at->diffInDays($now);
        return $difference;
    }

    public static function CaluculateNextDate(Booking $date)
    {
        $difference = self::CaluculateDiffer($date);
        if($difference === 80 || $difference === 85 || $difference === 90) {
            return self::ConvertFormat(self::ConvertCarbon($date)->addMonths(3));
        }else if($difference === 350 || $difference === 360 || $difference === 364){
            return self::ConvertFormat(self::ConvertCarbon($date)->addMonths(12));
        }else{
            return false;
        }
    }

    public static function ConvertCarbon(Booking $date)
    {
        return new Carbon($date->date_time);
    }

    public static function getUsers()
    {
        $users = User::all();
        if(count($users)>0) {
            foreach ($users as $user) {
                $cars[] = $user->getCars;
                foreach ($cars as $car) {
                    if (count($car) > 0) {
                        foreach ($car as $item) {
                            $dates = Booking::ofBooking($item)->status()->get();
                        }
                    }
                }
            }
        }

        return $dates;
    }
    
    public static function getAuthNextBooking()
    {
        $users = Auth::user();
        if(count($users)>0)
        {
            $cars[] = $users->getCars;
            foreach ($cars as $car) {
                if (count($car) > 0) {
                    foreach ($car as $item) {
                        $dates = Booking::ofBooking($item)->status()->get();
                    }
                }
            }
        }

        if(isset($dates) && count($dates) > 0)
        {
            foreach($dates as $date)
            {
                $nextDate[] = self::CaluculateNextDate($date);
            }
            return $nextDate;
        }
        return false;
    }
}