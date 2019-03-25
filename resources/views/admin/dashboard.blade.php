@extends('layouts.admin')

@section('title', "Admin Dashboard | Uncle Fitter")

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-world"></i>
        </div>
        <div class="header-title">
            <h1>Uncle fitter Dashboard</h1>
            <small>Managing you car has never been more convenient</small>
            <ol class="breadcrumb">
                <li><a href="index.html"><i class="pe-7s-home"></i> Home</a></li>
                <li class="active">Dashboard</li>
            </ol>
        </div>
    </section>
    <!-- Main content -->
    <section class="content">

        <div class="row dashboard-div-content">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h3>Service Bookings</h3>
            </div>
        </div>        
        <div class="row dashboard-div-content div-margin">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                <div class="panel panel-bd dashboard-div div-color">
                    <div class="panel-body total-bookings-card">
                        <div class="statistic-box">
                            <div class="header-title"><h4>Total Bookings</h4></div>
                            <h2>
                                <span class="count-number">{{ $countAll }}</span>
                                <!--<span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"></i>&#43;</span>-->
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                <div class="panel panel-bd dashboard-div">
                    <div class="panel-body pending-bookings-card">
                        <div class="statistic-box">
                            <div class="header-title"><h4>Pending Bookings</h4></div>
                            <h2>
                                <span class="count-number">{{ $countPending }}</span>
                                <!--<span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"></i>&#43;</span>-->
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                <div class="panel panel-bd dashboard-div div-color">
                    <div class="panel-body quoted-bookings-card">
                        <div class="statistic-box">
                            <div class="header-title"><h4>Quoted Bookings</h4></div>
                            <h2>
                                <span class="count-number">{{ $countQuoted }}</span>
                                <!--<span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"></i>&#43;</span>-->
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                <div class="panel panel-bd dashboard-div">
                    <div class="panel-body inprocess-bookings-card">
                        <div class="statistic-box">
                            <div class="header-title"><h4>Awaiting Mechanic</h4></div>
                            <h2>
                                <span class="count-number">{{ $countProgressive }}</span>
                                <!--<span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"></i>&#43;</span>-->
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                <div class="panel panel-bd dashboard-div">
                    <div class="panel-body scheduled-bookings-card">
                        <div class="statistic-box">
                            <div class="header-title"><h4>Scheduled Bookings</h4></div>
                            <h2>
                                <span class="count-number">{{ $countScheduled }}</span>
                                <!--<span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"></i>&#43;</span>-->
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                <div class="panel panel-bd dashboard-div div-color">
                    <div class="panel-body completed-bookings-card">
                        <div class="statistic-box">
                            <div class="header-title"><h4>Completed Bookings</h4></div>
                            <h2>
                                <span class="count-number">{{ $countCompleted }}</span>
                                <!--<span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"></i>&#43;</span>-->
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row dashboard-div-content">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h3>Users/Mechanics</h3>
            </div>
        </div>
        <div class="row dashboard-div-content div-margin">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                <div class="panel panel-bd dashboard-div div-color">
                    <div class="panel-body">
                        <div class="statistic-box">
                            <div class="header-title"><h4>All Users</h4></div>
                            <h2>
                                <span class="count-number">{{ $allUser }}</span>
                                <!--<span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"></i>&#43;</span>-->
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                <div class="panel panel-bd dashboard-div">
                    <div class="panel-body">
                        <div class="statistic-box">
                            <div class="header-title"><h4>Active Users</h4></div>
                            <h2>
                                <span class="count-number">{{ $countUser }}</span>
                                <!--<span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"></i>&#43;</span>-->
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                <div class="panel panel-bd dashboard-div div-color">
                    <div class="panel-body">
                        <div class="statistic-box">
                            <div class="header-title"><h4>Active Mechanics</h4></div>
                            <h2>
                                <span class="count-number">{{ $countMechanic }}</span>
                                <!--<span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"></i>&#43;</span>-->
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section> <!-- /.content -->
</div> <!-- /.content-wrapper -->

@endsection
