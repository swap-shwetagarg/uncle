<div class="col-md-12 col-sm-12 no--padding">
    <h5>Model</h5>
    <ul id="show-model-listing">
        <?php
        if (isset($car_models) && $car_models && sizeof($car_models)) {
            foreach ($car_models as $key => $car_model) {
                ?>
                <li class="col-md-3 col-sm-3 col-xs-4 no--padding">
                    <input class="radio-custom model" type='radio' value='<?php echo $car_model->id; ?>' 
                           name='model' id='model<?php echo $key; ?>' data-name="<?php echo $car_model->modal_name; ?>" />
                    <label class="radio-custom-label" for='model<?php echo $key; ?>'><?php echo $car_model->modal_name; ?></label>
                </li>
                <?php
            }
        }
        ?>
    </ul>
</div>
<!--<div class="dont_know"><p><a href="#">i don't know</a></p></div>-->
