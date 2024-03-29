@extends('web.layouts.index')

@section('title', 'Reset Password | Uncle Fitter')
@section('description', 'Reset your password')
@section('keywords', '')

@section('content')
<div class="container-fluid no-padding header--alter">
	@include('web/blocks/partials/new_header')
</div>

<div class="container-fluid loged--in">
	<div class="reset-password-form">
		<div class="registration">
		    <div class="form col-md-12 col-sm-12">
                        
		        <h1>Reset Password</h1>
		        <p>Welcome!</p>
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
		        <form class="" role="form" method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}

			        <div class="col-md-12 col-sm-12 log_email {{ $errors->has('email') ? ' has-error' : '' }}">
			            <input type="email" name="email" placeholder="E-mail" rel="email" style="background:url('{{asset('web/img/msg.png')}}') no-repeat;" value="{{ old('email')}}" required>
			            @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
			        </div>

			        <div class="col-md-12 col-sm-12 submit--form--btn">
			            <input type="submit" name="submit" value="SEND RESET LINK">
			        </div>
		        </form>
		    </div>
		</div>
	</div>
</div>

<div class="container-fluid no-padding">
    @include('web/blocks/partials/footer')
</div>
@endsection
