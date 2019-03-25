<?php
if (isset($sub_service[0]) && $sub_service[0] && sizeof($sub_service[0])) {
    $selection_type = ($sub_service[0]->selection_type == 'multiple') ? 'checkbox' : 'radio';
    $sub_service_options = $sub_service[0]->subserviceopt;
    ?>
    <div class="front--rear sub-services-option-container">
        <p>
            {{ $sub_service[0]->title }}
            <input type="hidden" name="sub_service_id_{{ $service_id }}[]" value="{{ $sub_service[0]->id }}" />                            
        </p>
        <p><small>{{ $sub_service[0]->description }}</small></p>                        
        <?php
        if (isset($sub_service_options) && $sub_service_options && sizeof($sub_service_options)) {
            ?>
            <ul class="sub-service-options-lists">
                <?php
                foreach ($sub_service_options as $key => $sub_service_option) {
                    ?>
                    <li class="col-md-3 col-sm-3 col-xs-4 no--padding diagnostics-sub-services-option">
                        <input class="radio-custom diagnostics-sub-service-option" type='{{ $selection_type }}' value='{{ $sub_service_option->id }}' 
                               name='sub_service_option_{{ $sub_service[0]->id }}[]' id='sub_service_option{{ $key }}' 
                               data-name="{{ $sub_service_option->option_name }}"
                               data-ss_id_ref="{{ $sub_service_option->sub_service_id_ref }}"
                               data-service_id="{{ $service_id }}" />
                        <label class="radio-custom-label" for='sub_service_option{{ $key }}'>{{ $sub_service_option->option_name }}</label>                                    
                    </li>
                    <?php
                }
                ?>
            </ul>
            <?php
        }
        ?>                        
    </div>
    <?php
}
?>