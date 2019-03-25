<?php

namespace App\Repositories\BookingMechanic;

use App\Repositories\BookingMechanic\BookingMechanicInterface as BookingMechanicInterface;
use Illuminate\Support\Facades\Log;
use App\Models\BookingMechanic;
use App\Models\Booking;
use DB;
use App\User;

class BookingMechanicRepository implements BookingMechanicInterface {

    protected $bookingMechanic;
    protected $booking;

    public function __construct(BookingMechanic $bookingMechanic,Booking $booking) {
        $this->bookingMechanic = $bookingMechanic;
        $this->booking = $booking;
    }

    /**
     * Get all instance of BookingItems.
     *
     * @return \Illuminate\Database\Eloquent\Collection|\App\BookingItems[]
     */
    public function findAll() {
        return $this->bookingMechanic->paginate(15);
    }

    /**
     * Find an instance of BookingItems with the given ID.
     *
     * @param  int  $id
     * @return \App\BookingItems
     */
    public function find($id) {
        return $this->bookingMechanic->find($id);
    }

    /**
     * Create a new instance of BookingItems.
     *
     * @param  array  $attributes
     * @return \App\BookingItems
     */
    public function create(array $attributes = []) {
        try {
            return $this->bookingMechanic->insert($attributes);
        } catch (\Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);

            throw $ex;
        }
    }

    /**
     * Update the BookingItems with the given attributes.
     *
     * @param  int    $id
     * @param  array  $attributes
     * @return bool|int
     */
    public function update(array $attributes = [], $id) {
        try {
            return $this->bookingMechanic->findOrFail($id)->update($attributes);
        } catch (\Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);
            dd($ex);
            throw $ex;
        }
    }

    /**
     * Delete an entry with the given ID.
     *
     * @param  int  $id
     * @return bool|null
     * @throws \Exception
     */
    public function destroy($id) {
        try {
            return $this->bookingMechanic->findOrFail($id)->delete();
        } catch (\Exception $ex) {
            Log::useDailyFiles(storage_path() . '/logs/debug.log');
            Log::error(['Request' => $ex->getMessage()]);

            throw $ex;
        }
    }

    public function getBookingMechanicById($booking_id) {
        return $this->bookingMechanic->select('id', 'booking_id', 'mechanic_id','booked_from', 'booked_to','mech_response')
                        ->whereBooking_id($booking_id)
                        ->get();
        
        //return $this->booking->find($booking_id)->bookingMechanic;
    }

    public function isMechanicAvailable($mechanic_id, $booking_id, $start_date, $end_date) {
        $results = DB::select('SELECT u.*    
                                From users u
                                    Inner Join role_user ur on u.id = ur.user_id
                                    Left Join booking_mechanic bm on bm.mechanic_id = u.id
                                Where ur.role_id =3                                    
                                    And u.verified = 1
                                    And bm.mechanic_id = ?
                                    And bm.booking_id <> ?
                                    And
                                        (
                                            ( ? BETWEEN booked_from And booked_to) 
                                         Or ( ? BETWEEN booked_from And booked_to) 
                                         Or ( ? <= booked_from And ? >= booked_to) 
                                         Or ( ? >= booked_from And ? <= booked_to) 
                                         Or ( ? >= booked_from And ? <= booked_to)
                                         Or ( ? >= booked_from And ? <= booked_to)
                                        )'
                        , array($mechanic_id,$booking_id,$start_date, $end_date,$start_date, $end_date,$start_date,$end_date,$start_date,$start_date,$end_date,$end_date));          
        return $results;            
    }
    
    public function getAvailableTimes($date)
    {
         $results = DB::select("Select 
            GROUP_CONCAT(id),
            sum(A) A,
            sum(B) B,
            sum(C) C,
            sum(D) D,
            sum(E) E,
            sum(F) F
     From 
     (	select us.id as id,
            COALESCE(temp4.A,1) as A,
            COALESCE(temp4.B,1) as B,
            COALESCE(temp4.C,1) as C,
            COALESCE(temp4.D,1) as D,
            COALESCE(temp4.E,1) as E,
            COALESCE(temp4.F,1) as F
        from users us
        Inner Join role_user ru on ru.user_id = us.id and ru.role_id = 3
        Left Join
            (
             Select temp3.id,
                COALESCE(sum(A),1) as A,
                COALESCE(sum(B),1) as B,
                COALESCE(sum(C),1) as C,
                COALESCE(sum(D),1) as D,
                COALESCE(sum(E),1) as E,
                COALESCE(sum(F),1) as F
               From 
                (
                Select temp2.id,
                    (case when temp2.booked_time = '07:00:00' Then 0 end ) as A,
                    (case when temp2.booked_time = '09:00:00' Then 0 end ) as B,
                    (case when temp2.booked_time = '11:00:00' Then 0 end ) as C,
                    (case when temp2.booked_time = '13:00:00' Then 0 end ) as D,
                    (case when temp2.booked_time = '15:00:00' Then 0 end ) as E,
                    (case when temp2.booked_time = '17:00:00' Then 0 end ) as F    
                 From
                    (
                        Select distinct u.id,temp.booked_time From users u
                        Inner Join  
                            (
                                SELECT mechanic_id,DATE_FORMAT(booked_from, '%H:%i:%s') booked_time FROM booking_mechanic
                                Inner Join bookings on  bookings.id = booking_mechanic.booking_id
                                Where ((booked_from BETWEEN ? And ?) And bookings.status <> 9)
                            )temp 
                        On u.id =temp.mechanic_id
                        Order by u.id, temp.booked_Time ASC
                    )temp2
                )temp3
                Group by temp3.id
             )temp4
            on us.id = temp4.id
         )Final "
                        , array($date.' 00:00:00',$date.' 23:59:59'));  
        return $results;
    }
    
    public function getAvailableTimesByMechanicId($id,$date)
    {
        $results = DB::select("select us.id as id,
                                        COALESCE(temp4.A,1) as A,
                                        COALESCE(temp4.B,1) as B,
                                        COALESCE(temp4.C,1) as C,
                                        COALESCE(temp4.D,1) as D,
                                        COALESCE(temp4.E,1) as E,
                                        COALESCE(temp4.F,1) as F
                                    from users us
                                    Inner Join role_user ru on ru.user_id = us.id and ru.role_id = 3
                                    Left Join
                                        (
                                         Select temp3.id,
                                            COALESCE(sum(A),1) as A,
                                            COALESCE(sum(B),1) as B,
                                            COALESCE(sum(C),1) as C,
                                            COALESCE(sum(D),1) as D,
                                            COALESCE(sum(E),1) as E,
                                            COALESCE(sum(F),1) as F
                                           From 
                                            (
                                            Select temp2.id,
                                                (case when temp2.booked_time = '07:00:00' Then 0 end ) as A,
                                                (case when temp2.booked_time = '09:00:00' Then 0 end ) as B,
                                                (case when temp2.booked_time = '11:00:00' Then 0 end ) as C,
                                                (case when temp2.booked_time = '13:00:00' Then 0 end ) as D,
                                                (case when temp2.booked_time = '15:00:00' Then 0 end ) as E,
                                                (case when temp2.booked_time = '17:00:00' Then 0 end ) as F    
                                             From
                                                (
                                                    Select distinct u.id,temp.booked_time From users u
                                                    Inner Join  
                                                        (
                                                            SELECT mechanic_id,DATE_FORMAT(booked_from, '%H:%i:%s') booked_time FROM booking_mechanic
                                                            Inner Join bookings on  bookings.id = booking_mechanic.booking_id
                                                            Where ((booked_from BETWEEN ? And ?) And bookings.status <> 9)
                                                        )temp 
                                                    On u.id =temp.mechanic_id
                                                    Order by u.id, temp.booked_Time ASC
                                                )temp2
                                            )temp3
                                            Group by temp3.id
                                         )temp4
                                        on us.id = temp4.id
                                     Where us.id = ? "
                        , array($date.' 00:00:00',$date.' 23:59:59',$id));  
        return $results;
    }
    
    public function getAllNonRejectedMechanic($id) {
         $results = DB::select('select * From users u
                                Inner join role_user ru on ru.user_id = u.id
                                Where ru.role_id = 3 And u.verified =1 And u.approved = 1
                                    And u.id not in(
                                                        select bm.mechanic_id 
                                                        From booking_mechanic bm 
                                                        Where bm.booking_id = ? And bm.mech_response =0)'
                    , array($id));
        return $results;
    }
    
    public function getDefaultTimes(){
         $results = DB::select('select 0 as A,0 as B,0 as C,0 as D,0 as E,0 as F');
        return $results;
    }
}
