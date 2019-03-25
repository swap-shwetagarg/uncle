@if($type && $type == 'user_cars')

<option value="">Select Car</option>
@if(isset($user_cars) && $user_cars)
@foreach($user_cars AS $user_car)
<?php
$car_name = $user_car->usercars->carmodel->years->cars->brand . ' ' . $user_car->usercars->carmodel->years->year . ' ' .
        $user_car->usercars->carmodel->modal_name . ' ' . $user_car->usercars->car_trim_name;
?>
<option value="{{ $user_car->car_trim_id }}">{{ $car_name  }}</option>
@endforeach
@endif

@elseif($type && $type == 'category')

<option value="">Select Category</option>
@if(isset($categories) && $categories)
@foreach($categories AS $category)
@if($category->id != 2)
<option value="{{ $category->id }}">{{ $category->category_name  }}</option>
@endif
@endforeach
@endif

@elseif($type && $type == 'services')

@if(isset($services) && $services)
<!--<h3>Services</h3>-->
<ul class="services-lists">
    @foreach($services AS $service)
    <li>
        <a data-id="{{ $service->id }}" href="javascript:void(0)">{{ $service->title  }}</a>
    </li>
    @endforeach
</ul>
@endif

@elseif($type && $type == 'sub_services')
<div class="sub-services-section">
    <!--<h3>Service Description/Sub Service and their options</h3>-->
    @if(isset($sub_services) && $sub_services)
    <ul class="sub-services-lists">
        <?php $i = 1; ?>
        @foreach($sub_services AS $sub_service)
        <li>
            <span class="sub-service-title">{{ $sub_service['title'] }}</span>
            @if(!$sub_service['optional'] && $sub_service['optional'] == '0')
            <span class="sub-service-mandotary">*</span>
            @endif
            <span class="sub-service-mandotary-message" id="sub-service-mandotary-message{{ $sub_service['id'] }}"></span>
            <input type="hidden" name="sub_service_id[]" value="{{ $sub_service['id'] }}" />
            <input type="hidden" id="display_text{{ $sub_service['id'] }}" value="{{ $sub_service['display_text'] }}" />
            <input type="hidden" id="selection_type{{ $sub_service['id'] }}" value="{{ $sub_service['selection_type'] }}" />
            <input type="hidden" id="optional{{ $sub_service['id'] }}" value="{{ $sub_service['optional'] }}" />
            @if($sub_service['selection_type'] && $sub_service['selection_type'] == 'S')
            @if(isset($sub_service['sub_service_options']) && $sub_service['sub_service_options'])
            <?php $j = 1; ?>
            @foreach($sub_service['sub_service_options'] AS $sub_service_options )
            <span class="sub-service-options">
                <label for="sub_service_options{{ $sub_service['id'] }}{{ $i.''.$j }}">
                    <input data-option_name="{{ $sub_service_options->option_name }}" name="sub_service_options{{ $sub_service['id'] }}[]" type="radio" id="sub_service_options{{ $sub_service['id'] }}{{ $i.''.$j }}"
                           class="sub-service-options" value="{{ $sub_service_options->id }}" /> {{ $sub_service_options->option_name }}
                </label>
            </span>
            <?php $j++; ?>
            @endforeach
            @endif
            @elseif($sub_service['selection_type'] && $sub_service['selection_type'] == 'M')
            @if(isset($sub_service['sub_service_options']) && $sub_service['sub_service_options'])
            <?php $j = 1; ?>
            @foreach($sub_service['sub_service_options'] AS $sub_service_options )
            <span class="sub-service-options">
                <label for="sub_service_options{{ $sub_service['id'] }}{{ $i.''.$j }}">
                    <input data-option_name="{{ $sub_service_options->option_name }}" name="sub_service_options{{ $sub_service['id'] }}[]" type="checkbox" id="sub_service_options{{ $sub_service['id'] }}{{ $i.''.$j }}"
                           class="sub-service-options" value="{{ $sub_service_options->id }}" /> {{ $sub_service_options->option_name }}
                </label>
            </span>
            <?php $j++; ?>
            @endforeach
            @endif
            @endif
        </li>
        <?php $i++; ?>
        @endforeach
        <input type="hidden" name="service_id" value="{{ $service_id }}" />
        <input type="hidden" name="service_title" value="{{ $service_title }}" />
    </ul>
    @elseif(isset($service_description) && $service_description)
    {!! $service_description !!}
    <input type="hidden" name="service_id" value="{{ $service_id }}" />
    <input type="hidden" name="service_title" value="{{ $service_title }}" />
    @endif
</div>
@if(isset($selected_services_array) && $selected_services_array && in_array($service_id, $selected_services_array)) 
@else
<button type="button" data-loading-text="Loading..." class="btn btn-primary btn-xs pull-right" id="add-service-admin">Add Service</button>
@endif

@elseif($type && $type == 'add_services')

@if(isset($custom_service_description) && $custom_service_description)
<tr>
    <td class="col-md-8">
      <h4><label>Custom Service</label></h4>
      <p>{!! $custom_service_description !!}</p>
      <!--<p>{{ html_entity_decode($custom_service_description) }}</p>-->
    </td>
    <td class="col-md-4">
        <a data-loading-text="Deleting..." href="javascript:void(0)" class="btn btn-xs btn-danger delete-service" data-id="{{ 'custom' }}">Delete</a>
    </td>
</tr>
@elseif(isset($service_array_client) && $service_array_client)
@foreach($service_array_client AS $service)
<tr>
    <td class="col-md-8">
        <h4><label>{{ (isset($service->service_title) && $service->service_title) ? $service->service_title : '' }}</label></h4>
        @if(isset($service->sub_services) && $service->sub_services)
        @foreach($service->sub_services AS $sub_services)
        <h5><label>{{ (isset($sub_services[0]->display_text) && $sub_services[0]->display_text) ? $sub_services[0]->display_text : '' }}</label></h5>
        @if(isset($sub_services[0]->sub_service_options) && $sub_services[0]->sub_service_options)
        @foreach($sub_services[0]->sub_service_options AS $sub_service_options)
        <h6><label><i class="fa fa-check"></i> {{ (isset($sub_service_options[0]->option_name) && $sub_service_options[0]->option_name) ? $sub_service_options[0]->option_name : '' }}</label></h6>
        @endforeach
        @endif
        @endforeach
        @endif
    </td>
    <td class="col-md-4">
        <a data-loading-text="Deleting..." href="javascript:void(0)" class="btn btn-xs btn-danger delete-service" data-id="{{ $service->id }}">Delete</a>
    </td>
</tr>
@endforeach
@endif

@elseif($type && $type == 'custom')
<textarea name="custom_service_description" class="form-control" id="custom_service_description" 
          rows="5" cols="40" placeholder="Please write your description..."></textarea>
<br/>
<span id="custom_service_description_message" class="hide-section"></span>
<br/><br/>
<button type="button" data-loading-text="Loading..." class="btn btn-primary btn-xs" id="add-service-admin">Add Service</button>

@elseif($type && $type == 'search')
<input name="search_service" id="search_service" class="form-control" placeholder="Search for service or your car problem..." />
@endif