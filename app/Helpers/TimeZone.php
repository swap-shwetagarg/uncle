<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Helpers;
use DateTime;
use DateTimeZone;
class TimeZone extends Helpers
{
    public static function getEpochfromTime($date_time)
    {
        date_default_timezone_set('UTC');        
        return strtotime($date_time);
    }
    public static function getTimefromEpoch($epoch_time)
    {
        $TimeZoneNameFrom = 'UTC';         
        $TimeZoneNameTo = date_default_timezone_get();
        $dt = new DateTime((new DateTime("@$epoch_time"))->format(env('DATE_TIME_FORMAT')), new DateTimeZone($TimeZoneNameFrom));
        return $dt->setTimezone(new DateTimeZone($TimeZoneNameTo))->format(env('DATE_TIME_FORMAT'));
    }
    public static function getShortTimefromEpoch($epoch_time)
    {
        $TimeZoneNameFrom = 'UTC';         
        $TimeZoneNameTo = date_default_timezone_get();
        $dt = new DateTime((new DateTime("@$epoch_time"))->format(env('DATE_TIME_SHOT_FORMAT')), new DateTimeZone($TimeZoneNameFrom));        
        return $dt->setTimezone(new DateTimeZone($TimeZoneNameTo))->format(env('DATE_TIME_SHOT_FORMAT'));
    }
    public static function getFormatedTime($date)
    {        
        return $date->format(env('DATE_TIME_FORMAT'));
    }
    public static function getShortFormatedDate($date)
    {   $dt = new DateTime($date);
        return $dt->format(env('DATE_TIME_SHOT_FORMAT'));
    }
    public static function getFormattedTimeofString($date = null)
    {
       if(isset($date))
       {
            $dt = new DateTime($date);
            return $dt->format(env('DATE_TIME_FORMAT'));  
       }
         
    }
}