@extends('web.layouts.index')

@section('title', 'Search Services | Uncle Fitter')
@section('description', 'Forget the repair shop hassle. Our highly skilled mobile mechanics come to you at your most convenient location and time.')

@section('content')
<div class="container-fluid no-padding about-our-mechanic">
    @include('web/blocks/pages/navbar-alt')

    <div class="logo">
        <a href="{{ URL('/') }}">
            <img src="{{asset('web/img/uncle-fitter-logo.png')}}" alt="logo">
        </a>
    </div>

    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner slider--caption">        
            <div class="item active slider--img--big-bg" style="background-image: url({{asset('web/img/ufhomepage1.jpg')}});">
                <div class="slider--img--small" style="background: url({{ asset('web/img/about-our-mechanic-mobile.jpg') }}) no-repeat;">
                </div>
                <div class="carousel-caption">
                    <div class="container">
                        <div class="row">
                            <h1>Get your car inspected at your home or office.</h1>
                        </div>
                         <div class="row">
                            <div class="get-help">
                                <img src="{{asset('web/img/help.png')}}" alt="help">
                                <a href="{{ URL('request-a-quote?request_book='.$data->id) }}">REQUEST A QUOTE</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid no-padding mechanic-community" id="about-us">
    <div class="container unclefitter-service">
        <div class="about--us">
            <h1>{{{ $data->title or '' }}}</h1>
        </div>
        <div class="steps">
            @if(isset($data))
                {!! $data->description !!}
            @endif
        </div>
    </div>
</div>

<div class="container-fluid no-padding bg--color" id="more">
    @include('web/blocks/partials/how--we--help')
</div>

<div class="container-fluid no-padding">
    @include('web/blocks/partials/footer')
</div>

@endsection