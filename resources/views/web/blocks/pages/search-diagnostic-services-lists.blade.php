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
        <h4 data-id='{{ $service->id }}'
        <?php
        if ($service->recommend_service_id && $service->recommend_service_id != '') {
            ?>
                data-recommend_service_id="{{ $service->recommend_service_id }}"
                <?php
            }
            ?>                                                        
            <?php
            if ($service->recommend_service_id && $service->recommend_service_id != '') {
                echo 'class="show-recommended-service"';
            } else {
                echo 'class="diagnostics-service"';
            }
            ?>>
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
<?php
$categories = $service_types[1]->category;
?>
@if(isset($categories) && $categories && !$categories->isEmpty())
@foreach($categories AS $parent_key => $category )
<?php
$services_collection = $category->service->where('category_id', 2);
//$services_collection = $category->service()->where('category_id', 2);
$services = $services_collection->where('category_id', 2);
?>
<div class="tab-pane fade in active" id="category21" role="tabpanel">
    @if(isset($services) && $services && !$services->isEmpty())
    @foreach($services AS $key => $service )
    @if(!in_array($service->id, $selected_services_array))
    <div class="popular--services">
        <span class="fa fa-plus" aria-hidden="true"></span>
        <h4 data-id='{{ $service->id }}'
        <?php
        if ($service->recommend_service_id && $service->recommend_service_id != '') {
            ?>
                data-recommend_service_id="{{ $service->recommend_service_id }}"
                <?php
            }
            ?>                                                        
            <?php
            if ($service->recommend_service_id && $service->recommend_service_id != '') {
                echo 'class="show-recommended-service"';
            } else {
                echo 'class="diagnostics-service"';
            }
            ?>>
            {{ $service->title }}
        </h4>
    </div>
    @endif
    @endforeach
    @endif
</div>
@endforeach
@endif
@endif
@endif

@endif