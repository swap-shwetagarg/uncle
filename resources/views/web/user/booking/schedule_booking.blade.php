@extends('layouts.admin')

@section('title', 'Schedule Bookings | Uncle Fitter')

@section('content')
<div class="wrapper">
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-bd">
                        <div class="panel-heading">
                            <div class="panel-title">                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4>Schedule Bookings</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" class='booking-id' data-booking_id="{{$booking_id}}"/>
                        <input type="hidden" class='actual-time' id='server-time' value="{{$actual_time}}"/>
                        <div class="panel-body my-bookings">
                            <div class="col-md-12 col-md-12">
                                <div class="panel panel-bd">
                                    <div class="panel-body">
                                        <!-- calender -->
                                        <div id='calendar'></div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <form id='form_book_schedule' method='post' data-url='{{ URL('/user/booking/schedule-booking') }}'> 
                            <div class="modal fade" id="schedule-booking-modal" tabindex="-1" role="dialog">                            
                                <div class="modal-dialog modal-md" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                            <h3 class="modal-title">Schedule Booking</h3>
                                        </div>
                                        <div class='row text-center col-md-12 col-md-offset-0 modal-body modal-font'>
                                            <h4>Please select the time and location for this booking.</h4>       
                                            <input type="hidden" name="time_format" id="time_format" value='{{ env('DATE_TIME_UI_FORMAT')}}' />
                                            <h2 class="booking-date" ></h2>
                                            <div class="modal-body schedule-availability">
                                                <div class="loader"></div>
                                            </div>
                                            <div class="modal-body booking-address hidden"></div>
                                            @if(isset($booking_status) && $booking_status != 1)                                            
                                            <?php
                                            $vat_tax_price = ($booking_price * $vat_tax) / 100;
                                            $total_price = $booking_price + $vat_tax_price;
                                            ?>
                                            <div class="col-sm-12" >     
                                                <div class="col-sm-8 text-left">Service Amount</div>
                                                <div class="col-sm-4 text-right">&#x20B5;&nbsp;{{number_format($booking_price,2)}}</div>
                                                <div class="col-sm-8 text-left">VAT {{ $vat_tax }}%</div>
                                                <div class="col-sm-4 text-right">&#x20B5;&nbsp;{{number_format($vat_tax_price,2)}}</div>
                                                <div class="col-sm-8 text-left">Redeem from referral</div>
                                                <div class="col-sm-4 text-right">&#x20B5;&nbsp;{{number_format($redeem_amount,2)}}</div>
                                                <h4><div class="col-md-8 text-left">Amount to be Paid </div>
                                                    <div class="col-md-4 text-right FontLarger"><strong>&#x20B5;&nbsp;{{number_format($total_price-$redeem_amount,2)>0 ? number_format($total_price-$redeem_amount,2) : 0 }} </strong></div></h4>
                                                <hr class="col-lg-11"/>
                                                @if(number_format($total_price-$redeem_amount,2)>0)
                                                <div class="i-check col-md-6">
                                                    <input tabindex="19" type="radio" id="radio-pay-now-exp" checked name="line-radio" data-url="{{ URL('/user/check-for-express-pay/') }}" data-pay="Exp">
                                                    <label for="radio-pay-now">Pay Via Express-Pay </label> 
                                                </div>
                                                <div class="i-check col-md-6">
                                                    <input tabindex="20" type="radio" id="radio-cash-on-delivery" name="line-radio" >
                                                    <label for="radio-cash-on-delivery">Cash On Site</label>
                                                </div>                        
                                                @endif
                                            </div>
                                            @endif
                                            <input type="hidden" class='booking_status' data-status ="{{(isset($booking_status)) ? $booking_status : 0}}">
                                        </div>                                    
                                        <div class="modal-footer">
                                            <div class='row'>
                                                <div class='col-sm-8 modal_btn'>
                                                    <button type="submit" class="btn btn-info">Save Schedule</button>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> 
                                                </div>
                                                <img src='{{ asset('images/spin.gif')}}' class='spinner' id="schedule-timer-spinner">
                                            </div>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div>
                            {{ csrf_field()}}  
                        </form>
                    </div>
                </div>
            </div>
    </div>
</div><!--<div class="col-md-12  text-center" >    
                                                    <div class="i-check col-md-6" >
                                                        <input tabindex="19" type="radio" id="radio-pay-now-sly" name="line-radio" checked data-url="/user/che-ck-pay-ment/" data-pay="Sly">
                                                        <label for="radio-pay-now" >Pay Via Slyde-Pay </label> 
                                                    </div>
                                                </div>-->
@endsection

