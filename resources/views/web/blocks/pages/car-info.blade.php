<div style="color: green">
    <?php
    echo (isset($car) && $car) ? "<strong>Brand:</strong> " . $car . ", " : '';
    echo (isset($year) && $year) ? "<strong>Make Year:</strong> " . $year . ", " : '';
    echo (isset($model) && $model) ? "<strong>Model:</strong> " . $model . ", " : '';
    echo (isset($trim) && $trim) ? "<strong>Trim:</strong> " . $trim : '';
    ?>
</div>
<div>
    <h3>Select your services</h3>
</div>
<div>
    <h4>Service Type</h4>
    <?php
    if (isset($service_types) && $service_types && sizeof($service_types)) {
        ?>
        <ul style="margin-left: 0;padding-left: 0;list-style-type: none;">
            <?php
            foreach ($service_types as $key => $service_type) {
                ?>
                <li>
                    <a href="javascript:void(0)" class="service_type" data-id="<?php echo $service_type->id; ?>">
                        <?php echo $service_type->service_type; ?>
                    </a>
                </li>
                <?php
            }
            ?>
        </ul>
        <?php
    }
    ?>
</div>