<h1>Select Your Services</h1>
<div class="tab-wrap service-types-container">
    <div class="tab-container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                @if(isset($service_types) && $service_types && !$service_types->isEmpty())

                <!-- Nav tabs -->
                <ul class="nav nav-tabs service-type-nav">
                    @foreach($service_types AS $key => $service_type )
                    <li class="{{ ($key == 0) ? 'active' : '' }}">
                        <a href="#tab{{ $key+1 }}" data-toggle="tab">{{ $service_type->service_type }}</a>
                    </li>
                    @endforeach
                </ul>
                <!-- Tab panels -->
                <div class="tab-content">
                    @if(isset($service_types[0]->id) && $service_types[0]->id && $service_types[0]->id == 1)
                    <div class="tab-pane fade in active" id="tab1">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 no--padding">
                                    <div class="tab-container">

                                        <div class="input-group" style="width: 100%;padding: 20px;margin-left: 8px;border-bottom: 1px solid #dcd7d7">
                                            <input type="text" name="search-repair-services" id="search-repair-services" 
                                                   placeholder="Search Repair & Maintenance Services" class="form-control" />
                                        </div>

                                        <ul class="nav nav-tabs nav-tabs-left nav-centered service-category-nav" role="tablist">
                                            <?php $categories = $service_types[0]->category; ?>
                                            @if(isset($categories) && $categories && !$categories->isEmpty())
                                            @foreach($categories AS $key => $category )
                                            @if($key == 0)
                                            <li role="presentation" class="active">
                                                <a href="#category{{ $key }}" data-toggle="tab" role="tab">
                                                    {{ $category->category_name }}
                                                </a>
                                            </li>
                                            @else
                                            <li role="presentation" class="">
                                                <a href="#category{{ $key }}" data-toggle="tab" role="tab">
                                                    {{ $category->category_name }}
                                                </a>
                                            </li>
                                            @endif
                                            @endforeach
                                            @endif
                                            @if(isset($popular_services) && count($popular_services))
                                            <li role="presentation" class="">
                                                <a href="#category15111" data-toggle="tab" role="tab">
                                                    Popular Services
                                                </a>
                                            </li>
                                            <li role="presentation" class="category_custom_service_button">
                                                <a href="#category_custom_service" data-toggle="tab" role="tab">
                                                    Custom Services
                                                </a>
                                            </li>
                                            @endif
                                        </ul>

                                        <div class="tab-content side-tabs side-tabs-left diagnostics" id="repaire-tab">
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
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if(isset($service_types[1]->id) && $service_types[1]->id && $service_types[1]->id == 2)
                    <div class="tab-pane fade" id="tab2">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 no--padding">
                                    <div class="tab-container">
                                        
                                        <div class="input-group" style="width: 100%;padding: 20px;margin-left: 8px;border-bottom: 1px solid #dcd7d7">
                                            <input type="text" name="search-diagnostic-services" id="search-diagnostic-services" 
                                                   placeholder="Search Diagnostics & Inspections Services" class="form-control" />
                                        </div>
                                        
                                        <div class="tab-content side-tabs side-tabs-left diagnostics" id="diagnostics-tab">                                            
                                            <?php $selected_services_array = []; ?>
                                            @if(isset($selected_services) && $selected_services && sizeof($selected_services))
                                            <?php $selected_services_array = $selected_services; ?>
                                            @endif

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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                @endif
            </div>
        </div>
    </div>
</div>