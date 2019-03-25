<nav class="header--for navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>                        
            </button>
        </div>
        <div class="logo">
            <a href="{{URL('/')}}"><img src="{{asset('web/img/uncle-fitter-logo.png')}}" alt="logo"></a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">How it works</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Advice</a></li>
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
                @if (Auth::guest())
                <li><a href="{{route('login')}}">Sign In</a></li>
                <li><a href="{{route('register')}}">Sign Up</a></li>
                @else
                <li><a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">LogOut</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
                @endif
            </ul>
        </div>
    </div>
</nav>