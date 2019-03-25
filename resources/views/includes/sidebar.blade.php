<aside class="main-sidebar">
    <div class="sidebar">
        <div class="user-panel text-center">
            <div class="image">
                @role(['Master', 'Admin'])
                <a href="{{ url('admin/dashboard') }}" class="logo"> 
                    <span class="logo-lg">
                        <img src="{{asset('web/img/uncle-fitter-logo.png')}}" alt="Uncle Fitter" />
                    </span>
                </a>
                @endrole

                @role('User')
                <a href="{{ url('user/dashboard') }}" class="logo"> 
                    <span class="logo-lg">
                        <img src="{{asset('web/img/uncle-fitter-logo.png')}}" alt="Uncle Fitter" />
                    </span>
                </a>
                @endrole
            </div>
            <div class="info">
                <p> {{ (Auth::user()) ? Auth::user()->name : '' }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        @role(['Master', 'Admin'])
        <ul class="sidebar-menu">

            <li class="<?php
            if (isset($page) && $page == 'dashboard') {
                echo 'active';
            }
            ?>">
                <a href="{{url('admin/dashboard')}}">
                    <i class="fa fa-home" aria-hidden="true"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="<?php
            if (isset($page) && $page == 'bookings') {
                echo 'active';
            }
            ?>">
                <a href="{{url('admin/bookings')}}">
                    <i class="fa fa-calendar" aria-hidden="true"></i> <span>Service Bookings</span>
                </a>
            </li>

            @role(['Master'])
            <li class="<?php
            if (isset($page) && $page == 'zipcode') {
                echo 'active';
            }
            ?>">
                <a href="{{url('admin/locations')}}">
                    <i class="fa fa-map-marker" aria-hidden="true"></i> <span>Locations</span>
                </a>
            </li>

            <?php
            if (isset($page) && ($page == 'cars' || $page == 'year' || $page == 'carmodel' || $page == 'cartrim')) {
                $class_car = 'menu-open';
            }
            ?>

            <li class="treeview <?php
            if (isset($class_car)) {
                echo 'active';
            }
            ?>">
                <a href="#">
                    <i class="fa fa-car" aria-hidden="true"></i><span> Car Management</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu <?php
                if (isset($class_car)) {
                    echo $class_car;
                }
                ?>">
                    <li class="<?php
                    if (isset($page) && $page == 'cars') {
                        echo 'active';
                    }
                    ?>">
                        <a href="{{url('admin/car/makes')}}"> <span>Makes</span></a>
                    </li>
                    <li class="<?php
                    if (isset($page) && $page == 'year') {
                        echo 'active';
                    }
                    ?>">
                        <a href="{{url('admin/car/years')}}"> <span>Years</span></a>
                    </li>
                    <li class="<?php
                    if (isset($page) && $page == 'carmodel') {
                        echo 'active';
                    }
                    ?>">
                        <a href="{{url('admin/car/models')}}"> <span>Models</span></a>
                    </li>
                    <li class="<?php
                    if (isset($page) && $page == 'cartrim') {
                        echo 'active';
                    }
                    ?>">
                        <a href="{{url('admin/car/trims')}}"> <span>Trims</span></a>
                    </li>
                </ul>
            </li>

            <?php
            if (isset($page) && ($page == 'servicetype' || $page == 'service' || $page == 'subservice' || $page == 'subserviceopt' || $page == 'category')) {
                $class_service = 'menu-open';
            }
            ?>

            <li class="treeview <?php
            if (isset($class_service)) {
                echo 'active';
            }
            ?>">
                <a href="#">
                    <i class="fa fa-database" aria-hidden="true"></i><span> Service Management</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu <?php
                if (isset($class_service)) {
                    echo $class_service;
                }
                ?>">
                    <li class="<?php
                    if (isset($page) && $page == 'servicetype') {
                        echo 'active';
                    }
                    ?>">
                        <a href="{{url('admin/service-types')}}"> <span>Service Types</span></a>
                    </li>

                    <li class="<?php
                    if (isset($page) && $page == 'category') {
                        echo 'active';
                    }
                    ?>">
                        <a href="{{url('admin/categories')}}"><span>Categories</span></a>
                    </li>

                    <li class="<?php
                    if (isset($page) && $page == 'service') {
                        echo 'active';
                    }
                    ?>">
                        <a href="{{url('admin/services')}}"><span>Services</span></a>
                    </li>

                    <li class="<?php
                    if (isset($page) && $page == 'subservice') {
                        echo 'active';
                    }
                    ?>">
                        <a href="{{url('admin/sub-services')}}"><span>Sub-Services</span></a>
                    </li>

                    <li class="<?php
                    if (isset($page) && $page == 'subserviceopt') {
                        echo 'active';
                    }
                    ?>">
                        <a href="{{url('admin/sub-service-options')}}"><span>Sub-Service Options</span></a>
                    </li>
                </ul>
            </li>
            @endrole
            <li class="treeview <?php
            if (isset($page) && ($page == 'mechanic' || $page == 'user' || $page == 'master' || $page == 'admin')) {
                echo 'active menu-open';
            }
            ?>">
                <a href="#">
                    <i class="fa fa-users" aria-hidden="true"></i><span> User Management</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php
                    if (isset($page) && $page == 'mechanic') {
                        echo 'active';
                    }
                    ?>">
                        <a href="{{url('admin/user/role/Mechanic')}}"> <span>Mechanics</span></a>
                    </li>

                    <li class="<?php
                    if (isset($page) && $page == 'user') {
                        echo 'active';
                    }
                    ?>">
                        <a href="{{url('admin/user/role/User')}}"><span>Users</span></a>
                    </li>                    
                    <li class="<?php
                    if (isset($page) && $page == 'admin') {
                        echo 'active';
                    }
                    ?>">
                        <a href="{{url('admin/user/role/Admin')}}"><span>Admins</span></a>
                    </li>
                </ul>
            </li>

            <li class="<?php
            if (isset($page) && $page == 'payment') {
                echo 'active';
            }
            ?>">
                <a href="{{url('admin/payment')}}">
                    <i class="fa fa-credit-card-alt" aria-hidden="true"></i> <span>Billing & Payments</span>
                </a>
            </li>

            <li class="<?php
            if (isset($page) && $page == 'referrals') {
                echo 'active';
            }
            ?>">
                <a href="{{url('admin/referrals')}}">
                    <i class="fa fa-share-square" aria-hidden="true"></i> <span>Referrals</span>
                </a>
            </li>

            <li class="<?php
            if (isset($page) && $page == 'settings') {
                echo 'active';
            }
            ?>">
                <a href="{{url('admin/settings')}}">
                    <i class="fa fa-gears" aria-hidden="true"></i> <span>Settings</span>
                </a>
            </li>

        </ul>
        @endrole 

        @role('User')
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>

            <li class="<?php
            if (isset($page) && $page == 'dashboard') {
                echo 'active';
            }
            ?>">
                <a href="{{url('user/dashboard')}}">
                    <i class="fa fa-home" aria-hidden="true"></i> <span>Dashboard</span>
                </a>
            </li>

            <li class="<?php
            if (isset($page) && $page == 'user-car') {
                echo 'active';
            }
            ?>">
                <a href="{{url('user/cars')}}">
                    <i class="fa fa-car" aria-hidden="true"></i> <span>My Cars</span>
                </a>
            </li>
            <li class="<?php
            if (isset($page) && $page == 'my-bookings') {
                echo 'active';
            }
            ?>">
                <a href="{{url('user/bookings')}}">
                    <i class="fa fa-calendar" aria-hidden="true"></i> <span>My Bookings</span>
                </a>
            </li>
            <li class="<?php
            if (isset($page) && $page == 'user-payment') {
                echo 'active';
            }
            ?>">
                <a href="{{url('user/payment')}}">
                    <i class="fa fa-credit-card-alt" aria-hidden="true"></i> <span>Billing & Payments</span>
                </a>
            </li>
            <li class="<?php
            if (isset($page) && $page == 'refer') {
                echo 'active';
            }
            ?>">
                <a href="{{url('user/refer')}}">
                    <i class="fa fa-share-square" aria-hidden="true"></i> <span>Refer A Friend</span>
                </a>
            </li>
        </ul>
        @endrole

    </div>
</aside>