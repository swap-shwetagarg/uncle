<div class="col-md-12 col-sm-12 no--padding">
    <h5>Year</h5>
    <ul id="show-year-listing">
        <?php
        if (isset($years) && $years && sizeof($years)) {
            foreach ($years as $key => $year) {
                ?>
                <li class="col-md-3 col-sm-3 col-xs-4 no--padding">
                    <input class="radio-custom year" type='radio' value='<?php echo $year->id; ?>' 
                           name='year' id='year<?php echo $key; ?>' data-name="<?php echo $year->year; ?>" />
                    <label class="radio-custom-label" for='year<?php echo $key; ?>'><?php echo $year->year; ?></label>
                </li>
                <?php
            }
        }
        ?>
    </ul>
</div>
<!--<div class="dont_know"><p><a href="#">i don't know</a></p></div>-->
