@extends('layouts.admin')

@section('title', "Request A Quote | Uncle Fitter")

@section('content')
<div class="wrapper">
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="row">
                
                @if(isset($page_type) && $page_type && $page_type == 'update-services' )

                <div class="col-sm-12">
                    <div class="panel panel-bd">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h4>Add/Update/Delete Service(s)</h4>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form action="{{ url("admin/bookings/submit-quote") }}" method="POST" name="requestAQuoteAdmin" id="requestAQuoteAdmin">
                                <input type="hidden" name="action_type" value="update" />
                                <input type="hidden" name="user_id" value="{{$booking->getUser->id}}" />
                                <input type="hidden" name="booking_id" value="{{$booking_id}}" />
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="row">
                                            <div class="col-md-12 form-group">
                                                <label for="name"><u>User Info</u></label><br/>
                                                <strong>Name:</strong> {{$booking->getUser->name}}<br/>
                                                <strong>Email Address:</strong> <a href="mailto: {{$booking->getUser->email}}">{{$booking->getUser->email}}</a><br/>
                                                <strong>Mobile Number:</strong> {{$booking->getUser->mobile_country_code}} {{$booking->getUser->mobile}}<br/>
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <label for="user_cars"><u>Car Info</u></label><br/>
                                                <strong>Brand:</strong> {{$booking->carTrim->carmodel->years->cars->brand}}<br/>
                                                <strong>Year:</strong> {{$booking->carTrim->carmodel->years->year}}<br/>
                                                <strong>Model:</strong> {{$booking->carTrim->carmodel->modal_name}}<br/>
                                            </div>
                                            <div class="col-md-12 form-group">
                                                {{ csrf_field()}}
                                                <br/>
                                                <button type="submit" name="update-quote" id="update-quote" class="btn btn-primary">Update Quote</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="service_types">Service Type</label>
                                                <select name="service_types" id="service_types" class="form-control">
                                                    <option value="">Select Service Type</option>
                                                    @if(isset($service_types) && $service_types) 
                                                    @foreach($service_types AS $service_type)
                                                    <option value="{{ $service_type->id }}">{{ $service_type->service_type }}</option>
                                                    @endforeach
                                                    @endif
                                                    <option value="popular">Popular Services</option>
                                                    <option value="custom">Custom Service</option>
                                                    <option value="search">Search Service</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 form-group category-dropdown">
                                                <label for="category">Category</label>
                                                <select name="category" id="category" class="form-control">
                                                    <option value="">Select Category</option>
                                                </select>
                                            </div>
                                            <div class="col-md-12 form-group" id="service-required-message"></div>
                                        </div>
                                        <div class="row search-service-section hide-section">
                                            <div class="col-md-12 form-group" id="search-service-section"></div>
                                        </div>
                                        <div class="row select-services-section hide-section">
                                            <div class="col-md-6 form-group hide-section" id="services-section"></div>
                                            <div class="col-md-6 form-group hide-section" id="sub-services-section"></div>
                                        </div>
                                        <div class="row custom-service-section hide-section">
                                            <div class="col-md-12 form-group" id="custom-service-section"></div>
                                        </div>                                        
                                        <div class="row selected-services-section">
                                            <div class="col-md-12 table-responsive">
                                                <table class="table table-striped table-condensed">
                                                    <thead>
                                                        <tr>
                                                            <th class="col-md-8"><h4><label>Service Name</label></h4></th>
                                                            <th class="col-md-4"><h4><label>Action</label></h4></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="selected-services-section">
                                                        
                                                        @if(isset($booking->bookingItems) && $booking->bookingItems && !$booking->bookingItems->isEmpty())
                                                        @foreach($booking->bookingItems as $bookingItem)
                                                            <tr>
                                                                <td class="col-md-8">
                                                                    <h4><label>{{ (isset($bookingItem->getService->title) && $bookingItem->getService->title) ? $bookingItem->getService->title : '' }}</label></h4>
                                                                    @if(isset($bookingItem->bookingServiceSub) && $bookingItem->bookingServiceSub && !$bookingItem->bookingServiceSub->isEmpty())
                                                                        @foreach($bookingItem->bookingServiceSub as $subSurvice)
                                                                            @if(isset($subSurvice->getServiceSub) && $subSurvice->getServiceSub && isset($subSurvice->getServiceSub->display_text) && $subSurvice->getServiceSub->display_text)
                                                                            <h5><label>{{ $subSurvice->getServiceSub->display_text }}</label></h5>
                                                                            @endif       
                                                                            @if(isset($subSurvice->bookingSubOption) && $subSurvice->bookingSubOption && !$subSurvice->bookingSubOption->isEmpty())
                                                                                @foreach($subSurvice->bookingSubOption as $option)
                                                                                <h6><label><i class="fa fa-check"></i> {{$option->getSubOption->option_name}}</label></h6>
                                                                                @endforeach
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                </td>
                                                                <td class="col-md-4">
                                                                    <a data-loading-text="Deleting..." href="javascript:void(0)" class="btn btn-xs btn-danger delete-service" data-id="{{ $bookingItem->service_id }}">Delete</a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        @endif
                                                        
                                                        @if($booking->own_service_description)
                                                        <tr>
                                                            <td class="col-md-8">
                                                                <h4><label>Custom Service</label></h4>
                                                                <?php echo html_entity_decode($booking->own_service_description); ?>
                                                            </td>
                                                            <td class="col-md-4">
                                                                <a data-loading-text="Deleting..." href="javascript:void(0)" class="btn btn-xs btn-danger delete-service" data-id="{{ 'custom' }}">Delete</a>
                                                            </td>
                                                        </tr>
                                                        @endif
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                            </form>
                        </div>
                    </div>
                </div>
                
                @else

                <div class="col-sm-12">
                    <div class="panel panel-bd">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h4>Request A Quote</h4>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form action="{{ url("admin/bookings/submit-quote") }}" method="POST" name="requestAQuoteAdmin" id="requestAQuoteAdmin">
                                <input type="hidden" name="action_type" value="add" />
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="row">
                                            <div class="col-md-12 form-group">
                                                <label for="name">Search By Name/Email/Mobile</label>
                                                <input type='text'
                                                       placeholder='Search User By Name/Email/Mobile'
                                                       class='flexdatalist form-control'
                                                       data-search-in='["name","email","mobile"]'
                                                       data-visible-properties='["name"]'
                                                       data-url='{{ URL("admin/bookings/seach-username") }}'
                                                       data-min-length='1'
                                                       data-selection-required='true'
                                                       name='user_id'
                                                       data-value-property='id'
                                                       id="search_username" />
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <label for="default_location">Default Location</label>
                                                <select name="default_location" id="default_location" class="form-control">
                                                    <option value="">Select Location</option>
                                                    @if(isset($locations) && $locations) 
                                                    @foreach($locations AS $location)
                                                    <option value="{{ $location->id }}">{{ $location->zip_code }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <label for="user_cars">Car</label>
                                                <select name="user_cars" id="user_cars" class="form-control">
                                                    <option value="">Select Car</option>
                                                </select>
                                            </div>
                                            <div class="col-md-12 form-group">
                                                {{ csrf_field()}}
                                                <br/>
                                                <button type="submit" name="request-a-quote" id="request-a-quote" class="btn btn-primary">Request A Quote</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="service_types">Service Type</label>
                                                <select name="service_types" id="service_types" class="form-control">
                                                    <option value="">Select Service Type</option>
                                                    @if(isset($service_types) && $service_types) 
                                                    @foreach($service_types AS $service_type)
                                                    <option value="{{ $service_type->id }}">{{ $service_type->service_type }}</option>
                                                    @endforeach
                                                    @endif
                                                    <option value="popular">Popular Services</option>
                                                    <option value="custom">Custom Service</option>
                                                    <option value="search">Search Service</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 form-group category-dropdown">
                                                <label for="category">Category</label>
                                                <select name="category" id="category" class="form-control">
                                                    <option value="">Select Category</option>
                                                </select>
                                            </div>
                                            <div class="col-md-12 form-group" id="service-required-message"></div>
                                        </div>
                                        <div class="row search-service-section hide-section">
                                            <div class="col-md-12 form-group" id="search-service-section"></div>
                                        </div>
                                        <div class="row select-services-section hide-section">
                                            <div class="col-md-6 form-group hide-section" id="services-section"></div>
                                            <div class="col-md-6 form-group hide-section" id="sub-services-section"></div>
                                        </div>
                                        <div class="row custom-service-section hide-section">
                                            <div class="col-md-12 form-group" id="custom-service-section"></div>
                                        </div>                                        
                                        <div class="row selected-services-section">
                                            <div class="col-md-12 table-responsive">
                                                <table class="table table-striped table-condensed">
                                                    <thead>
                                                        <tr>
                                                            <th class="col-md-8"><h4><label>Service Name</label></h4></th>
                                                            <th class="col-md-4"><h4><label>Action</label></h4></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="selected-services-section"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                            </form>
                        </div>
                    </div>
                </div>

                @endif

            </div>
        </section>
    </div>
</div>
@endsection