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
                <li class="menu-item">
                    <a href="{{ URL('/') }}">Home</a>
                </li>
                <li class="menu-item">
                    <a href="{{ URL('services') }}">Services</a>
                </li>
                <li class="menu-item has-child">
                    <a href="#more">More</a>
                    <ul class="sub-menu">
                        <li class="sub-menu-item">
                            <a href="{{URL('blog')}}">Blog</a>
                        </li>
                        <li class="sub-menu-item">
                            <a href="{{URL('about-our-mechanics')}}">Our Mechanics</a>
                        </li>
                        <li class="sub-menu-item">
                            <a href="{{URL('faq')}}">FAQ</a>
                        </li>
                    </ul>
                </li>
                @if(Auth::guest())
                <li class="menu-item"><a href="{{URL('login')}}">Sign In</a></li>
                <li class="menu-item"><a href="{{URL('register')}}">Sign Up</a></li>
                @else
                @role('Admin')
                <li><a href="{{ URL('/admin/dashboard') }}">Dashboard</a></li>
                @endrole
                @role('User')
                <li><a href="{{ URL('/user/dashboard') }}">Dashboard</a></li>
                @endrole
                <li class="menu-item">          
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