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
            <a href="#"><img src="{{asset('web/img/uncle-fitter-logo.png')}}" alt="Logo"></a>
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
                @if (Auth::guest())
                <li><a href="{{ route('login') }}">Login</a></li>
                <li><a href="{{ route('register') }}">Register</a></li>
                @else
                    @role('Admin')
                        <li><a href="{{ URL('/admin/dashboard') }}">Dashboard</a></li>
                    @endrole
                    @role('User')
                        <li><a href="{{ URL('/user/dashboard') }}">Dashboard</a></li>
                    @endrole
                
                <li>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
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