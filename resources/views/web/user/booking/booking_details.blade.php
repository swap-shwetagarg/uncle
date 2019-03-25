<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    <h3 class="modal-title">Booking Details</h3>
</div>
<div class="panel panel-bd">
    <div class="panel-body">
        <div class="">
            {{ Form::hidden('booking_id', $booking->id, array('id' => 'booking-id')) }}
            @if(isset($booking->bookingItems) && $booking->bookingItems && !$booking->bookingItems->isEmpty())
            @foreach($booking->bookingItems as $bookingItem)
            <div class="row booking-service-details-row">
                <div class="col-md-12 col-xs-12 col-sm-12 booking-service-details">
                    <h4>
                        <strong>{{$bookingItem->getService->title}}</strong>
                    </h4>                    
                    @if(isset($bookingItem->bookingServiceSub) && $bookingItem->bookingServiceSub && !$bookingItem->bookingServiceSub->isEmpty())
                    <div class="sub-service-details">
                        <h5><strong>Service Options:</strong></h5>
                        @foreach($bookingItem->bookingServiceSub as $subSurvice)
                        @if(isset($subSurvice->getServiceSub) && $subSurvice->getServiceSub && isset($subSurvice->getServiceSub->display_text) && $subSurvice->getServiceSub->display_text)
                        <h6><strong>{{ $subSurvice->getServiceSub->display_text }}</strong></h6>
                        @endif
                        @if(isset($subSurvice->bookingSubOption) && $subSurvice->bookingSubOption && !$subSurvice->bookingSubOption->isEmpty())
                        <div class="sub-service-option-details">
                            @foreach($subSurvice->bookingSubOption as $option)
                            <i class="fa fa-check"></i> {{$option->getSubOption->option_name}}<br/>
                            @endforeach
                        </div>
                        @endif
                        @endforeach
                    </div>
                    @endif

                    @if($bookingItem->getService->description)                    
                    <div class="service-description">
                        <a class="service-description-booking-detail-link" href="javascript:void(0)">Show Description</a>
                        <div class="service-description-booking-detail">
                            <?php echo html_entity_decode($bookingItem->getService->description); ?>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
            @endif

            @if(isset($booking->own_service_description) && $booking->own_service_description && $booking->own_service_description != '')
            <div class="row booking-service-details-row">
                <div class="col-md-12 col-xs-12 col-sm-12 booking-service-details">
                    <h4><strong>Own Service Description</strong></h4>
                    <p>
                        {{ (isset($booking->own_service_description) && $booking->own_service_description) ? $booking->own_service_description : '' }}
                    </p>
                </div>
            </div>
            @endif

            <div class="row price-breakdown-row">
                @if($booking->parts_cost && $booking->parts_cost != 0.00 && $booking->labour_cost && $booking->labour_cost != 0.00)
                
                @if($booking->price && $booking->price != '0.00')
                <div class="price-breakdown-column">
                    <div class="col-md-9 col-sm-9 col-xs-9 text-left">
                        <strong>Parts Cost:</strong>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3 text-right">
                        &#x20B5; {{$booking->parts_cost}}
                    </div>
                </div>

                <div class="price-breakdown-column">
                    <div class="col-md-9 col-sm-9 col-xs-9 text-left">
                        <strong>Labour Cost:</strong>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3 text-right">
                        &#x20B5; {{$booking->labour_cost}}
                    </div>
                </div>

                <div class="price-breakdown-column sub-total-price">
                    <div class="col-md-9 col-sm-9 col-xs-9 text-left">
                        <strong>Sub Total Service Cost:</strong>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3 text-right">
                        &#x20B5;{{ $booking->price }}
                    </div>
                </div>

                <div class="price-breakdown-column">
                    <div class="col-md-9 col-sm-9 col-xs-9 text-left">
                        <strong>VAT {{ $vat_tax }}%:</strong>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3 text-right">
                        <?php
                        $booking_price = $booking->price;
                        $vat_tax_price = ($booking->price * $vat_tax) / 100;
                        $total_price = $booking_price + $vat_tax_price;
                        ?>
                        &#x20B5;{{ number_format($vat_tax_price, 2) }}
                    </div>
                </div>

                <div class="price-breakdown-column total-price">
                    <div class="col-md-9 col-sm-9 col-xs-9 text-left">
                        <strong>Total Service Cost:</strong>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3 text-right">
                        <strong>
                            &#x20B5;{{ number_format($total_price, 2) }}
                        </strong>
                    </div>
                </div>

                @else
                <div class="price-breakdown-column">
                    <div class="col-md-9 col-sm-9 col-xs-9 text-left">
                        <strong>Service Cost:</strong>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3 text-right">
                        Not Quoted Yet
                    </div>
                </div>

                @endif
                
                @else
                
                @if($booking->price && $booking->price != '0.00')
                <div class="price-breakdown-column sub-total-price">
                    <div class="col-md-9 col-sm-9 col-xs-9 text-left">
                        <strong>Sub Total Service Cost:</strong>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3 text-right">
                        &#x20B5;{{ $booking->price }}
                    </div>
                </div>

                <div class="price-breakdown-column">
                    <div class="col-md-9 col-sm-9 col-xs-9 text-left">
                        <strong>VAT {{ $vat_tax }}%:</strong>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3 text-right">
                        <?php
                        $booking_price = $booking->price;
                        $vat_tax_price = ($booking->price * $vat_tax) / 100;
                        $total_price = $booking_price + $vat_tax_price;
                        ?>
                        &#x20B5;{{ number_format($vat_tax_price, 2) }}
                    </div>
                </div>

                <div class="price-breakdown-column total-price">
                    <div class="col-md-9 col-sm-9 col-xs-9 text-left">
                        <strong>Total Service Cost:</strong>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3 text-right">
                        <strong>
                            &#x20B5;{{ number_format($total_price, 2) }}
                        </strong>
                    </div>
                </div>

                @else
                <div class="price-breakdown-column">
                    <div class="col-md-9 col-sm-9 col-xs-9 text-left">
                        <strong>Service Cost:</strong>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3 text-right">
                        Not Quoted Yet
                    </div>
                </div>

                @endif
                
                @endif
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
</div>