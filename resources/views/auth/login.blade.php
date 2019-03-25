@extends('web.layouts.index')

@section('title', 'Login | Uncle Fitter')
@section('description', 'Auto service and repairs at your home or office.')
@section('keywords', '')

@section('content')
<div class="container-fluid no-padding header--alter">
    @include('web/blocks/partials/new_header')
</div>

<div class="container-fluid loged--in">
    <div class="container register">
        <div class="registration">
            <div class="form col-md-6 col-sm-6">
                <h1>Login</h1>
                <p>Welcome back!</p>
                <form class="" role="form" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}

                    <div class="col-md-12 col-sm-12 log_email {{ $errors->has('email') ? ' has-error' : '' }}">
                        <input type="test" name="email" placeholder="E-mail/Mobile Number" rel="email" style="background:url('{{asset('web/img/msg.png')}}') no-repeat;" value="{{ old('email')}}" required>
                        @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
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

                    <div class="col-md-12 col-sm-12 submit--form--btn">
                        <input type="submit" name="submit" value="LOGIN">
                    </div>

                    <div class="forget">
                        <a href="{{ route('password.request') }}">forgot password ?</a>
                    </div>

                    <div class="are--u">
                        <p>are you a mechanic? <a href="{{ URL('become/mechanic') }}">apply now</a></p>
                    </div>

                    <div class="dont--have">
                        <p>Don't have an account? <a href="{{route('register')}}">Sign up</a></p>
                    </div>

                </form>
            </div>
            <div class="form col-md-6 col-sm-6 join_now">
                <div class="signin" style="background:url('{{asset('web/img/sign-in.jpg')}}') no-repeat;">
                    <div class="sign--overlay">
                        <h2> JOIN HAPPY CAR OWNERS MANAGING THEIR CARS WITH UNCLE FITTER</h2>
                        <h3><a href="{{ url('/api/auth/facebook') }}" style="background: url('{{asset('web/img/fb.png')}}') no-repeat;">login with facebook</a></h3>
                        <h4><a href="{{ url('/api/auth/google') }}" style="background: url('{{asset('web/img/g_plus.png')}}') no-repeat;">login with google</a></h4>
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
