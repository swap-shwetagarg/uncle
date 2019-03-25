<?php
if (isset($cars) && $cars && sizeof($cars)) {
    ?>
    <div class="car-listings-row">
        <div class="col-md-12 col-sm-12 no--padding">
            <h5>Make</h5>
            <ul id="show-car-listing">
                <?php
                foreach ($cars as $key => $car) {
                    ?>
                    <li class="col-md-3 col-sm-3 col-xs-4 no--padding">
                        <input class="radio-custom car" type='radio' value='<?php echo $car->id; ?>' 
                               name='car' id='car<?php echo $key; ?>' data-name="<?php echo $car->brand; ?>" />
                        <label class="radio-custom-label" for='car<?php echo $key; ?>'><?php echo $car->brand; ?></label>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
    </div>
    <?php
}
?>