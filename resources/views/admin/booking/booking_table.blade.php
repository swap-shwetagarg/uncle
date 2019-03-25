@inject('bookingStatus', 'App\Utility\BookingStatus')
<div class="user-booking-table">
    <div class="my_col_data_heading">
        <div class="row">
            <div class="my_col_10">Booking ID</div>
            <div class="my_col_10">Car </div>
            <div class="my_col_10">User Name</div>
            <div class="my_col_20">Req./Sch. Date </div>
            <div class="my_col_10">Status</div>
            <div class="my_col_10">Mechanic </div>
            <div class="my_col_10">Service Location</div>
            <div class="my_col_10">Price </div>
            <div class="my_col_10">Action</div>
        </div>
    </div>
    <div class="my_col_data">
        @if(isset($bookings) && $bookings && !$bookings->isEmpty())
        @foreach($bookings as $key=>$booking)        
        <div class="row {{$booking->status == 9 ? 'text-cancelled' : ''}}">        
            <div class="my_col_10">
                <label class="first">Booking ID: </label> 
                <label class="sec">{{$booking->id}}</label>
            </div>
            <div class="my_col_10">
                <label>Car: </label> 
                <label class="sec">
                    {{$booking->carTrim->carmodel->years->cars->brand}}
                    {{$booking->carTrim->carmodel->years->year}}
                    {{$booking->carTrim->carmodel->modal_name}}
                </label>
            </div>
            <div class="my_col_10">
                <label>User Name: </label>
                <label class="sec">
                    <a data-container="body" href="javascript:void(0);" class="show-user-profile" data-toggle="popover" data-html="true" 
                       title="User Detail" data-placement="top" data-trigger='click'
                       data-content='<div class="popover-menu" id="popTask">
                       <div class="row">
                       <div class="col-sm-3"><strong>Name:</strong></div>
                       <div class="col-sm-9">{{$booking->getUser->name}}</div>
                       </div>
                       <div class="row">
                       <div class="col-sm-3"><strong>Email:</strong></div>
                       <div class="col-sm-9">{{$booking->getUser->email}}</div>
                       </div>
                       <div class="row">
                       <div class="col-sm-3"><strong>Phone:</strong></div>
                       <div class="col-sm-9">{{$booking->getUser->mobile_country_code}} {{$booking->getUser->mobile}}</div>
                       </div>
                       </div>'>
                        {{$booking->getUser->name}}
                    </a>
                </label>
            </div>
            @if(($booking->status == 1 || $booking->status == 8 || $booking->status == 6) && isset($booking->bookingMechanic) )
            <div class="my_col_20">
                <label>Req./Sch. Date: </label> 
                <label class="sec"><strong>{{ TimeZone::getFormattedTimeofString($booking->bookingMechanic->booked_from)}}</strong></label>
            </div>
            @elseif($booking->status == 1)
            <div class="my_col_20 text-{{ strtolower($bookingStatus::getKeys($booking->status))}}">
                <label>Req./Sch. Date: </label> 
                <label class="sec">{{ TimeZone::getShortFormatedDate($booking->schedule_date).' '.$booking->schedule_start_time}}</label>
            </div>
            @else
            <div class="my_col_20">
                <label>Req./Sch. Date: </label>
                <label class="sec">{{ date('d/m/Y g:i A', strtotime($booking->date_time)) }}</label>
            </div>
            @endif
            <div class="my_col_10">
                <label>Status: </label>
                <label class="sec">
                    <span class="text-{{ strtolower($bookingStatus::getKeys($booking->status))}}">
                        {{ strtolower($bookingStatus::getKeys($booking->status))}}
                    </span>
                </label>
            </div>
            <div class="my_col_10">
                @if($booking->bookingMechanic)
                <?php 
                $profile_link = '';
                $profile_link = url('admin/user/mechanic/'.$booking->bookingMechanic->mechanic->id);
                ?>
                <label>Mechanic: </label>
                <label class="sec">
                    <a data-container="body" href="javascript:void(0);" class="show-mechanic-profile" data-toggle="popover" data-html="true" 
                       title="Mechanic Detail" data-placement="top" data-trigger='click'
                       data-content='<div class="popover-menu" id="popTask">
                       <div class="row">
                       <div class="col-sm-3"><strong>Name:</strong></div>
                       <div class="col-sm-9">{{$booking->bookingMechanic->mechanic->name}}</div>
                       </div>
                       <div class="row">
                       <div class="col-sm-3"><strong>Email:</strong></div>
                       <div class="col-sm-9">{{$booking->bookingMechanic->mechanic->email}}</div>
                       </div>
                       <div class="row">
                       <div class="col-sm-3"><strong>Phone:</strong></div>
                       <div class="col-sm-9">{{$booking->bookingMechanic->mechanic->mobile_country_code}} {{$booking->bookingMechanic->mechanic->mobile}}</div>
                       </div>
                       <div class="row">
                       <div class="col-sm-3"></div>
                       <div class="col-sm-9"><a href="{{ $profile_link }}">View Full Profile</a></div>
                       </div>
                       </div>'>
                        {{$booking->bookingMechanic->mechanic->name}}
                    </a>
                </label>
                @else
                <label>Mechanic: </label>
                <label class="sec">-</label>
                @endif
            </div>
            
            <div class="my_col_10">
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
            <div class="my_col_10">
                <label>Action: </label>
                <label class="sec">
                    <a class="btn btn-info btn-sm load-booking-detail" data-toggle="modal" data-target="#modal-lg" data-url="{{ URL('/admin/bookings') }}/{{$booking->id}}">
                        <i class="fa fa-eye" aria-hidden="true"></i></a>
                </label>
                <label class="sec">
                    @if($booking->status == 1 && $booking->status != 9)
                    <a class="btn btn-info btn-sm load-mechanic-list" data-toggle="modal" data-target="#modal-md" data-url="{{ URL('/admin/bookings/get-mechanic') }}/{{$booking->id}}/0/{{$booking->zipcode_id}}">
                        Assign Mechanic
                    </a>
                    @endif
                    @if(($booking->status == 8) && $booking->bookingMechanic && $booking->bookingMechanic->mech_response!=1 && $booking->status != 9)
                    <a class="btn btn-info btn-sm load-mechanic-list" data-toggle="modal" data-target="#modal-md" data-url="{{ URL('/admin/bookings/get-mechanic') }}/{{$booking->id}}/{{ ($booking->bookingMechanic) ? $booking->bookingMechanic->mechanic_id : 0}}/{{$booking->zipcode_id}}">
                        Change Mechanic
                    </a>
                    @endif
                    @if(($booking->status == 4 || $booking->status == 3) && ($booking->status != 9))
                        <button class="btn btn-danger btn-sm delete_booking" data-toggle="modal" id="delete_booking" title="Delete" data-booking_id='{{ $booking->id }}' data-status="{{ $booking->status }}"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                    @endif
                    @if($booking->status == 1 || $booking->status == 8 )                    
                        <button class="btn btn-danger btn-sm btn-labeled cancel_booking hidden-xs hidden-sm" title="Cancel" data-booking_id='{{ $booking->id }}' data-status="{{ $booking->status }}">Cancel</button>
                    @endif
                </label>
            </div>            
        </div>
        @endforeach
        @else
        <div class="row">
            <div class="col-md-12" align="center">
                <div class="alert alert-info">No Booking found under this!</div>
            </div>
        </div>
        @endif

        @if(isset($bookings) && $bookings && !$bookings->isEmpty() && $bookings->links() && $bookings->links() != '')
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