<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use App\User;
use App\Role;
use App\Models\UserRole;
use App\Utility\BookingStatus;
use Carbon\Carbon;
use Event;
use App\Helpers\UpcomingBookings;
use App\Events\AlertNotificationToUserForHoliday;

class KeepAlertUserForHoliday extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Alert:UsersHoliday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dear esteemed customers, please note that we would be unavailable on the 25th and 26th of Dec as well as the 1st of January for the holidays. Thanks and happy Holidays to you all!';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        /*
        $current_date = date('d-m-Y');
        $date_array = ['25-12-2020', '26-12-2020', '01-01-2020'];
        foreach ($date_array as $key => $date) {
            if( strtotime($date) == strtotime($current_date) ) {
                */

        $userRoles = UserRole::where('role_id', '1')->get();
        foreach ($userRoles as $key => $userRole) {
            $user_id = $userRole->user_id;
            $user = User::find($user_id);
            $userDevices = $user->getDevice;
            $role = $user->getRole->first();
            Event::fire(new AlertNotificationToUserForHoliday($user));
        }
        /*
        $users = User::find(3)->get();
        dd($users);
        //$users = User::all();
        if (count($users) > 0) {
            foreach ($users as $user) {
                $this->info('Alert:UsersHoliday'.$user);
                dd();
                // $this->info('Alert:UsersHoliday'.$user->getDevice);
                // $this->info('Alert:UsersHoliday'.$user->getRole->first());
                // $this->info('Alert:UsersHoliday Cummand Run successfully!'.$user->getDevice);

                //$booking = new Booking($booking->toArray());
                //Event::fire(new AlertNotificationToUserForHoliday($user));
            }
        }
        */
            /*
            }
        }
        */
        /*
        $role = \App\Role::where('name', '=', 'user')->get();
        $user_role = \App\Role::find($role[0]['id']);
        $users = $user_role->user()->get();
        */
    }

}
