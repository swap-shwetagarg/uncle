@extends('web.layouts.index')

@section('title', 'Auto Repair by Professional Mechanics | Uncle Fitter')
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
            <div class="item active slider--img--big-bg" style="background-image: url({{asset('web/img/about-our-mechanic.jpg')}});">
                <div class="slider--img--small" style="background: url({{ asset('web/img/about-our-mechanic-mobile.jpg') }}) no-repeat;">
                </div>
                <div class="carousel-caption">
                    <h1>The Best on the block</h1>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="container-fluid no-padding mechanic-community" id="about-us">
    <div class="container">
        <div class="about--us">
            <h1>Network of the best mechanics in the city.</h1>
        </div>
        <div class="steps">
            <div class="row drawingB oneTwo_img">
                <div class="col-md-8 col-sm-12 col-xs-12 about--our-mechanic">
                    <p>All our mechanics have at least five years experience and have worked with an automotive service and repair center in the past. </p>
                    <p>We carefully vet all of our mechanics with background, criminal, and reference checks. </p>
                    <p>We constantly monitor the performance of our mechanics to make sure they’ll provide you with professional and courteous service. </p>
                    <p>At UncleFitter, you can trust the people who are working on your car.</p>
                </div>
                <div class="col-md-4 col-sm-12 col-xs-12 ">
                    <img src="{{asset('web/img/drawing2.jpg')}}" alt="drawing2">
                </div>
            </div>
        </div>
    </div>
</div>

<!--
<div class="container-fluid no-padding meet-our-mechanics" id="about-us">
    <div class="container">
        <div class="about--us">
            <h1>Meet some of our mechanics</h1>
        </div>
        <div class="">
            <div class="row drawingB oneTwo_img">
                <div class="col-md-4 col-sm-4 col-xs-12 text-center meet-our-mechanic">
                    <img src="{{asset('web/img/dummy-mechanic.png')}}" alt="drawing2" width="75" height="75">
                    <h4>Mechanic Name</h4>
                    <div class="star-ratings-sprite">
                        <span style="width:52%" class="star-ratings-sprite-rating"></span>
                    </div>
                    <div class="speciality">
                        <p>
                            Mechanic has worked at Volvo, Honda, Acura, Lexus, and Toyota. He has 20 years of experience and specializes in diagnostics.
                        </p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12 text-center meet-our-mechanic">
                    <img src="{{asset('web/img/dummy-mechanic.png')}}" alt="drawing2" width="75" height="75">
                    <h4>Mechanic Name</h4>
                    <div class="star-ratings-sprite">
                        <span style="width:62%" class="star-ratings-sprite-rating"></span>
                    </div>
                    <div class="speciality">
                        <p>
                            Mechanic has worked at Volvo, Honda, Acura, Lexus, and Toyota. He has 20 years of experience and specializes in diagnostics.
                        </p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12 text-center meet-our-mechanic">
                    <img src="{{asset('web/img/dummy-mechanic.png')}}" alt="drawing2" width="75" height="75">
                    <h4>Mechanic Name</h4>
                    <div class="star-ratings-sprite">
                        <span style="width:80%" class="star-ratings-sprite-rating"></span>
                    </div>
                    <div class="speciality">
                        <p>
                            Mechanic has worked at Volvo, Honda, Acura, Lexus, and Toyota. He has 20 years of experience and specializes in diagnostics.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
-->

<div class="container-fluid no-padding bg--color" id="more">
    @include('web/blocks/partials/how--we--help')
</div>
<div class="container-fluid no-padding">
    @include('web/blocks/partials/footer')
</div>

@endsection