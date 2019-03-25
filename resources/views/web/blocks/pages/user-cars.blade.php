<?php
if (isset($user_cars) && $user_cars && sizeof($user_cars)) {
    ?>
    <div class="user-cars-row">
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <select class="form-control" name="selected_user_car" id="selected-user-car">
                    <option value="">Select Your Car</option>
                    <?php
                    foreach ($user_cars AS $user_car) {
                        if (strpos($user_car->usercars->car_trim_name, '(') !== false) {
                            $car_trim_name = substr(strstr($user_car->usercars->car_trim_name, '('), strlen('('));
                            $car_trim = str_replace(')', '', $car_trim_name);
                        } else {
                            $car_trim = $user_car->usercars->car_trim_name;
                        }

                        $car_name = $user_car->usercars->carmodel->years->year . " "
                                . $user_car->usercars->carmodel->years->cars->brand . " "
                                . $user_car->usercars->carmodel->modal_name . " "
                                . $car_trim;
                        ?>
                        <option value="{{ $user_car->usercars->id }}">{{ $car_name }}</option>
                        <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <button class="btn btn-primary add-new-car" type="button" data-loading-text="Loading...">Add New Car</button>
        </div>
    </div>
    <?php
}
?>