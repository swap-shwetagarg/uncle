@extends('web.layouts.index')
@section('title', 'Social Registration | Uncle Fitter')
@section('content')
<div class="container-fluid no-padding header--alter">
    @include('web/blocks/partials/new_header')
</div>
<div class="container-fluid loged--in">
    <div class="container register">
        <div class="registration">
            <div class="form col-md-6 col-sm-12 col-md-offset-3">
                <h1>Social Registration</h1>
                <p>We need following information to complete </p>
                <div class='add_message'>
                    @if(count($errors))
                        @if ($errors->has('invalid_credentials'))
                            <div class='alert alert-danger'>
                                <strong>{{ $errors->first('invalid_credentials') }}</strong>
                            </div>
                        @endif
                    @endif
                </div>
                <form class="" role="form" method="GET" action="{{URL('api/auth/'.$data->provider.'/callback')}}" >
                    {{ csrf_field() }}                    
                    <input type="hidden" name="id" value="{{$data->id}}"/>
                    <input type="hidden" name="provider" value="{{$data->provider}}"/>
                    <input type="hidden" name="name" value="{{$data->name}}" >
                    <input type="hidden" name="token" value="{{$data->token}}" >
                    <div class="col-md-12 col-sm-12 log_pwd {{($errors->has('default_location'))?'has-error':''}}">
                        <select class="form-control location" name="default_location" id="default_location">
                            <option value="">Select Your Location</option>
                            @if(isset($locations) && $locations)
                                @foreach($locations AS $location)
                                    <option {{ (isset($data->default_location) && $data->default_location == $location->id) ?'selected':''}} value="{{ $location->id }}">{{ $location->zip_code }} [{{ $location->country_code }}]</option>
                                @endforeach
                            @endif
                        </select>
                        @if ($errors->has('default_location'))
                            <span class="help-block">
                                <strong>{{ $errors->first('default_location') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="col-md-12 col-sm-12 log_email {{($errors->has('email'))?'has-error':''}}">  
                        <input value="{{$data->email}}" type="email" name="email" placeholder="E-mail" rel="email" style="background:url('{{asset('web/img/msg.png')}}') no-repeat;" required>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-md-12 col-sm-12 log_email {{($errors->has('mobile'))?'has-error':''}}">
                        <div class="input-group mobile_country_code">
                            <span class="input-group-addon img">
                                <span>
                                    <img src="{{asset('web/img/mobile.png')}}" />
                                </span>
                            </span>
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
                                     @if(isset($data->mobile_country_code))
                                        <option {{ ($code == $data->mobile_country_code) ? 'selected' : '' }} value="+{{ $code }}">+{{ $code }}</option>
                                     @else 
                                        <option {{ ($code == 233) ? 'selected' : '' }} value="+{{ $code }}">+{{ $code }}</option>
                                     @endif
                                        <?php
                                    }
                                    ?>                                    
                                </select>
                            </span>
                            <input value="{{isset($data->mobile)?$data->mobile:''}}" type="text" name="mobile" placeholder="Mobile Number" rel="mobile" value="" maxlength="10" required>
                        </div>     
                        @if ($errors->has('mobile'))
                            <span class="help-block">
                                <strong>{{ $errors->first('mobile') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class='add_verification'>
                        @if(isset($data->verification_code))
                            <div class='col-md-12 col-sm-12 log_email {{($errors->has('verification_code'))?'has-error':''}}'>
                                <input type="text" name="verification_code" placeholder="Verification Code" required>
                                @if ($errors->has('verification_code'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('verification_code') }}</strong>
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div>
                    <div class="col-md-12 col-sm-12 submit--form--btn switch_button">
                        @if(isset($data->verification_code))
                            <input type="submit" name="submit" value="Submit">
                        @else
                            <input id='ResendOtpCode' type="button" name="submit" value="Send otp">
                        @endif
                    </div>
                    
                    <div class="submit--form--btn resend-code">
                        @if(isset($data->verification_code))
                            Not receive yet? Please <a href="javascript:void(0);" id="ResendOtpCode">Re-send Verification Code</a>
                        @endif
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid no-padding">
    @include('web/blocks/partials/footer')
</form>
</div>
</div>
</div>
</div>
</div>
@endsection
