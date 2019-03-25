@extends('layouts.admin')

@section('title', 'My Cars | Uncle Fitter')

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
                                <div class="col-sm-11"><h4>User's Cars</h4></div>
                                <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#add_user_car_modal">Add Car</button>
                            </div>
                        </div>
                        <div class="panel-body">
                            @include('web.user.car.user_car_list')
                        </div>
                    </div>
                </div>
            </div>
        </section> <!-- /.content -->
    </div> <!-- /.content-wrapper -->
</div> 

<!-- Modal - Add Car Service-->
<div id="add_user_car_modal" class="modal fade" role="dialog" data-toggle="modal">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Car</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id='form_add_user_car' method='post' action='{{URL("user/cars")}}'>

                    <div class="form-group car_id">
                        <label class="control-label col-sm-3" for="brand">Brand :</label>
                        <div class="col-sm-6">
                            <select class="form-control" name = 'car_id' id='select_user_car' data-url='{{url("caryear")}}'>
                                <option value=''>Select Car</option>
                                @if(count($cars)>0)
                                @foreach($cars as $car)
                                <option value='{{ $car->id }}'>{{ $car->brand }}</option>
                                @endforeach
                                @endif
                            </select>
                            <span id ='car_id'></span>
                        </div>
                    </div>

                    <div class="form-group year_id">
                        <label class="control-label col-sm-3" for="year">Year :</label>
                        <div class="col-sm-6">
                            <select class="form-control" name = 'year_id' id='select_user_car_year' data-url='{{url("carmodel")}}'>
                                <option value=''>Select Year</option>
                            </select>
                            <span id ='year_id'></span>
                        </div>
                    </div>

                    <div class="form-group car_model_id">
                        <label class="control-label col-sm-3" for="Model">Model :</label>
                        <div class="col-sm-6">
                            <select class="form-control" name = 'car_model_id' id='select_user_car_model' data-url='{{url("cartrim")}}'>
                                <option value=''>Select Model</option>
                            </select>
                            <span id ='car_model_id'></span>
                        </div>
                    </div>

                    <div class="form-group car_trim_id">
                        <label class="control-label col-sm-3" for="car-trim">Car Trim :</label>
                        <div class="col-sm-6">
                            <select class="form-control" name = 'car_trim_id' id='select_user_cartrim'>
                                <option value=''>Select Car Trim</option>
                            </select>
                            <span id ='car_trim_id'></span>
                        </div>
                    </div>
                    {{ csrf_field()}}  
                    <div class="modal-footer">
                        <div class='row'>
                            <div class='col-sm-8 modal_btn'>
                                <button type="submit" class="btn btn-info">Submit</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                            </div>
                            <img src='{{ asset('images/spin.gif')}}' class='spinner'>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal- Delete user car -->
<div class="modal fade" id="delete_user_car_modal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                <form id='form_delete_user_car' method='post'> 
                    {{ csrf_field()}}
                    {{ method_field('DELETE') }}

                    <p class='text-center car_delete_heading'>You are about to delete this car, are you sure?</p>
                    <div class="car_delete_text">    
                        <div class="text-left chkbox">
                            <strong>To remove this car, please agree to following points.</strong><br/>
                            <input type="checkbox" class="removeQuotes"/> I understand that all associated quotes with this car will be removed.
                            <br/>
                            <input type="checkbox" class="removeCar"/> I understand that I won't be able to retrieve a deleted car.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class='row'>
                            <div class='col-sm-12 modal_btn text-center'>
                                <button type="submit" class="btn btn-info car_delete_yes" disabled="disabled">DELETE IT</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">NO, TAKE ME BACK</button> 
                            </div>
                            <img src='{{ asset('images/spin.gif')}}' class='spinner'>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal - User Car Service-->
<div id="user_car_services_modal" class="modal fade" role="dialog" data-toggle="modal">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body" id='user-car-service-container'>
            </div>
        </div>
    </div>
</div>

<!-- Modal - User Car health -->
<div id="user_car_health_modal" class="modal fade" role="dialog" data-toggle="modal">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body" id='user-car-health-container'>
            </div>
        </div>
    </div>
</div>

<!-- Modal - User Car Details -->
<div id="user_car_extra_details" class="modal fade" role="dialog" data-toggle="modal">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body" id='user-car-extra-details-container'>
            </div>
        </div>
    </div>
</div>

<!-- Modal - User Car star rating -->
<div id="mechanic_car_rating_modal" class="modal fade" role="dialog" data-toggle="modal">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Car Health Report</h4>
            </div>
            <form id="user_car_health_form" class="form-horizontal" method='POST' action="">
                <div class="modal-body" style='align:center;'>
                    {{ csrf_field() }}
                    <div class='row'> 
                        <div class='col-sm-6 health-content'>
                            <div>DASH</div>
                        </div>
                        <div class='col-sm-6'>
                            <div class="rateYo" id='dash'></div>
                            <input type='hidden' name='dash'>
                        </div>
                    </div>

                    <div class='row'> 
                        <div class='col-sm-6 health-content'>
                            <div>TYRES</div>
                        </div>
                        <div class='col-sm-6'>
                            <div class="rateYo" id='tyres'></div>
                            <input type='hidden' name='tyres'>
                        </div>
                    </div>

                    <div class='row'> 
                        <div class='col-sm-6 health-content'>
                            <div>FLUIDS</div>
                        </div>
                        <div class='col-sm-6'>
                            <div class="rateYo" id='fluids'></div>
                            <input type='hidden' name='fluids'>
                        </div>
                    </div>

                    <div class='row'> 
                        <div class='col-sm-6 health-content'>
                            <div>BRAKES</div>
                        </div>
                        <div class='col-sm-6'>
                            <div class="rateYo" id='brakes'></div>
                            <input type='hidden' name='brakes'>
                        </div>
                    </div>

                    <div class='row'> 
                        <div class='col-sm-6 health-content'>
                            <div>ENGINE</div>
                        </div>
                        <div class='col-sm-6'>
                            <div class="rateYo" id='engine'></div>
                            <input type='hidden' name='engine'>
                        </div>
                    </div>

                    <div class='row'> 
                        <div class='col-sm-6 health-content'>
                            <div>LIGHTS</div>
                        </div>
                        <div class='col-sm-6'>
                            <div class="rateYo" id='lights'></div>
                            <input type='hidden' name='lights'>
                        </div>
                    </div>

                    <div class='row'> 
                        <div class='col-sm-6 health-content'>
                            <div>FRONT SUSPENSION</div>
                        </div>
                        <div class='col-sm-6'>
                            <div class="rateYo" id='frontSus'></div>
                            <input type='hidden' name='front-Suspension'>
                        </div>
                    </div>

                    <div class='row'> 
                        <div class='col-sm-6 health-content'>
                            <div>REAR SUSPENSION</div>
                        </div>
                        <div class='col-sm-6'>
                            <div class="rateYo" id='rearSus'></div>
                            <input type='hidden' name='rear-Suspension'>
                        </div>
                    </div>

                    <div class='row'> 
                        <div class='col-sm-6 health-content'>
                            <div>OTHER</div>
                        </div>
                        <div class='col-sm-6'>
                            <div class="rateYo" id='other'></div>
                            <input type='hidden' name='other'>
                        </div>
                    </div>
                    </div>
                    {{ csrf_field()}}  
                    <div class="modal-footer">
                        <div class='row'>
                            <div class='col-sm-8 modal_btn'>
                                <button type="submit" class="btn btn-info" id='submitBtn'>Submit</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                            </div>
                            <img src='{{ asset('images/spin.gif')}}' class='spinner'>
                        </div>
                    </div>
                </form> 
            </div>
        </div>
    </div>
</div>

@endsection