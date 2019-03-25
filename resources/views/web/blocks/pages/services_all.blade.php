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

    <div id="myCarousel" class="carousel slide service-page" data-ride="carousel">
        <div class="carousel-inner slider--caption">        
            <div class="item active slider--img--big-bg" style="background-image: url({{asset('web/img/ufhomepage1.jpg')}});">
                <div class="slider--img--small" style="background: url({{ asset('web/img/about-our-mechanic-mobile.jpg') }}) no-repeat;">
                </div>
                <div class="carousel-caption">
                    <div class="col-md-8 col-md-offset-2">
                        <h3>
                            Simple or complex, we got you!
                        </h3>
                        <div class="input-group">
                            <input placeholder="Search for service or your car problem..." type="text" class="form-control input-lg" placeholder="Search" name="search-service">
                            <div class="input-group-btn">
                                <button class="btn btn-default btn-lg" type="submit">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </button>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid no-padding mechanic-community" id="about-us">
    <div class="container">
        <div class="about--us">
            <h1>Keep calm and select a service</h1>
        </div>
        <div class="steps unclefitter-services" id="unclefitter-services">
            @include('web/blocks/pages/services-lists')
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