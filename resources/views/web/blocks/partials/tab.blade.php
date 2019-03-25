<div class="container tab_tab">

    <div id="booking-loader" class="loading hidden">Loading&#8230;</div>

    <form id="example-form" method="POST" action="{{ URL('/submit-quotation') }}">
        {{ csrf_field() }}
        <?php
        $location = $car = $year = $car_model = $car_trim = $cars = '';
        if (isset($car_info_data) && $car_info_data) {
            $location = (isset($car_info_data['location']) && $car_info_data['location']) ? $car_info_data['location'] : '';
            $car = (isset($car_info_data['car']) && $car_info_data['car']) ? $car_info_data['car'] : '';
            $year = (isset($car_info_data['year']) && $car_info_data['year']) ? $car_info_data['year'] : '';
            $car_model = (isset($car_info_data['model']) && $car_info_data['model']) ? $car_info_data['model'] : '';
            $car_trim = (isset($car_info_data['trim']) && $car_info_data['trim']) ? $car_info_data['trim'] : '';
            $cars = (isset($car_info_data['cars']) && $car_info_data['cars']) ? $car_info_data['cars'] : '';
        }
        ?>
        <div>
            <h3>Car & Location</h3>
            <section class="car_location">
                <h1>Answer a few simple questions to get a quote.</h1>
                <h2>Service at your home or office, Monday to Sunday.</h2>
                <div class="col-md-9 col-sm-9 all--ready">
                    <div class="already">
                        @if (Auth::guest())
                        <h3>Already have an account? <a href="{{ URL('login') }}">Log in</a></h3>
                        @endif

                        <label>Select Your Location</label>

                        <div class="col-md-12 col-sm-12 zip_zip">
                            <select class="form-control" name="location" id="location">
                                <option value="">Select Location</option>
                                @if(isset($locations) && $locations)
                                @foreach($locations AS $location_value)
                                <option value="{{ $location_value->id }}"
                                        {{ (isset($location) && $location && isset($location[0]) && $location[0] && isset($location[0]->zip_code) && $location[0]->zip_code && $location[0]->id == $location_value->id) ? 'selected' : '' }}>{{ $location_value->zip_code }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <p class="location-message {{ (isset($location) && $location) ? '' : 'hidden' }}">
                            {{ (isset($location) && $location && isset($location[0]) && $location[0] && isset($location[0]->zip_code) && $location[0]->zip_code) ? 'Great! We have certified mobile mechanics in '.$location[0]->zip_code : '' }}
                        </p>

                        @if( (isset($location) && $location) || $cars )
                        <div class="confirm--zip hidden">
                            @else
                            <div class="confirm--zip hidden">
                                @endif                        
                                <input type="button" id="confirm-location" name="submit" value="Confirm Location" data-loading-text="Loading..." />
                            </div>

                        </div>

                        @if( ($car && $year && $car_model && $car_trim) || ($cars) || (isset($user_cars) && $user_cars) )
                        <div class="col-md-12 col-sm-12 select_car car-info-container">
                            @else
                            <div class="col-md-12 col-sm-12 select_car car-info-container hidden">
                                @endif                    

                                @if($car && $year && $car_model && $car_trim)
                                <h1 class="select-label">Selected Your Car</h1>
                                @else
                                <h1 class="select-label">Select Your Car</h1>
                                @endif

                                <div class="row users-car-container {{ (isset($user_cars) && $user_cars) ? '' : 'hidden' }}">
                                    @if(isset($user_cars) && $user_cars)
                                    @include('web.blocks.pages.user-cars')
                                    @endif
                                </div>

                                <div class="row selected-car-container {{ ($car && $year && $car_model && $car_trim) ? '' : 'hidden' }}">
                                    <div class="col-md-12 col-sm-12 no--padding">
                                        <ul class="selected-car" id="select-your-car">
                                            @if($car && $year && $car_model && $car_trim)
                                            @include('web.blocks.pages.selected-car-info')
                                            @endif
                                        </ul>
                                    </div>
                                </div>

                                <div class="row cars-listing listings {{ (isset($cars) && $cars) ? '' : 'hidden' }}">
                                    @if(isset($cars) && $cars)
                                    @include('web.blocks.pages.car-listings')
                                    @endif
                                </div>

                                <div class="row car_year years-listing listings hidden"></div>

                                <div class="row car_model models-listing listings hidden"></div>

                                <div class="row car_model trims-listing listings hidden"></div>

                            </div>
                        </div>

                        </section>

                        <h3>Services</h3>
                        <section class="car_location body">
                            <div class="col-md-7 col-sm-12 no--padding tab--2">

                                <div class="col-md-12 col-sm-12 select_car">
                                    <h1>Selected Car</h1>
                                    <div class="row selected-car-container">
                                        <div class="col-md-12 col-sm-12 no--padding">
                                            <ul class="selected-car-step2 selected-car" id="selected-car-info">
                                                @if($car && $year && $car_model && $car_trim)
                                                @include('web.blocks.pages.selected-car-info')
                                                @endif
                                            </ul>
                                            <p class="note">
                                                <a href="{{ URL('reset-quotation') }}">Click Here</a> 
                                                to select a new car.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 select_car services-container">
                                    <?php
                                    if (isset($service_types) && $service_types && !empty($service_types) && !isset($selected_service_view)) {
                                        print $service_types;
                                    }
                                    ?>
                                </div>

                                <div class="col-md-12 col-sm-12 select_car recommended-services-container hidden"></div>

                                <div class="col-md-12 col-sm-12 select_car sub-services-container {{ isset($selected_service_view['service_listing'])?'':'hidden' }}">
                                    <?php
                                    if (isset($selected_service_view['service_listing'])) {
                                        echo $selected_service_view['service_listing'];
                                    }
                                    ?>
                                </div>

                                <div class="col-md-12 col-sm-12 select_car own-service-container hidden">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <h1>Let us know what service or repair you need</h1>
                                            <div class="form-group">
                                                <textarea name="own_service_description" id="own_service_description" class="form-control" rows="5"
                                                          placeholder="For Example: Change Brake Pads"></textarea>
                                                <span class="required-msg hidden"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12 select_car review-book-action-container <?php echo (isset($selected_service_view)) ? '' : 'hidden' ?>">
                                    <div class="row next-step-button">
                                        <div class="col-md-4 col-sm-12 col-xs-12 text-left">
                                            <button type="button" name="back_to_the_services" id="back-to-the-services" class="btn btn-primary add-more-services">Back</button>
                                        </div>
                                        <div class="col-md-4 col-sm-12 col-xs-12 text-center">
                                            <button type="button" name="back_to_the_services" id="add-more-services" class="btn btn-primary add-more-services">Add More</button>
                                        </div>
                                        <div class="col-md-4 col-sm-12 col-xs-12 text-right">
                                            <button type="button" data-loading-text="Loading..." name="review_and_book" id="review-and-book" class="btn btn-primary review-and-book">Review & Book</button>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div style="margin-top: 20px;" class="col-md-5 col-sm-12 no--padding tab--2">
                                <div class="col-md-12 col-sm-12 select_car selected_services-container {{ isset($selected_service_view['slectd_ser_html'])?'':'hidden' }}">
                                    <?php
                                    if (isset($selected_service_view['slectd_ser_html'])) {
                                        echo $selected_service_view['slectd_ser_html'];
                                    }
                                    ?>
                                </div>
                            </div>
                        </section>

                        <h3>Review & Book</h3>
                        <section class="car_location body">
                            <div class="col-md-9 col-sm-12 no--padding tab--2 review-services-list">
                                <div class="col-md-12 col-sm-12 review-and-book-container hidden text-left">
                                    @if (isset($service_types) && $service_types && !empty($service_types) && !isset($selected_service_view))
                                    @include('web.blocks.pages.review-and-book')
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12 no--padding tab--2 text-center review-services-actions">
                                <p>
                                    <a style="color: red;" href="{{ URL('reset-services') }}">Click Here</a> 
                                    to select another service.
                                </p>
                                <p>
                                    <a id="add-more-services-from-review" class="add-more-services-from-review" style="color: red;" href="javascript:void(0);">Click Here</a> 
                                    to add more service.
                                </p>
                            </div>
                        </section>                       

                    </div>
                    </form>
                </div>