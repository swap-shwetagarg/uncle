<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>                        
            </button>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#how-it-works">How it works</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#about-us">About Us</a></li>
                <li class="menu-item has-child">
                    <a href="#more">More</a>
                    <ul class="sub-menu">
                        <li class="sub-menu-item">
                            <a href="{{URL('blog')}}">Blog</a>
                        </li>
                        <li class="sub-menu-item">
                            <a href="{{URL('about-our-mechanic')}}">About Our Mechanic</a>
                        </li>
                    </ul>
                </li>
                @if(Auth::guest())
                <li><a href="{{URL('login')}}">Sign In</a></li>
                <li><a href="{{URL('register')}}">Sign Up</a></li>
                @else
                <li><a href="{{URL('/user')}}">Dashboard</a></li>
                <li>          
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

<div class="logo">
    <a href="{{ URL('/') }}"><img src="{{asset('web/img/uncle-fitter-logo.png')}}" alt="Logo"></a>
</div>

<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner slider--caption">        
        <div class="item active slider--img--big-bg" style="background-image: url({{asset('web/img/ufhomepage.jpg')}});">
            <!--<img alt"uncle fitter mechanic" src="{{asset('web/img/uncle_fitter_mechanic.jpg')}}" class="slider--img--big">-->
            <div class="slider--img--small" style="background: url({{ asset('web/img/ufhomepage_mobile.jpg') }}) no-repeat;">                
                <!--<img src="{{asset('web/img/banner-mobile.jpg')}}" class="slider--img--small" alt="Banner mobile">-->
            </div>
        </div>
    </div>
</div>