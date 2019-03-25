@extends('layouts.admin')

@section('title', 'User Dashboard | Uncle Fitter')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-world"></i>
        </div>
        <div class="header-title">
            <h1>Welcome {{ Auth::user()->name }}!</h1>
            <small>Managing your car has never been more convenient</small>
        </div>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12 text-center">
                <a href="{{ URL('request-a-quote') }}" target="_blank" class="btn btn-primary btn-rounded get-quote-lg w-md m-b-5">BOOK A SERVICE</a>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <!--<h2 >Upcoming services</h2>-->
                <hr/>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="main">
                            <ul class="cbp_tmtimeline">
                                @if(isset($upbookings) && count($upbookings)>0 && $upbookings)
                                    @foreach($upbookings as $upbooking)
                                        @foreach($upbooking as $val)
                                            <li>
                                                <time class="cbp_tmtime" datetime="2017-01-26 18:30"> <span>{{ ($val && sizeof($val)) ? $val[0] : '' }}</span></time>
                                                <i class="fa fa-car"></i>
                                                <div class="cbp_tmlabel">
                                                    <h4 class="text-success">{{ ($val && sizeof($val) > 2) ? $val[1]->carTrim->carmodel->years->cars->brand : '' }}, {{ ($val && sizeof($val) > 2) ? $val[1]->carTrim->carmodel->modal_name : '' }}, {{ ($val && sizeof($val)) ? $val[1]->carTrim->car_trim_name : '' }}</h4>
                                                    <h5 class="text-violet">Assigned Mechanic- {{ ($val && sizeof($val) > 2) ?  $val[1]->bookingMechanic->mechanic->name : '' }}</h5>
                                                    <span class="text-black">Last Service done on  {{ ($val && sizeof($val) > 2) ? Carbon\Carbon::parse($val[1]->date_time)->format('d-m-Y') : '' }} </span>
                                                </div>
                                            </li>
                                        @endforeach
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> <!-- /.content -->
</div> <!-- /.content-wrapper -->

@endsection
