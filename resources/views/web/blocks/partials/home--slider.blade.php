<div class="logo">
    <a href="{{ URL('/') }}">
        <img src="{{asset('web/img/uncle-fitter-logo.png')}}" alt="logo">
    </a>
</div>

<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner slider--caption">        
        <div class="item active slider--img--big-bg" style="background-image: url({{asset('web/img/ufhomepage.jpg')}});">
            <!--<img src="{{asset('web/img/uncle_fitter_mechanic.jpg')}}" class="slider--img--big">-->
            <div class="slider--img--small" style="background: url({{ asset('web/img/ufhomepage_mobile.jpg') }}) no-repeat;">                
                <!--<img src="{{asset('web/img/banner-mobile.jpg')}}" class="slider--img--small">-->
            </div>
            <div class="carousel-caption">
                <!--<h1>UNCLE FITTER</h1>-->
                <h1>YOUR MECHANIC IN YOUR POCKET</h1>
                <p>Service at your home or office, Monday to Sunday.</p>
                <a class="request-a-quote" href="{{ URL('request-a-quote') }}">REQUEST A QUOTE</a>
            </div>
        </div>
    </div>
</div>