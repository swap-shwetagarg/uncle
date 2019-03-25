@extends('layouts.admin')
@section('content')
<div class="wrapper">
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-bd">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <div class="row">
                                    <div class="col-sm-10">
                                        <h4>My Service Bookings</h4>
                                        </div>
                                    <a class="btn btn-info btn-md" href="{{ URL('request-a-quote') }}" target="_blank" >Request A Quote</a>                                    
                                </div>
                            </div>
                        </div>
                        <div class="panel-body my-bookings">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="/user/bookings/status/7" data-toggle="ajaxload" data-target="#all" aria-expanded="false">All</a></li>
                                <li class=""><a href="/user/bookings/status/1" data-toggle="ajaxload" data-target="#in-process" aria-expanded="true">In Process</a></li>
                                <li class=""><a href="/user/bookings/status/2" data-toggle="ajaxload" data-target="#confirmed" aria-expanded="true">Confirmed</a></li>
                                <li class=""><a href="/user/bookings/status/3" data-toggle="ajaxload" data-target="#quoted" aria-expanded="true">Quoted</a></li>
                                <li class=""><a href="/user/bookings/status/4" data-toggle="ajaxload" data-target="#pending" aria-expanded="true">Pending for Quote</a></li>

                            </ul>
                            <!-- Tab panels -->
                            <div class="tab-content">
                                <div class="tab-pane fade active in" id="all">
                                    <div class="panel-body">
                                        @include('web.user.booking.booking_table')

                                    </div>
                                </div>
                                <div class="tab-pane fade  in" id="in-process">
                                    <div class="loader"></div>
                                </div>
                                <div class="tab-pane fade in" id="quoted">
                                    <div class="loader"></div>
                                </div>
                                <div class="tab-pane fade in" id="confirmed">
                                    <div class="loader"></div>
                                </div>
                                <div class="tab-pane" id="pending">
                                    <div class="panel-body">
                                        <div class="loader"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="modal-lg" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">

                                        <div class="modal-body booking-detail">
                                            <div class="loader"></div>
                                        </div>

                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div>

                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
</section> <!-- /.content -->
</div> <!-- /.content-wrapper -->
</div> 
<script>
    @if (Session::get('data'))
            var is_booked = {{ Session::get('data')['is_booked']}};
    var payment_status = {{ Session::get('data')['payment_status']}};
    @endif;
</script>
@endsection