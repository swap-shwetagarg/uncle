<?php
if (isset($service) && $service && sizeof($service)) {
    $temp_array = [];
    if (isset($service[0]->subservice) && $service[0]->subservice && !$service[0]->subservice->isEmpty()) {
        foreach ($service[0]->subservice as $key => $sub_services_diagnostic) {
            $temp_array_ss = [];
            $temp_array_ss['sub_service_id'] = $sub_services_diagnostic->id;
            $temp_array_ss['sub_service_name'] = $sub_services_diagnostic->title;
            $temp_array_ss['sub_service_desc'] = $sub_services_diagnostic->description;
            if (isset($sub_services_diagnostic->subserviceopt) && $sub_services_diagnostic->subserviceopt && !$sub_services_diagnostic->subserviceopt->isEmpty()) {
                $temp_array2 = [];
                foreach ($sub_services_diagnostic->subserviceopt as $key => $option_diagnostic) {
                    $temp_array3 = [];
                    $temp_array3['option_id'] = $option_diagnostic->id;
                    $temp_array3['option_name'] = $option_diagnostic->option_name;
                    $temp_array3['sub_service_id'] = $option_diagnostic->sub_service_id;
                    $temp_array3['sub_service_id_ref'] = $option_diagnostic->sub_service_id_ref;
                    $temp_array3['option_description'] = $option_diagnostic->option_description;
                    $temp_array3['recommend_service_id'] = $option_diagnostic->recommend_service_id;
                    $temp_array2[] = $temp_array3;
                }
                $temp_array_ss['sub_service_options'] = $temp_array2;
            }
            $temp_array1['sub_service_' . $sub_services_diagnostic->id] = $temp_array_ss;
        }
    }
    $services_json_string = json_encode($temp_array1);
    ?>
    <script type="text/javascript">
        var sub_services_json = <?php echo $services_json_string; ?>;
    </script>

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

                <input type="hidden" name="service_id[]" value="{{ $service[0]->id }}" />
            </div>
        </div>
        <?php
        $sub_services = $service[0]->subservice->first();
        if (isset($sub_services) && $sub_services && sizeof($sub_services)) {
            $selection_type = ($sub_services->selection_type == 'M') ? 'checkbox' : 'radio';
            $sub_service_options = $sub_services->subserviceopt;
            ?>
            <div class="row sub-services-container diagnostics-sub-services-container">
                <div class="front--rear sub-services-option-container sub-service-{{ $sub_services->id }}">
                    <p>
                        {{ $sub_services->title }}
                        <input type="hidden" name="sub_service_id_{{ $service[0]->id }}[]" value="{{ $sub_services->id }}" />                            
                    </p>
                    <p><small>{{ strip_tags(urldecode($sub_services->description)) }}</small></p>
                    <?php
                    if (isset($sub_service_options) && $sub_service_options && sizeof($sub_service_options)) {
                        ?>
                        <ul class="sub-service-options-lists">
                            <?php
                            foreach ($sub_service_options as $key => $sub_service_option) {
                                $recommend_service_id = $sub_service_option->recommend_service_id;
                                $option_type = $sub_service_option->option_type;
                                if ($option_type == 2) {
                                    $option_image = $sub_service_option->option_image;
                                    ?>
                                    <img class="radio-custom diagnostics-sub-service-option-img" 
                                         src="{{ asset($option_image) }}"
                                         id='sub_service_option{{ $sub_services->id }}{{ $key }}'
                                         data-name="{{ $sub_service_option->option_name }}"
                                         data-ss_id_ref="{{ $sub_service_option->sub_service_id_ref }}"
                                         data-service_id="{{ $service[0]->id }}"
                                         data-sub_service_id="{{ $sub_services->id }}"
                                         data-value="{{ $sub_service_option->id }}"
                                         data-parent="1" style="float: left;"
                                         data-recommend_service_id="{{ ($recommend_service_id && $recommend_service_id != '') ? $recommend_service_id: '' }}" />
                                         <?php
                                     } else {
                                         ?>
                                    <li class="col-md-3 col-sm-3 col-xs-4 no--padding sub-services-option">
                                        <input class="radio-custom diagnostics-sub-service-option" 
                                               type='{{ $selection_type }}' 
                                               value='{{ $sub_service_option->id }}' 
                                               name='sub_service_option_{{ $sub_services->id }}[]' 
                                               id='sub_service_option{{ $sub_services->id }}{{ $key }}' 
                                               data-name="{{ $sub_service_option->option_name }}"
                                               data-ss_id_ref="{{ $sub_service_option->sub_service_id_ref }}"
                                               data-service_id="{{ $service[0]->id }}"
                                               data-sub_service_id="{{ $sub_services->id }}"
                                               data-recommend_service_id="{{ ($recommend_service_id && $recommend_service_id != '') ? $recommend_service_id: '' }}"
                                               data-parent="1" />
                                        <label class="radio-custom-label" for='sub_service_option{{ $sub_services->id }}{{ $key }}'>{{ $sub_service_option->option_name }}</label>                                    
                                    </li>
                                    <?php
                                }
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
        ?>
    </div>
    <?php
}
?>