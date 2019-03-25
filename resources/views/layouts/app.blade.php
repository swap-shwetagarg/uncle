<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title')</title>
        <meta name="description" content="@yield('description')">
        <meta name="keywords" content="@yield('keywords')">
        <!-- Styles -->
        <link href="{{ asset('assets/plugins/jquery-ui-1.12.1/jquery-ui.min.css')}}" rel="stylesheet" type="text/css"/>
        <!-- Bootstrap -->
        <link href="{{ asset('assets/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>

        <link href="{{ asset('assets/plugins/lobipanel/lobipanel.min.css')}}" rel="stylesheet" type="text/css"/>
        <!-- Pace css -->
        <link href="{{ asset('assets/plugins/pace/flash.css')}}" rel="stylesheet" type="text/css"/>
        <!-- Font Awesome -->
        <link href="{{ asset('assets/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css"/>
        <!-- Pe-icon -->
        <link href="{{ asset('assets/pe-icon-7-stroke/css/pe-icon-7-stroke.css')}}" rel="stylesheet" type="text/css"/>
        <!-- Themify icons -->
        <link href="{{ asset('assets/themify-icons/themify-icons.css')}}" rel="stylesheet" type="text/css"/>
        <!-- Toastr css -->
        <link href="{{ asset('assets/plugins/toastr/toastr.css')}}" rel="stylesheet" type="text/css"/>
        <!-- Emojionearea -->
        <link href="{{ asset('assets/plugins/emojionearea/emojionearea.min.css')}}" rel="stylesheet" type="text/css"/>
        <!-- Monthly Javascript -->
        <link href="{{ asset('assets/plugins/monthly/monthly.css')}}" rel="stylesheet" type="text/css"/>        
        <!-- Common js file -->
        <script src="{{ asset('js/common.js')}}" type="text/javascript"></script>
        <!-- End page Label Plugins 
            =====================================================================-->
        <!-- Start Theme Layout Style
            =====================================================================-->
        <!-- Theme style -->
        <link href="{{ asset('assets/dist/css/styleBD.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <!-- Scripts -->
        <script>
window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
]) !!}
;
        </script>
    </head>
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
                <a href="index.html" class="logo"> <!-- Logo -->
                    <span class="logo-mini">
                        <!--<b>A</b>BD-->
                        <img src="{{ asset('assets/dist/img/mini-logo.png')}}" alt="">
                    </span>
                    <span class="logo-lg">
                        <!--<b>Admin</b>BD-->
                        <img src="{{ asset('assets/dist/img/logo.png')}}" alt="">
                    </span>
                </a>
                <!-- Header Navbar -->
                <nav class="navbar navbar-static-top">
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"> <!-- Sidebar toggle button-->
                        <span class="sr-only">Toggle navigation</span>
                        <span class="pe-7s-keypad"></span>
                    </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- settings -->
                            <li class="dropdown dropdown-user">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="pe-7s-settings"></i></a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ url('profile') }}"><i class="pe-7s-users"></i> User Profile</a></li>
                                    <li><a href="#"><i class="pe-7s-settings"></i> Settings</a></li>
                                    <li><a href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                   document.getElementById('logout-form').submit();">
                                            <i class="pe-7s-key"></i> Logout</a><form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form></li>

                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
                @endif
            </header>
            <aside class="main-sidebar">
                <!-- sidebar -->
                <div class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel text-center">
                        <div class="image">
                            <img src="{{ asset('assets/dist/img/user2-160x160.png')}}" class="img-circle" alt="User Image">
                        </div>
                        <div class="info">
                            <p> {{ isset(Auth::user()->name) }}</p>
                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                    <!-- sidebar menu -->
                    <ul class="sidebar-menu">
                        <li class="header">MAIN NAVIGATION</li>
                        <li class="active">
                            <a href="index.html"><i class="ti-home"></i> <span>Dashboard</span>
                                <span class="pull-right-container">
                                    <span class="label label-success pull-right">v.1</span>
                                </span>
                            </a>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="ti-paint-bucket"></i><span>UI Elements</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="buttons.html">Buttons</a></li>
                                <li><a href="tabs.html">Tabs</a></li>
                                <li><a href="notification.html">Notification</a></li>
                                <li><a href="tree-view.html">Tree View</a></li>
                                <li><a href="progressbars.html">Progressber</a></li>
                                <li><a href="list.html">List View</a></li>
                                <li><a href="typography.html">Typography</a></li>
                                <li><a href="panels.html">Panels</a></li>
                                <li><a href="modals.html">Modals</a></li>
                                <li><a href="icheck_toggle_pagination.html">iCheck, Toggle, Pagination</a></li>
                                <li><a href="labels-badges-alerts.html">Labels, Badges, Alerts</a></li>
                            </ul>
                        </li>

                        <li><a href="documentation/index.html" target="_blank"><i class="ti-bookmark"></i><span>Documentation</span></a></li>
                        <li class="header">LABELS</li>
                        <li><a href="#"><i class="fa fa-circle color-green"></i> <span>Important</span></a></li>
                        <li><a href="#"><i class="fa fa-circle color-red"></i> <span>Warning</span></a></li>
                        <li><a href="#"><i class="fa fa-circle color-yellow"></i> <span>Information</span></a></li>
                    </ul>
                </div> <!-- /.sidebar -->
            </aside>
            @yield('content')
            <footer class="main-footer">
                <div class="pull-right hidden-xs"> <b>Version</b> 1.0</div>
                <strong>Copyright &copy; 2016-2017 <a href="#">bdtask</a>.</strong> All rights reserved. <i class="fa fa-heart color-green"></i>
            </footer>
        </div>
        <!-- Scripts -->
        <script src="{{ asset('assets/plugins/jQuery/jquery-1.12.4.min.js')}}" type="text/javascript"></script>
        <!-- jquery-ui --> 
        <script src="{{ asset('assets/plugins/jquery-ui-1.12.1/jquery-ui.min.js')}}" type="text/javascript"></script>
        <!-- Bootstrap -->
        <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
        <!-- lobipanel -->
        <script src="{{ asset('assets/plugins/lobipanel/lobipanel.min.js')}}" type="text/javascript"></script>
        <!-- Pace js -->
        <script src="{{ asset('assets/plugins/pace/pace.min.js')}}" type="text/javascript"></script>
        <!-- SlimScroll -->
        <script src="{{ asset('assets/plugins/slimScroll/jquery.slimscroll.min.js')}}" type="text/javascript"></script>
        <!-- FastClick -->
        <script src="{{ asset('assets/plugins/fastclick/fastclick.min.js')}}" type="text/javascript"></script>
        <!-- AdminBD frame -->
        <script src="{{ asset('assets/dist/js/frame.js')}}" type="text/javascript"></script>
        <script src="{{ asset('assets/plugins/toastr/toastr.min.js')}}" type="text/javascript"></script>
        <!-- Sparkline js -->
        <script src="{{ asset('assets/plugins/sparkline/sparkline.min.js')}}" type="text/javascript"></script>
        <!-- Data maps js -->
        <script src="{{ asset('assets/plugins/datamaps/d3.min.js')}}" type="text/javascript"></script>
        <script src="{{ asset('assets/plugins/datamaps/topojson.min.js')}}" type="text/javascript"></script>
        <script src="{{ asset('assets/plugins/datamaps/datamaps.all.min.js')}}" type="text/javascript"></script>
        <!-- Counter js -->
        <script src="{{ asset('assets/plugins/counterup/waypoints.js')}}" type="text/javascript"></script>
        <script src="{{ asset('assets/plugins/counterup/jquery.counterup.min.js')}}" type="text/javascript"></script>
        <!-- Emojionearea -->
        <script src="{{ asset('assets/plugins/emojionearea/emojionearea.min.js')}}" type="text/javascript"></script>
        <!-- Monthly js -->
        <script src="{{ asset('assets/plugins/monthly/monthly.js')}}" type="text/javascript"></script>
        <!-- End Page Lavel Plugins
        =====================================================================-->
        <!-- Start Theme label Script
        =====================================================================-->
        <!-- Dashboard js -->
        <script src="{{ asset('assets/dist/js/dashboard.js')}}" type="text/javascript"></script>
        <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
        <script type="text/javascript">
                                               $(document).ready(function () {

                                                   "use strict"; // Start of use strict

                                                   // notification
                                                   setTimeout(function () {
                                                       toastr.options = {
                                                           closeButton: true,
                                                           progressBar: true,
                                                           showMethod: 'slideDown',
                                                           timeOut: 4000
                                                                   //                        positionClass: "toast-top-left"
                                                       };
                                                       //toastr.success('Responsive Admin Theme', 'Welcome to AdminBD');

                                                   }, 1300);

                                                   //counter

                                                   //data maps
                                                   var basic_choropleth = new Datamap({
                                                       element: document.getElementById("map1"),
                                                       projection: 'mercator',
                                                       fills: {
                                                           defaultFill: "#37a000",
                                                           authorHasTraveledTo: "#fa0fa0"
                                                       },
                                                       data: {
                                                           USA: {fillKey: "authorHasTraveledTo"},
                                                           JPN: {fillKey: "authorHasTraveledTo"},
                                                           ITA: {fillKey: "authorHasTraveledTo"},
                                                           CRI: {fillKey: "authorHasTraveledTo"},
                                                           KOR: {fillKey: "authorHasTraveledTo"},
                                                           DEU: {fillKey: "authorHasTraveledTo"}
                                                       }
                                                   });

                                                   var colors = d3.scale.category10();

                                                   window.setInterval(function () {
                                                       basic_choropleth.updateChoropleth({
                                                           USA: colors(Math.random() * 10),
                                                           RUS: colors(Math.random() * 100),
                                                           AUS: {fillKey: 'authorHasTraveledTo'},
                                                           BRA: colors(Math.random() * 50),
                                                           CAN: colors(Math.random() * 50),
                                                           ZAF: colors(Math.random() * 50),
                                                           IND: colors(Math.random() * 50)
                                                       });
                                                   }, 2000);

                                                   //Chat list
                                                   $('.chat_list').slimScroll({
                                                       size: '3px',
                                                       height: '305px'
                                                   });

                                                   // Message
                                                   $('.message_inner').slimScroll({
                                                       size: '3px',
                                                       height: '320px'
                                                               //                    position: 'left'
                                                   });



                                               });
        </script>
    </body>
</html>