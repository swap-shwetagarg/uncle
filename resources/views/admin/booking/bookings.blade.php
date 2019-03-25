@extends('layouts.admin')

@section('title', "User's Service Bookings | Uncle Fitter")

@section('content')
<div class="wrapper">
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-sm-12 booking-table-mobile">
                    <div class="panel panel-bd">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <div class="row">
                                    <div class="col-sm-12 col-md-4 user__booking">
                                        <h4>User's Service Bookings</h4>
                                    </div>  
                                    <div class="col-sm-12 col-md-6 search">
                                        <form method="GET" class="search_form">
                                            <div class="search_booking">
                                                <div class="col-sm-12 col-md-9 search__input">
                                                    <input type="text" class="form-control" name="search_booking" id="search_booking" placeholder="Booking Id / User Name">
                                                    <span id="searchclear" class="glyphicon glyphicon-remove-circle"></span>
                                                </div>
                                                <div class="col-sm-12 col-md-3 search__input__button">
                                                    <div class="btn-group">
                                                        <button class="btn btn-info btn-md" name="btn_search_booking" id="btn_search_booking">Search</button>                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-sm-12 col-md-2">
                                        <a href="{{ URL("admin/bookings/request-a-quote") }}" class="btn btn-primary btn-md">
                                            Request For Quote
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body my-bookings">
                            <div class="table-responsive">

                                <nav class="tabs">
                                    <ul class="nav nav-tabs">
                                        <li class="active" data-name="all">
                                            <a href="/admin/bookings/status/7" data-toggle="ajaxload" data-target="#all" aria-expanded="false">All</a>
                                        </li>
                                        <li data-name="inprocess">
                                            <a href="/admin/bookings/status/1" data-toggle="ajaxload" data-target="#in-process" aria-expanded="true">In Process</a>
                                        </li>
                                        <li data-name="scheduled">
                                            <a href="/admin/bookings/status/8" data-toggle="ajaxload" data-target="#scheduled" aria-expanded="true">Scheduled</a>
                                        </li>
                                        <li data-name="quoted">
                                            <a href="/admin/bookings/status/3" data-toggle="ajaxload" data-target="#quoted" aria-expanded="true">Quoted</a>
                                        </li>
                                        <li data-name="pendingforquote">
                                            <a href="/admin/bookings/status/4" data-toggle="ajaxload" data-target="#pendingforquote" aria-expanded="true">Pending for Quote</a>
                                        </li>
                                        <li data-name="deletedquote">
                                            <a href="/admin/bookings/status/5" data-toggle="ajaxload" data-target="#deletedquote" aria-expanded="true">Deleted Quote</a>
                                        </li>
                                        <li data-name="completed">
                                            <a href="/admin/bookings/status/6" data-toggle="ajaxload" data-target="#completed" aria-expanded="true">Completed</a>
                                        </li>
                                        <li data-name="cancelled">
                                            <a href="/admin/bookings/status/9" data-toggle="ajaxload" data-target="#cancelled" aria-expanded="true">Cancelled</a>
                                        </li>
                                    </ul>
                                </nav>

                                <div class="tab-content">
                                    <div class="tab-pane fade active in" id="all">
                                        <div class="panel-body">
                                            @include('admin.booking.booking_table')
                                        </div>
                                    </div>
                                    <div class="tab-pane fade  in" id="in-process">
                                        <div class="loader"></div>
                                    </div>
                                    <div class="tab-pane fade in" id="scheduled">
                                        <div class="loader"></div>
                                    </div>
                                    <div class="tab-pane fade in" id="quoted">
                                        <div class="loader"></div>
                                    </div>
                                    <div class="tab-pane" id="pendingforquote">
                                        <div class="panel-body">
                                            <div class="loader"></div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="deletedquote">
                                        <div class="panel-body">
                                            <div class="loader"></div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade in" id="confirmed">
                                        <div class="loader"></div>
                                    </div>
                                    <div class="tab-pane fade in" id="completed">
                                        <div class="loader"></div>
                                    </div>
                                    <div class="tab-pane fade in" id="cancelled">
                                        <div class="loader"></div>
                                    </div>
                                </div>

                            </div>

                            <div class="modal fade " id="modal-lg" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body booking-detail">
                                            <div class="loader"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="modal-md" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-md" role="document">
                                    <div class="modal-content">

                                        <div class="modal-body mechanic-list">
                                            <div class="loader"></div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div> 
@endsection
