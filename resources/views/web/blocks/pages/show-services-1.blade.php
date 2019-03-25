
<h1>Select Your Services</h1>
<div class="tab-wrap service-types-container">
    @if(isset($service_types) && $service_types && !$service_types->isEmpty())
    @foreach($service_types AS $key => $service_type )
    <input type="radio" id="tab{{ $key+1 }}" name="service_type" class="tab" {{ ($key == 0) ? '' : 'checked' }} value="{{ $service_type->id }}" />
    <label for="tab{{ $key+1 }}">{{ $service_type->service_type }}</label>
    @endforeach

    <div class="tab__content">

        @if(isset($service_types[0]->id) && $service_types[0]->id && $service_types[0]->id == 1)

        <div role="tabpanel" class="tab-pane service-container" id="service-type-1">
            <div class="row">
                <div class="col-sm-12">
                    <div class="tab-container">
                        <ul class="nav nav-tabs nav-tabs-left nav-centered" role="tablist">
                            <?php $categories = $service_types[0]->category; ?>
                            @if(isset($categories) && $categories && !$categories->isEmpty())
                            @foreach($categories AS $key => $category )
                            <li role="presentation" class="active">
                                <a href="#category10" data-toggle="tab" role="tab">
                                    {{ $category->category_name }}
                                </a>
                            </li>
                            @endforeach
                            @endif
                        </ul>                                            
                        <div id="my_side_tabs" class="tab-content side-tabs side-tabs-left">
                            <?php $selected_services_array = []; ?>
                            @if(isset($selected_services) && $selected_services && sizeof($selected_services))
                            <?php $selected_services_array = $selected_services; ?>
                            @endif

                            <?php $categories = $service_types[0]->category; ?>
                            @if(isset($categories) && $categories && !$categories->isEmpty())
                            @foreach($categories AS $parent_key => $category )
                            <?php $services = $category->service; ?>
                            <div class="tab-pane fade in active" id="category10" role="tabpanel">
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
                                <div class="popular--services">
                                    <span class="fa fa-plus" aria-hidden="true"></span>
                                    <h4 data-id='0' class="add-own-service">
                                        Request a custom service
                                    </h4>
                                </div>
                                @endif
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @endif
        
        @if(isset($service_types[1]->id) && $service_types[1]->id && $service_types[1]->id == 2)

        <div role="tabpanel" class="tab-pane service-container hidden" id="service-type-2">
            <div class="row">
                <div class="col-sm-12">
                    <div class="tab-container">
                        <div id="my_side_tabs" class="tab-content side-tabs side-tabs-left">
                            <?php $selected_services_array = []; ?>
                            @if(isset($selected_services) && $selected_services && sizeof($selected_services))
                            <?php $selected_services_array = $selected_services; ?>
                            @endif

                            <?php $categories = $service_types[1]->category; ?>
                            @if(isset($categories) && $categories && !$categories->isEmpty())
                            @foreach($categories AS $parent_key => $category )
                            <?php $services = $category->service; ?>
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
                                <div class="popular--services">
                                    <span class="fa fa-plus" aria-hidden="true"></span>
                                    <h4 data-id='0' class="add-own-service">
                                        Request a custom service
                                    </h4>
                                </div>
                                @endif
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @endif
    </div>
    @endif
</div>