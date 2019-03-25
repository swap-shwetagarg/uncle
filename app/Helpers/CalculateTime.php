<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Helpers;

use Carbon\Carbon;
use App\Models\Booking;
use Illuminate\Http\Request;

/**
 * Description of CalculateTime
 *
 * @author vishal
 */
class CalculateTime extends Helpers
{
    public static function getTimeDiffer(Booking $booking)
    {
        return self::CaluculateDiffer($booking);
    }
    
    public static function CaluculateDiffer(Booking $booking)
    {
        $created_at_time = self::ConvertCarbon($booking);
        return $created_at_time->diffForHumans(Carbon::now());
    }
        
    public static function ConvertCarbon(Booking $booking)
    {   
        return new Carbon($booking->created_at);
    }
    
    public static function getLastFirst(Request $request)
    {
        $firstDate = new Carbon($request->date);
        
        $mon = $firstDate->month;    
        if($mon == 1 || $mon == 3 || $mon == 5 || $mon == 7 || $mon == 8 || $mon == 10 || $mon == 12)
        {
            $lastDate = new Carbon($request->date);
            $lastDate->addDays(30);
        }else if($mon == 4 || $mon == 6 || $mon == 9 || $mon == 11)
        {
            $lastDate = new Carbon($request->date);
            $lastDate->addDays(29);
        }
        else
        {
            $lastDate = new Carbon($request->date);
            $lastDate->addDays(27);
        }

        $firstDate = Carbon::createFromFormat('Y-m-d H:i:s', $firstDate)->format('Y-m-d H:i:s');
        $lastDate = Carbon::createFromFormat('Y-m-d H:i:s', $lastDate)->format('Y-m-d H:i:s');
        $date['firstDate'] = new Carbon($firstDate);
        $date['lastDate']= new Carbon($lastDate);
        
        return $date;    
    }
}
