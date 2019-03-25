@extends('web.layouts.index')
@section('title', 'Uncle Fitter | Veirify User')

@section('content')
<div class="container-fluid no-padding header--alter">
    @include('web/blocks/partials/new_header')
</div>

<div class="container redircted text-center">
    <h1>Welcome @if(Session::has('name')){{ Session::get('name') }}@endif.</h1>
    <h2>You are successfully registered as a @if(Session::has('post')){{ Session::get('post') }}@endif </h2>
    <h3>
        Please enter the verification code we sent to your mobile number or click the link we sent to your email address to verify your account.
    </h3>
    <form action="{{ URL('verify-account') }}" method="post">
        <div class="row">
            <div class="col-md-6 verify-account">
                <div class="input-group">
                    <input type="text" name="verification_code" id="verification_code" class="form-control" placeholder="Verification Code" />
                    <div class="input-group-btn">
                        {{ csrf_field() }}
                        <button class="btn btn-primary btn-md" type="submit" name="verify" id="verify">Verify Account</button>
                    </div>
                </div>
                <div class="input-group resend-code">
                    Not receive yet? Please <a href="javascript:void(0);" id="ResendVerificationCode">Re-send Verification Code</a>                    
                    @if(Session::has('message'))                    
                    <div class="alert alert-danger" id="response-message">{{ Session::get('message') }}</div>
                    @else
                    <div class="alert hidden" id="response-message"></div>
                    @endif
                </div>
            </div>
        </div>
    </form>
</div>

<div class="container-fluid no-padding">
    @include('web/blocks/partials/footer')
</div>
@endsection