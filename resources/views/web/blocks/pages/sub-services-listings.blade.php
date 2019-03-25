<?php if (isset($service) && $service && sizeof($service)) { ?>
    <div class="sub-service-parent{{ $service[0]->id }}">
        <div class="row sub-service-row">
            <div class="on--off">     
                @if(isset($service[0]->title) && $service[0]->title)
                <div class="col-md-11 text-left">
                    <p>{{ $service[0]->title }}</p>
                </div>
                @endif

                @if(isset($service[0]->id) && $service[0]->id)
                <div class="col-md-1 text-right">
                    <a href="javascript: void(0);" class="delete-selected-service" data-id="{{ $service[0]->id }}">
                        <img src="{{asset('web/img/dustbin.png')}}">
                    </a>
                </div>
                @endif

                @if(isset($service[0]->description) && $service[0]->description)
                <div class="your--service your-selected-service">
                    <div class="col-md-12 text-center">
                        <a href="javascript:void(0)" class="view-service-description">View Service Description</a>
                    </div>
                    <div class="col-md-12 hidden view-service-description-div">
                        <?php echo html_entity_decode($service[0]->description); ?>
                    </div>
                </div>
                @endif
            </div>
        </div>    
        <?php
        $sub_services = $service[0]->subservice;
        if (isset($sub_services) && $sub_services && sizeof($sub_services)) {
            $total_sub_services = count($sub_services);
            foreach ($sub_services as $parent_key => $sub_service) {
                $selection_type = ($sub_service->selection_type == 'M') ? 'checkbox' : 'radio';
                $sub_service_options = $sub_service->subserviceopt;
                ?>
                <div class="row">
                    <div class="front--rear sub-services-option-container">
                        <p>
                            {{ $sub_service->title }} <span class="sub-service-steps">{{ $parent_key+1 }}/{{ $total_sub_services }}</span>
                            <input type="hidden" name="sub_service_id_{{ $service[0]->id }}[]" value="{{ $sub_service->id }}" />
                        </p>
                        <?php
                        if (isset($sub_service_options) && $sub_service_options && sizeof($sub_service_options)) {
                            ?>
                            <ul class="sub-service-options-lists">
                                <?php
                                foreach ($sub_service_options as $key => $sub_service_option) {
                                    ?>
                                    <li class="col-md-3 col-sm-3 col-xs-4 no--padding sub-services-option">
                                        <input class="radio-custom sub-service-option" type='{{ $selection_type }}' data-service_id="{{ $sub_service_option->subservice->service->id }}" data-sub_service_id="{{ $sub_service_option->subservice->id }}" value='{{ $sub_service_option->id }}' 
                                               name='sub_service_option_{{ $sub_service->id }}[]' id='sub_service_option{{ $parent_key."".$key }}' data-name="{{ $sub_service_option->option_name }}" />
                                        <label class="radio-custom-label" for='sub_service_option{{ $parent_key."".$key }}'>{{ $sub_service_option->option_name }}</label>                                    
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                            <?php
                        }
                        ?>                        
                    </div>
                </div>
                <?php
            }
        }
        ?>
    </div>
    <?php
}
?>
@if(isset($selected_service) && count($selected_service))
    @foreach($selected_service as $ser)
        <input type="hidden" name="service_id[]" value="{{ $ser}}" />
    @endforeach
@endif
