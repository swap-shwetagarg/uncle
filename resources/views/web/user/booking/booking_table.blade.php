@inject('bookingStatus', 'App\Utility\BookingStatus')
<div class="user-booking-table">
    @if(!$bookings->isEmpty())
    <div class="my_col_data_heading">
        <div class="row">
            <div class="my_col_10">Booking ID</div>
            <div class="my_col_20">Car </div>
            <div class="my_col_20">Req./Sch. Date </div>
            <div class="my_col_20">Service Location</div>
            <div class="my_col_10">Status</div>
            <div class="my_col_10">Price </div>
            <div class="my_col_15">Mechanic </div>
            <div class="my_col_20">Action</div>
        </div>
    </div>
    @endif
    <div class="my_col_data">
        @forelse($bookings as $key=>$booking)
        <div class="row {{$booking->status == 9 ? 'text-cancelled' : ''}}">
            <div class="my_col_10">
                <label class="first">Booking ID: </label> 
                <label class="sec">{{$booking->id}}</label>
            </div>
            <div class="my_col_20">
                <label>Car: </label>
                <label class="sec">
                    {{$booking->carTrim->carmodel->years->year}}
                    {{$booking->carTrim->carmodel->years->cars->brand}}                
                    {{$booking->carTrim->carmodel->modal_name}}
                </label>
            </div>
            @if(($booking->status == 1 || $booking->status == 8 || $booking->status == 6) && isset($booking->bookingMechanic))
            <div class="my_col_20">
                <label>Req./Sch. Date: </label>
                <label class="sec">{{ TimeZone::getFormattedTimeofString($booking->bookingMechanic->booked_from)}}</label>
            </div>
            @elseif($booking->status == 1)
            <div class="my_col_20 text-{{ strtolower($bookingStatus::getKeys($booking->status))}}">
                <label>Req./Sch. Date: </label>
                <label class="sec">{{ TimeZone::getShortFormatedDate($booking->schedule_date).' '.$booking->schedule_start_time}}</label>
            </div>
            @else
            <div class="my_col_20">
                <label>Req./Sch. Date: </label>
                <label class="sec">{{ TimeZone::getShortFormatedDate($booking->date_time)}}</label>
            </div>
            @endif
            
            <div class="my_col_20">
                <label>Service Location: </label>
                <label class="sec">
                    @if($booking->getZipCode)
                    {{ $booking->getZipCode->zip_code }}
                    @else
                    -
                    @endif
                </label>
            </div>
            
            <div class="my_col_10">
                <label>Status: </label>
                <label class="sec">
                    <span class="text-{{ strtolower($bookingStatus::getKeys($booking->status))}}">{{ strtolower($bookingStatus::getKeys($booking->status))}}</span>
                </label>
            </div>
            <div class="my_col_10">
                <label>Price: </label>
                <label class="sec">
                    @if($booking->price && $booking->price != '0.00')
                    {{ '&#x20B5;'.$booking->price }}<br/>
                    <?php
                    $service_cost = (float) $booking->price;
                    $vat_cost = (float) $booking->vat_cost;
                    $vat_tax_100 = ($vat_cost * 100);
                    $vat_tax_percentage = ($vat_tax_100 / $service_cost);
                    echo "(+".$vat_tax_percentage."% VAT)";
                    ?>
                    <!-- (+{{ $vat_tax }}% VAT) -->
                    @else
                    {{ '-' }}
                    @endif
                </label>
            </div>
            <div class="my_col_15">
                <label>Mechanic: </label>
                <label class="sec">
                    @if($booking->bookingMechanic)
                    <a data-container="body" href="void(0)" class="load-mechanic-profile" data-html="true" title="Mechanic Detail" data-trigger="focus" 
                       data-placement="top" data-url="/user/mechanic-profile/{{ $booking->bookingMechanic->mechanic->id}}">
                        {{$booking->bookingMechanic->mechanic->name}}
                    </a>
                    @else
                    -
                    @endif
                </label>
            </div>
            <div class="my_col_20">
                <label>Action: </label>
                <label class="sec">
                    <a class="btn btn-info btn-sm load-booking-detail" data-toggle="modal" data-target="#modal-lg" data-url="/user/bookings/{{$booking->id}}">
                        <i class="fa fa-eye" aria-hidden="true"></i>
                    </a>
                    @if(($booking->status == 4 || $booking->status == 3) && ($booking->status != 9))
                    <button class="btn btn-danger btn-sm delete_booking" data-toggle="modal" id="delete_booking" title="Delete" data-booking_id='{{ $booking->id }}' data-status="{{ $booking->status }}"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                    @endif

                    @if($booking->status==3 && ($booking->status != 9))
                    <a class="btn btn-success btn-sm hidden-xs hidden-sm" href="/user/booking/schedule-booking/{{$booking->id}}" data-bookingid="{{$booking->id}}">Book</a>
                    @endif

                    @if((Auth::user()->email != null || Auth::user()->email !="") && $booking->status == 10)
                    <button class="btn btn-danger btn-sm btn-labeled req-a-quote hidden-xs hidden-sm" data-booking_id="{{$booking->id}}" title="Request a Quote" >Request a Quote</button>                    
                    @endif

                    @if($booking->status == 1 && !$booking->bookingMechanic && ($booking->status != 9))
                    <a href="/user/booking/schedule-booking/{{$booking->id}}" data-bookingid="{{$booking->id}}" class="btn btn-info btn-sm hidden-xs hidden-sm">Re-Schedule Now</a>
                    @endif

                    @if($booking->status == 6 && !$booking->bookingMechanicRating && ($booking->status != 9))
                    <a href="/user/rate-mechanic/{{$booking->bookingMechanic->mechanic->id}}/{{$booking->id}}" class="btn btn-info btn-sm hidden-xs hidden-sm">Rate-Mechanic</a>
                    @endif    

                    @if($booking->status == 1 || ($booking->status == 8 && ((strtotime($booking->bookingMechanic->booked_from)-strtotime(date("Y-m-d H:m A")))/3600>4)))                    
                    <button class="btn btn-danger btn-sm btn-labeled cancel_booking hidden-xs hidden-sm" title="Cancel" data-booking_id='{{ $booking->id }}' data-status="{{ $booking->status }}">Cancel</button>
                    @endif

                </label>
            </div>
            <div class="col-md-12 mobile-actions text-center hidden-lg hidden-md">
                @if($booking->status==3 && ($booking->status != 9))
                <a class="btn btn-success btn-lg btn-custom" href="/user/booking/schedule-booking/{{$booking->id}}" data-bookingid="{{$booking->id}}">Book</a>
                @endif

                @if((Auth::user()->email != null || Auth::user()->email !="") && $booking->status == 10)
                <button class="btn btn-danger btn-sm btn-labeled req-a-quote btn-custom" data-booking_id="{{$booking->id}}" title="Request a Quote" >Request a Quote</button>                    
                @endif

                @if($booking->status == 1 && !$booking->bookingMechanic && ($booking->status != 9))
                <a href="/user/booking/schedule-booking/{{$booking->id}}" data-bookingid="{{$booking->id}}" class="btn btn-info btn-sm btn-custom">Re-Schedule Now</a>
                @endif

                @if($booking->status == 6 && !$booking->bookingMechanicRating && ($booking->status != 9))
                <a href="/user/rate-mechanic/{{$booking->bookingMechanic->mechanic->id}}/{{$booking->id}}" class="btn btn-info btn-sm btn-custom">Rate-Mechanic</a>
                @endif    

                @if($booking->status == 1 || ($booking->status == 8 && ((strtotime($booking->bookingMechanic->booked_from)-strtotime(date("Y-m-d H:m A")))/3600>4)))                    
                <button class="btn btn-danger btn-sm btn-labeled cancel_booking btn-custom" title="Cancel" data-booking_id='{{ $booking->id }}' data-status="{{ $booking->status }}">Cancel</button>
                @endif
            </div>
        </div>
        @empty
        <div class="alert alert-info">No Booking found under this!</div>
        @endforelse
        
        @if(isset($bookings) && $bookings && $bookings->isNotEmpty() && $bookings->links() && $bookings->links() != '')
        <div class="row">
            <div class="col-md-12" align="center">
                <nav class="pagination booking"> {{ $bookings->links() }} </nav>
            </div>
        </div>
        @endif
        <div class="row">
            <div class="col-md-12" align="center">
                Total Records: {{ $bookings->total() }}
            </div>
        </div>
    </div>
</div>
