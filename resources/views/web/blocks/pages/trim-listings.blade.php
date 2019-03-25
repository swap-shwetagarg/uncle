<div class="col-md-12 col-sm-12 no--padding">
    <h5>Trim</h5>
    <ul id="show-trim-listing">
        <?php
        if (isset($car_trims) && $car_trims && sizeof($car_trims)) {
            foreach ($car_trims as $key => $car_trim) {
                if (strpos($car_trim->car_trim_name, '(') !== false) {
                    $car_trim_name = substr(strstr($car_trim->car_trim_name, '('), strlen('('));
                    $car_trim_name = str_replace(')', '', $car_trim_name);
                } else {
                    $car_trim_name = $car_trim->car_trim_name;
                }
                ?>
                <li class="col-md-3 col-sm-3 col-xs-4 no--padding">
                    <input class="radio-custom trim" type='radio' value='<?php echo $car_trim->id; ?>' 
                           name='trim' id='trim<?php echo $key; ?>' data-name="<?php echo $car_trim_name; ?>" />
                    <label class="radio-custom-label" for='trim<?php echo $key; ?>'><?php echo $car_trim_name; ?></label>
                </li>
                <?php
            }
        }
        ?>
    </ul>
</div>
