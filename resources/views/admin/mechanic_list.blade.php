
<!-- Modal - Assign Mechanic Service-->
<form class="form-horizontal" id='form_add_assignmechanic' method='post' action='{{URL('admin/bookings/assign-mechanic')}}'>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Mechanic (Booking Id : {{$booking->id}})</h4>
    </div>
    <div class="modal-body modal-font">
        <div class="form-group car_id ">
            <h4 class="text-center"><strong>{{$booking->getUser->name}}</strong> wants a booking to be scheduled on date <strong>{{ TimeZone::getShortFormatedDate($booking->schedule_date).' '.$booking->schedule_start_time}}</strong></h4>
            <label class="control-label col-sm-3 " for="brand">Mechanic :</label>
            <div class="col-sm-6">
                <select class="form-control" name = 'mechanic_id' id='mechanic_id' >
                    <option value=''>Select Mechanic</option>
                    @if(count($mechanics)>0)
                    @foreach($mechanics as $mechanic)    
                    @if( $mechanic_id != $mechanic->id )
                    <option value='{{ $mechanic->id }}' >{{ $mechanic->name }}</option>
                    @else
                    <option value='{{ $mechanic->id }}' selected='true'>{{ $mechanic->name }}</option>
                    @endif
                    @endforeach
                    @endif
                </select>
                {{ csrf_field()}}
                <input type="hidden" name="time_format" id="time_format" value='{{ env('DATE_TIME_UI_FORMAT')}}' />
                <input type="hidden" name="booking_id" id="booking_id" value='{{ $booking->id }}' />
                <input type="hidden" class='actual-time' id='server-time' value="{{$actual_time}}"/>
                <input type="hidden" name="mec_booked_from" id="mec_booked_from" value='{{TimeZone::getShortFormatedDate($booking->schedule_start_time)}}' />
                <input type="hidden" name="mec_booked_to" id="mec_booked_to" value='{{ $booked_mechanic->isEmpty() ? '' : TimeZone::getShortFormatedDate($booked_mechanic[0]->booked_to) }}' />
            </div>            
            <br/><br/> 
            <label class="control-label col-sm-3 " for="brand">Date :</label>
            <div class="col-md-6 ">
                <input type='text' class="form-control datetimepicker" value="{{ TimeZone::getShortFormatedDate($booking->schedule_date) }}" />   
            </div>  
            <br/><br/>     
            <div class="modal-body schedule-availability">
                <div class="loader"></div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div class='row'>
            <div class='text-center modal_btn'>
                <button type="submit" class="btn btn-success" id="assignmechanic">Assign Mechanic</button>
                <button type="button" class="btn btn-info re-set-time">Re-Set Datetime</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                <img src='{{ asset('images/spin.gif')}}' id='Assign_mechanic_spinner'class='spinner'>
            </div>
        </div>
    </div>
</form>