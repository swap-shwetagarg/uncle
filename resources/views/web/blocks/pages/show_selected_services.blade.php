<?php
if (isset($services) && $services && sizeof($services)) {
    echo "<h1>Selected Services</h1>";
    ?>
    <ul class=" car selected_services_parent_ul" style="padding-left: 0px !important;">
        <ul class="no--padding selected_services_ul" style="padding-left: 0px !important;">
            <?php
            $_services_ids_arr = [];
            if (isset($sservice_options) && $sservice_options && sizeof($sservice_options)) {
                $services_array = [];
                foreach ($sservice_options AS $_options_key => $sservice_optionss) {
                    $_services_ids_arr[] = $_options_key;
                    foreach ($sservice_optionss as $key => $sservice_option) {
                        $service_name = $sservice_option->subservice->service->title;
                        $service_id = $sservice_option->subservice->service->id;
                        $sservice_name = $sservice_option->subservice->display_text;
                        $option_name = $sservice_option->option_name;
                        $services_array[$service_name][$sservice_name][] = $option_name;
                    }
                }
                if ($services_array && sizeof($services_array)) {
                    foreach ($services_array AS $service_name => $sservice_array) {
                        ?>
                        <li class="no--padding">                            
                            <!--<input checked="" disabled="" class="radio-custom car" type="radio">-->
                            <label class="radio-custom-label" for="selected-car">{{ $service_name }} 
                                <span class="pull-right">
                                    <a class="delete-selected-service delete_ssoption" data-id="{{$service_id}}">
                                        <img src="{{asset('web/img/dustbin.png')}}">
                                    </a>
                                </span>
                            </label>                            
                            <ul class="parent" style="padding-top: 8px;padding-bottom: 8px;">
                                <?php
                                foreach ($sservice_array AS $sservice_name => $option_array) {
                                    ?>
                                    <label style="margin: 0 !important; padding: 0 !important;" class="radio-custom-label" for="selected-car">{{ $sservice_name }}</label>
                                    <?php
                                    foreach ($option_array AS $option) {
                                        ?>
                                        <li style="border: 0;text-align: left;margin-left: 10px;">{{ $option }}</li>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                }
                                ?>
                            </ul>
                        </li>
                        <?php
                    }
                }
            }
            foreach ($services as $key => $service) {
                if (!in_array($service->id, $_services_ids_arr)) {
                    ?>
                    <li class="no--padding">
                        <!--<input checked="" disabled="" class="radio-custom car" type="radio">-->
                        <label class="radio-custom-label" for="selected-car">{{ $service->title }} <span class="pull-right"><a class="delete-selected-service" data-id="{{$service->id}}"><img src="{{asset('web/img/dustbin.png')}}"></a></span></label>
                    </li>
                    <?php
                }
            }
            ?>
        </ul>     
    </ul>                
    <?php
}?>