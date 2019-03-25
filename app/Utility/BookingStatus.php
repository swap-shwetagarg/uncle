<?php

namespace App\Utility;

class BookingStatus extends BaseEnum {

    const PROGRESSING = 1;
    const CONFIRMED = 2;
    const QUOTED = 3;
    const PENDING = 4;
    const DELETED = 5;
    const COMPLETED = 6;
    const ALL = 7;
    const SCHEDULED = 8;
    const CANCELLED = 9;
    const SAVED = 10;
    const QUOTATION = 11;
    const APPOINTMENT = 12;
}
