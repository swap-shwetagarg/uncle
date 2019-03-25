<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    <h3 class="modal-title">Previous Service Details</h3>
</div>
<div class="panel panel-bd">
    <div class="panel-body">
        <div class="row">
            @if(count($booking)>0)
            @foreach($booking as $userBooking)            
            <div class="col-sm-12 col-md-12">
                <!-- Danger Panel -->
                <div class="panel panel-info lobidisable">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4>Service Date: {{ date('d-m-Y',strtotime($userBooking->date_time)) }}</h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            @if(isset($userBooking->bookingItems) && $userBooking->bookingItems && !$userBooking->bookingItems->isEmpty())
                            @foreach($userBooking->bookingItems as $bookingItem)                            
                            <div class="col-md-12 col-sm-12">
                                <h4>{{$bookingItem->getService->title}}</h4>
                                <ul>
                                    @foreach($bookingItem->bookingServiceSub as $subSurvice)
                                    <li>{{$subSurvice->getServiceSub->title}}</li>
                                    @endforeach                                        
                                </ul>
                            </div>
                            @endforeach
                            @else
                            <div class="col-md-12 col-sm-12">
                                <h4>Custom Service Description</h4>
                                <p>
                                    {{ $userBooking->own_service_description }}
                                </p>
                            </div>                          
                            @endif
                        </div>                            
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-sm-12 col-md-4">
                                <strong>Location: </strong>{{ ((isset($userBooking->getZipCode->zip_code))) ? $userBooking->getZipcode->zip_code.' ('.$userBooking->getZipcode->country_code.')' : '' }}
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <strong>Price: </strong>{{ $userBooking->price }}
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <strong>Mechanic: </strong>{{ (isset($userBooking->bookingMechanic->mechanic) && $userBooking->bookingMechanic->mechanic) ? $userBooking->bookingMechanic->mechanic->name : 'Not Assigned' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <div class="col-sm-12 col-md-12">
                <h4>No Service Yet!</h4>
            </div>
            @endif
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
</div>