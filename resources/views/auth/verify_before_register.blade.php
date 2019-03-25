@extends('web.layouts.index')
@section('title', 'Uncle Fitter | Veirify User')

@section('content')
<div class="container-fluid no-padding header--alter">
    @include('web/blocks/partials/new_header')
</div>
<div class="container redircted text-center">
    <h1>Welcome @if(Session::has('name')){{ Session::get('name') }}@endif.</h1>
    <h3>
        Please enter the verification code we sent to your mobile number or click the link we sent to your email address to verify your account.
    </h3>
    <form action="{{ URL('register') }}" method="post" class="verify_user_form">
        <div class="row">
            <div class="col-md-6 verify-account">
                <div class='add_message'></div>
                @if ($errors->has('verification_code'))
                        <span class="help-block">
                            <strong class='text-danger'>{{ $errors->first('verification_code') }}</strong>
                        </span>
                    @endif
                <div class="input-group {{ $errors->has('verification_code') ? ' has-error' : '' }}">
                    <input type="text" name="verification_code" id="verification_code" class="form-control" placeholder="Verification Code" />
                    <div class="input-group-btn">
                        {{ csrf_field() }}
                        <button class="btn btn-primary btn-md" type="submit" name="verify" id="verify">Verify Account</button>
                    </div>
                </div>
                <div class="input-group resend-code">
                    Not receive yet? Please <a href="javascript:void(0);" id="ResendOtpCode">Re-send Verification Code</a>                    
                    @if(Session::has('message'))                    
                        <div class="alert alert-danger" id="response-message">{{ Session::get('message') }}</div>
                    @else
                    <div class="alert hidden" id="response-message"></div>
                    @endif
                </div>
            </div>
        </div>
        @if (Session::has('uf_user_verification')) 
            <?php $data = Session::get('uf_user_verification');?>
            <input type="hidden" value="{{$data[0]['email']}}" name='email'>
            <input type="hidden" value="{{$data[0]['name']}}" name='name'>
            <input type="hidden" value="{{$data[0]['password']}}" name='password'>
            <input type="hidden" value="{{$data[0]['password_confirmation']}}" name='password_confirmation'>
            <input type="hidden" value="{{$data[0]['mobile']}}" name='mobile'>
            <input type="hidden" value="{{$data[0]['referral_id']}}" name='referral_id'>
            <input type="hidden" value="{{$data[0]['default_location']}}" name='default_location'>
            @if(isset($data[0]['role']))
                <input type="hidden" value="{{$data[0]['role']}}" name='role'>
            @endif
            <input type="hidden" value="{{$data[0]['mobile_country_code']}}" name='mobile_country_code'>
        @endif
    </form>
</div>
<div class="container-fluid no-padding">
    @include('web/blocks/partials/footer')
</div>
@endsection