<?php
$_services_ids_arr = [];
if (isset($sservice_options) && $sservice_options && sizeof($sservice_options)) {
    $services_array = [];
    foreach ($sservice_options AS $_options_key => $sservice_optionss) {
        $_services_ids_arr[] = $_options_key;
        foreach ($sservice_optionss as $key => $sservice_option) {
            $service_name = $sservice_option->subservice->service->title;
            $sservice_name = $sservice_option->subservice->display_text;
            $option_name = $sservice_option->option_name;
            $services_array[$service_name][$sservice_name][] = $option_name;
        }
    }

    if ($services_array && sizeof($services_array)) {
        ?>
        <div class="selected-services-row">
            <ul class="grand-parent" style="padding-left: 0 !important;">
                <?php
                $i = 1;
                $size_array = sizeof($services_array);
                foreach ($services_array AS $service_name => $sservice_array) {
                    if ($i < $size_array) {
                        ?>
                        <li style="padding-bottom: 15px;border-bottom: 1px solid #cccccc91;">
                            <?php
                        } else {
                            ?>    
                        <li>
                            <?php
                        }
                        ?>
                        <h4>{{ $service_name }}</h4>
                        <ul class="parent">
                            <?php
                            foreach ($sservice_array AS $sservice_name => $option_array) {
                                ?>                                
                                <label style="display: block !important;width: 100%;margin: 0;padding: 0;margin-left: -12px;font-weight: 700 !important;">
                                    {{ $sservice_name }}
                                </label>
                                <?php
                                foreach ($option_array AS $option) {
                                    ?>
                                    <li>
                                        <i class="fa fa-hand-o-right" aria-hidden="true"></i> {{ $option }}
                                    </li>
                                    <?php
                                }
                                ?>
                                <?php
                            }
                            ?>
                        </ul>
                    </li>
                    <?php
                    $i++;
                }
                ?>
            </ul>
        </div>
        <?php
    }
}
if (isset($services) && $services && sizeof($services)) {
    foreach ($services as $key => $service) {
        if (!in_array($service[0]->id, $_services_ids_arr)) {
            ?>
            <div class="selected-services-row selected-services selected-services-review">
                <?php
                $sub_services = $service[0]->subservice;
                $service_name = $service[0]->title;
                $service_description = $service[0]->description;
                ?>
                <h4>{{ $service_name }}</h4>
                <!--
                @if(isset($service_description) && $service_description)
                <p>
                <?php //echo html_entity_decode($service_description); ?>
                </p>
                -->
                @endif
                @if(isset($sub_services) && $sub_services && sizeof($sub_services))
                <ul class="child">
                    <?php
                    $total_sub_services = count($sub_services);
                    foreach ($sub_services as $parent_key => $sub_service) {
                        ?>
                        <li>
                            <i class="fa fa-hand-o-right" aria-hidden="true"></i> {{ $sub_service->title }}
                        </li>
                        <?php
                    }
                    ?>
                </ul>
                @endif                    
            </div>
            <?php
        }
    }
}
if (isset($own_service_description) && $own_service_description && sizeof($own_service_description)) {
    ?>
    <h3>Custom Service Description</h3>
    <p>
        {{ $own_service_description }}
        <input type="hidden" name="own_service_description" value="{{ $own_service_description }}">
    </p>
    <?php
}
?>
@if (Auth::guest())
<div class="row select-action-row">
    <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12">
            <label for="already_user">
                <input type="radio" name="user" id="already_user" value="already" />
                Already have an account? Please login          
            </label>
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12">
            <label for="new_user">
                <input type="radio" name="user" id="new_user" value="new" />
                Don't have an account? Please register
            </label>
        </div>
    </div>
    <div class="row social-login">
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="sign--overlay">
                <h4>
                    <a class="facebook" href="{{ url('/api/auth/facebook?_b') }}" style="background: url('{{asset('web/img/fb.png')}}') no-repeat;">
                        login with facebook
                    </a>
                </h4>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="sign--overlay">
                <h4>
                    <a class="google" href="{{ url('/api/auth/google?_b') }}" style="background: url('{{asset('web/img/g_plus.png')}}') no-repeat;">
                        login with google
                    </a>
                </h4>
            </div>
        </div>
    </div>
</div>

<!-- REGISTER FORM -->
<div class="row hidden" id="new-user-container">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <h3>Please register here</h3>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" name="name" id="name" placeholder="Full Name" class="form-control" />
                <span class="hidden error-msg signup-name-error-msg"></span>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="email_address">Email Address</label>
                <input type="text" name="email_address" id="email_address" placeholder="Email Address" class="form-control" />
                <span class="hidden error-msg signup-email-error-msg"></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12">
            <label for="mobile">Mobile Number</label>
            <div class="input-group mobile_country_code">
                <span class="input-group-addon code">
                    <select name="mobile_country_code" id="mobile_country_code" class="form-control">
                        <?php
                        $calling_codes = [93, 355, 213, 684, 376, 244, 809, 268, 54, 374, 297, 247, 61, 672, 43, 994, 242, 246, 973, 880, 375, 32,
                            501, 229, 809, 975, 284, 591, 387, 267, 55, 284, 673, 359, 226, 257, 855, 237, 1, 238, 1, 345, 238, 236, 235, 56, 86, 886,
                            57, 269, 242, 682, 506, 385, 53, 357, 420, 45, 246, 767, 809, 253, 593, 20, 503, 240, 291, 372, 251, 500, 298, 679, 358,
                            33, 596, 594, 241, 220, 995, 49, 233, 350, 30, 299, 473, 671, 502, 224, 245, 592, 509, 504, 852, 36, 354, 91, 62, 98, 964,
                            353, 972, 39, 225, 876, 81, 962, 7, 254, 855, 686, 82, 850, 965, 996, 371, 856, 961, 266, 231, 370, 218, 423, 352, 853, 389,
                            261, 265, 60, 960, 223, 356, 692, 596, 222, 230, 269, 52, 691, 373, 33, 976, 473, 212, 258, 95, 264, 674, 977, 31, 599, 869,
                            687, 64, 505, 227, 234, 683, 850, 1670, 47, 968, 92, 680, 507, 675, 595, 51, 63, 48, 351, 1787, 974, 262, 40, 7, 250, 670,
                            378, 239, 966, 221, 381, 248, 232, 65, 421, 386, 677, 252, 27, 34, 94, 290, 869, 508, 249, 597, 268, 46, 41, 963, 689, 886, 7,
                            255, 66, 228, 690, 676, 1868, 216, 90, 993, 688, 256, 380, 971, 44, 598, 1, 7, 678, 39, 58, 84, 1340, 681, 685, 381, 967, 381, 243, 260, 263];
                        foreach ($calling_codes as $key => $code) {
                            ?>
                            <option {{ ($code == 233) ? 'selected' : '' }} value="+{{ $code }}">+{{ $code }}</option>
                            <?php
                        }
                        ?>                                    
                    </select>
                </span>
                <input type="text" name="mobile" id="mobile" placeholder="Mobile" class="form-control" />                
            </div>
            <span class="hidden error-msg signup-mobile-error-msg"></span>
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="npassword">New Password</label>
                <input type="password" name="npassword" id="npassword" placeholder="Password" class="form-control" />
                <span class="hidden error-msg signup-password-error-msg"></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" class="form-control" />
                <span class="hidden error-msg signup-cpassword-error-msg"></span>
            </div>
        </div>

        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="default_location">Select Location</label>
                <select class="form-control" name="default_location" id="default_location">
                    <option value="">Select Location</option>
                    @if(isset($locations) && $locations)
                    @foreach($locations AS $location)
                    <option {{ (isset($location_id) && $location_id && $location_id == $location->id) ? 'selected' : ''  }} value="{{ $location->id }}">{{ $location->zip_code }} [{{ $location->country_code }}]</option>
                    @endforeach
                    @endif
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                {{ csrf_field() }}
                <button type="button" name="signup" id="signup" data-loading-text="Loading..." class="btn btn-primary review-and-book">Sign Up</button>
            </div>
        </div>
    </div>
</div>

<!-- Verify Account by Verification Code --> 
<div class="row hidden" id="verify-user-container">
    <div class="row">
        <div class="col-md-10 col-sm-12 col-xs-12">
            <div class="input-group">
                <input type="text" name="verification_code" id="verification_code" class="form-control" placeholder="Verification Code" />
                <div class="input-group-btn">
                    {{ csrf_field() }}
                    <button class="btn btn-primary btn-md" type="button" name="verify" id="verify">Verify Account</button>
                </div>
            </div>
            <div class="input-group resend-code">
                Not receive yet? Please <a href="javascript:void(0);" id="ResendVerificationCode">Re-send Verification Code</a>
                <div class="alert hidden" id="response-message"></div>
            </div>
        </div>
    </div>
</div>

<!-- LOGIN FORM -->
<div class="row hidden" id="already-user-container">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <h3>Please login here</h3>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="email"></label>
                <input type="email" name="email" id="email" placeholder="Email/Mobile" class="form-control" />
                <span class="hidden error-msg login-email-error-msg"></span>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="password"></label>
                <input type="password" name="password" id="password" placeholder="Password" class="form-control" />
                <span class="hidden error-msg login-password-error-msg"></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                {{ csrf_field() }}
                <button type="button" name="signin" id="signin" data-loading-text="Loading..." class="btn btn-primary review-and-book">Sign In</button>
            </div>
        </div>
    </div>
</div>

<div class="row hidden" id="user-error-container">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="alert"></div>
        </div>
    </div>
</div>

<div class="row hidden" id="submit-quote-container">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="form-group">
            <button type="submit" name="submit_quote" id="submit-quote" class="btn btn-primary review-and-book">Request Quote</button>
        </div>
    </div>
</div>
@else
<div class="row" id="submit-quote-container">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="form-group">
            <button type="submit" name="submit_quote" id="submit-quote" class="btn btn-primary review-and-book">Request Quote</button>
        </div>
    </div>
</div>
@endif