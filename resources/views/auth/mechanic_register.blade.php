@extends('web.layouts.index')

@section('title', 'Mechanic Jobs | Careers Uncle Fitter')
@section('description', 'Are you a professional mechanic? Join our exclusive mobile mechanic team and take you career to the next level')

@section('content')

<div class="container-fluid no-padding become-a-mechanic-page">
    @include('web/blocks/pages/navbar-alt')

    <div class="logo">
        <a href="{{ URL('/') }}">
            <img src="{{asset('web/img/uncle-fitter-logo.png')}}" class="logo-alt" alt="logo">
        </a>
    </div>

    <div id="myCarousel" class="carousel slide become-a-mechanic-div" data-ride="carousel">
        <div class="carousel-inner slider--caption">
            <div class="item active slider--img--big-bg" style="background-image: url({{asset('web/img/mechanic.jpg')}});">
                <div class="slider--img--small" style="background: url({{ asset('web/img/ufhomepage_mobile.jpg') }}) no-repeat;"></div>

                <div class="carousel-caption become-a-mechanic">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-8 caption-text">
                                <p>Are you an auto-technician/mobile mechanic?</p>
                                <p>If you think you have got the skills and experience it takes to</p>
                                <h1>Join the Exclusive Team Of Mobile Mechanics in the City</h1>
                                <p>Apply now and we will take you through our vetting process.</p>
                                <p>Now, you can be your own boss and work only when you want.</p>
                                <p>Full time or part-time when you are free.</p>
                                <ul>
                                    <li>* Two days a week</li>
                                    <li>* Five days a week</li>
                                    <li>* Evenings and weekends</li>
                                    <li>* Whatever!</li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <div class="reset-password-form">
                                    <div class="registration">
                                        <div class="form col-md-12 col-sm-12">
                                            <h1>Apply As A Mechanic</h1>
                                            <form class="mechanic-registration-form" role="form" method="POST" action="{{ route('register') }}">
                                                {{ csrf_field() }}

                                                <div class="col-md-12 col-sm-12 log_email {{ $errors->has('name') ? ' has-error' : '' }}">
                                                    <input type="text" name="name" placeholder="Name" rel="name" style="background:url('{{asset('web/img/user_a.png')}}') no-repeat;" value="{{ old('name')}}" required>
                                                    @if ($errors->has('name'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('name') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>

                                                <div class="col-md-12 col-sm-12 log_email {{ $errors->has('email') ? ' has-error' : '' }}">
                                                    <input type="email" name="email" placeholder="Email (Optional)" rel="email" style="background:url('{{asset('web/img/msg.png')}}') no-repeat;" value="{{ old('email')}}" required>
                                                    @if ($errors->has('email'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>

                                                <div class="col-md-12 col-sm-12 log_email {{ $errors->has('mobile') ? ' has-error' : '' }}">
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
                                                                    <option {{ ($code == 233) ? 'selected' : '' }} value="+{{ $code }}">+{{ $code }}</option>
                                                                    <?php
                                                                }
                                                                ?>                                    
                                                            </select>
                                                        </span>
                                                        <input type="text" class="form-control" name="mobile" placeholder="Mobile Number" rel="mobile" value="{{ old('mobile')}}" maxlength="10" required>                            
                                                    </div>
                                                    <div>
                                                        @if ($errors->has('mobile'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('mobile') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-md-12 col-sm-12 log_pwd {{ $errors->has('password') ? ' has-error' : '' }}">
                                                    <input name="password" placeholder="Password" rel="password" style="background:url('{{asset('web/img/lock.png')}}') no-repeat;"  
                                                           type="password" required>

                                                    @if ($errors->has('password'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>

                                                <div class="col-md-12 col-sm-12 log_pwd">
                                                    <input name="password_confirmation" placeholder="Confirm Password" rel="password" style="background:url('{{asset('web/img/lock.png')}}') no-repeat;"  
                                                           type="password" required>
                                                </div>                   

                                                <div class="col-md-12 col-sm-12 submit--form--btn">
                                                    <input type="hidden" name="default_location" value="1">
                                                    <input type="submit" name="submit" value="APPLY">
                                                </div>

                                                <input type="hidden" name="role" value="Mechanic">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid no-padding">
    @include('web/blocks/partials/footer')
</div>
@endsection
