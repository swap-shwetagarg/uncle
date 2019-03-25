<?php $selected_services_array = []; ?>
@if(isset($selected_services) && $selected_services && sizeof($selected_services))
<?php $selected_services_array = $selected_services; ?>
@endif

@if(isset($search) && $search)
<div class="tab-pane fade in active" id="category21" role="tabpanel">
    @if(isset($services) && $services && !$services->isEmpty())
    @foreach($services AS $key => $service )
    @if(!in_array($service->id, $selected_services_array))
    <div class="popular--services">
        <span class="fa fa-plus" aria-hidden="true"></span>
        <h4 data-id='{{ $service->id }}' class="service">
            {{ $service->title }}
        </h4>
    </div>
    @endif
    @endforeach
    @endif
</div>
@else

@if(isset($service_types) && $service_types && !$service_types->isEmpty())
@if(isset($service_types[1]->id) && $service_types[1]->id && $service_types[1]->id == 2)

<?php $selected_services_array = []; ?>
@if(isset($selected_services) && $selected_services && sizeof($selected_services))
<?php $selected_services_array = $selected_services; ?>
@endif

<?php $categories = $service_types[0]->category; ?>
@if(isset($categories) && $categories && !$categories->isEmpty())
@foreach($categories AS $parent_key => $category )
<?php $services = $category->service; ?>
@if($parent_key == 0)                                            
<div class="tab-pane fade in active" id="category{{ $parent_key }}" role="tabpanel">
    @if(isset($services) && $services && !$services->isEmpty())
    @foreach($services AS $key => $service )
    @if(!in_array($service->id, $selected_services_array))
    <div class="popular--services">
        <span class="fa fa-plus" aria-hidden="true"></span>
        <h4 data-id='{{ $service->id }}' class="service">
            {{ $service->title }}
        </h4>
    </div>
    @endif
    @endforeach
    @endif
</div>
@else
<div class="tab-pane fade" id="category{{ $parent_key }}" role="tabpanel">
    @if(isset($services) && $services && !$services->isEmpty())
    @foreach($services AS $key => $service )
    @if(!in_array($service->id, $selected_services_array))
    <div class="popular--services">
        <span class="fa fa-plus" aria-hidden="true"></span>
        <h4 data-id='{{ $service->id }}' class="service">
            {{ $service->title }}
        </h4>
    </div>
    @endif
    @endforeach
    @endif
</div>
@endif
@endforeach
@endif

<div class="tab-pane fade in" id="category15111" role="tabpanel">
    @if(isset($popular_services) && $popular_services && count($popular_services))
    @foreach($popular_services AS $key => $service )
    @if(!in_array($service->id, $selected_services_array))
    <div class="popular--services">
        <span class="fa fa-plus" aria-hidden="true"></span>
        <h4 data-id='{{ $service->id }}' class="service">
            {{ $service->title }}
        </h4>
    </div>
    @endif
    @endforeach
    @endif
</div>
<div class="tab-pane fade in" id="category_custom_service" role="tabpanel">
    <div class="popular--services">
        <div class="form-group">
            <textarea name="own_service_description" id="own_service_description" class="form-control" rows="5" placeholder="For Example: Change Brake Pads"></textarea>
            <span class="required-msg hidden"></span>
            <div class="row hidden" id="add_custom_services_container">
                <div class="col-md-12 col-sm-12 col-xs-12 text-left">
                    <button type="button" class="btn btn-primary add_custom_services pull-right">Add Services</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endif
@endif

@endif