@extends('layouts.admin')

@section('title', 'Thank you | Uncle Fitter')

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
                                <h4>Thank You</h4> 
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="text-center text-success">
                                <h1 class="display-3 text-success">Thank You!</h1>
                                <p class="lead"></p>
                                <h4>Your booking has been scheduled. A mechanic will be assigned to you shortly...</h4>
                                <hr>
                                <p class="lead">
                                    <a rel="booking" class="btn btn-info btn-sm" href="/user/bookings" role="button">Continue to Booking Page</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> <!-- /.content -->
    </div> <!-- /.content-wrapper -->
</div> 
@endsection