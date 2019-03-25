<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;

class EventServiceProvider extends ServiceProvider {

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
        'App\Events\SendMail' => [
            'App\Listeners\SendMailFired',
        ],
        'App\Events\SendQuotedMail' => [
            'App\Listeners\SendQuotedMailFired',
        ],
        'App\Events\StatusLiked' => [
            'App\Listeners\PusherEventListener',
        ],
        'App\Events\BookingQuoted' => [
            'App\Listeners\BookingQuotedFire',
        ],
        'App\Events\ConfirmedBooking' => [
            'App\Listeners\ConfirmedBookingFired',
        ],
        'App\Events\AssignMechanic' => [
            'App\Listeners\AssignMechanicFire',
        ],
        'App\Events\MechanicConfirmation' => [
            'App\Listeners\MechanicConfirmationFired',
        ],
        'App\Events\BookingComplete' => [
            'App\Listeners\BookingCompleteFire',
        ],
        'App\Events\BookingCompletionToUser' => [
            'App\Listeners\BookingCompletionToUserFired',
        ],
        'App\Events\MechanicCreated' => [
            'App\Listeners\MechanicCreatedFired',
        ],
        'App\Events\MechanicApproved' => [
            'App\Listeners\MechanicApprovedFired',
        ],
        'App\Events\PaymentAlert' => [
            'App\Listeners\PaymentAlertFired',
        ],
        'App\Events\BookingCancelled' => [
            'App\Listeners\BookingCancelledFired',
        ],
        'App\Events\AlertNotificationToUser' => [
            'App\Listeners\AlertNotificationToUserFired',
        ],
        'App\Events\MechanicLocation' => [
            'App\Listeners\MechanicLocationFired',
        ],
        'App\Events\AlertMechanic' => [
            'App\Listeners\AlertMechanicFired',
        ],
        'App\Events\AlertNotificationToUserForSchedule' => [
            'App\Listeners\AlertNotificationToUserForScheduleFired',
        ],
        'App\Events\AlertNotificationToUserForHoliday' => [
            'App\Listeners\AlertNotificationToUserForHolidayFired',
        ],
    ];

    protected $subscribe = [
        'App\Listeners\UserEmailsFired',
    ];
    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot() {
        parent::boot();
    }

}
