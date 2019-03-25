@include('includes.header')
<body class="hold-transition sidebar-mini">
    <div id="app" class="wrapper">
        <header class="main-header"> 
            <!-- Authentication Links -->
            @if (Auth::guest())
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{ route('login') }}">Login</a></li>
                <li><a href="{{ route('register') }}">Register</a></li>
            </ul>
            @else
            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top">
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="pe-7s-keypad"></span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- Notifications -->
                        @role('Admin')
                            <li class="dropdown notifications-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="pe-7s-speaker" data-count="{{BookingCount::whereStatus(4)->count()}}"></i>
                                <span class="label label-warning">{{BookingCount::whereStatus(4)->count()}}</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">You have {{BookingCount::whereStatus(4)->count()}} pending Bookings</li>
                                    <li>
                                        <ul class="menu">
                                        @if(isset($timeDiffers) && count($timeDiffers)>0)
                                            @foreach($timeDiffers as $timeDiffer)
                                                <li><a href="#"><i class="ti-announcement color-green"></i> You got a booking before ({{$timeDiffer}}) </a></li>
                                            @endforeach
                                        @endif
                                        </ul>
                                    </li>
                                    <li class="footer"><a href="#">View all</a></li>
                                </ul>
                            </li>
                        @endrole

                        @role('User')
                        <li>
                            @if( Session::has('orig_user') )
                            <a title="Back to Admin Dashboard" href="{{ url('user/switch/stop') }}"><i class="pe-7s-back-2"></i></a>
                            @endif
                        </li>
                        @endrole

                        <!-- settings -->
                        <li class="dropdown dropdown-user">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="pe-7s-settings"></i></a>
                            <ul class="dropdown-menu">
                                @role('Admin')<li><a href="{{ url('admin/profile') }}"><i class="pe-7s-users"></i> User Profile</a></li>@endrole
                                @role('User')<li><a href="{{ url('user/profile') }}"><i class="pe-7s-users"></i> User Profile</a></li>@endrole
                                <!--
                                <li>
                                    <a href="#"><i class="pe-7s-settings"></i> Settings</a>
                                </li>
                                -->
                                <li>
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                               document.getElementById('logout-form').submit();" class="logout">
                                        <i class="pe-7s-key"></i> 
                                        Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>                        
                    </ul>
                </div>
            </nav>
            @endif
        </header>
        @include('includes.sidebar')
        @yield('content')

        @include('includes.footer')
