@if($car && $year && $car_model && $car_trim)
<li class='col-md-3 col-sm-3 col-xs-6 no--padding'>
    <input checked disabled class='radio-custom car' type='radio' value='{{ (isset($car) && $car) ? $car->id : 0 }}' 
           name='selected_car' id='selected-car'/>
    <label class='radio-custom-label' for='selected-car'>{{ (isset($car) && $car) ? $car->brand : '' }}</label>
</li>
<li class='col-md-3 col-sm-3 col-xs-6 no--padding'>
    <input checked disabled class='radio-custom year' type='radio' value='{{ (isset($year) && $year) ? $year->id : 0 }}' 
           name='selected_year' id='selected-year'/>
    <label class='radio-custom-label' for='selected-year'>{{ (isset($year) && $year) ? $year->year : '' }}</label>
</li>
<li class='col-md-3 col-sm-3 col-xs-6 no--padding'>
    <input checked disabled class='radio-custom model' type='radio' value='{{ (isset($car_model) && $car_model) ? $car_model->id : 0 }}' 
           name='selected_model' id='selected-model'/>
    <label class='radio-custom-label' for='selected-model'>{{ (isset($car_model) && $car_model) ? $car_model->modal_name : '' }}</label>
</li>
<li class='col-md-3 col-sm-3 col-xs-6 no--padding'>
    <input checked disabled class='radio-custom trim' type='radio' value='{{ (isset($car_trim[0]) && $car_trim[0] && isset($car_trim[0]->id) && $car_trim[0]->id) ? $car_trim[0]->id : 0 }}' 
           name='selected_trim' id='selected-trim'/>
           <?php
           if ((isset($car_trim[0]) && $car_trim[0] && isset($car_trim[0]->car_trim_name) && $car_trim[0]->car_trim_name)) {
               if (strpos($car_trim[0]->car_trim_name, '(') !== false) {
                   $car_trim_name = substr(strstr($car_trim[0]->car_trim_name, '('), strlen('('));
                   $car_trim_name = str_replace(')', '', $car_trim_name);
               } else {
                   $car_trim_name = $car_trim[0]->car_trim_name;
               }
           } else {
               $car_trim_name = '';
           }
           ?>
    <label class='radio-custom-label' for='selected-trim'>{{ $car_trim_name }}</label>
</li>
@endif