@extends('layouts.admin')

@section('title', "Car Trims | Uncle Fitter")

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
                                <div class="col-sm-11"><h4>Car Trims</h4></div>
                                <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#add_cartrim_modal">Add</button>
                            </div>
                        </div>
                        <div class="panel-body">
                            @include('admin.cartrim_table')
                        </div>
                    </div>
                </div>
            </div>
        </section> <!-- /.content -->
    </div> <!-- /.content-wrapper -->
</div> 

<!-- Modal - Add Car Trim-->
<div id="add_cartrim_modal" class="modal fade" role="dialog" data-toggle="modal">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Car Trim</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id='form_add_cartrim' method='post' action='{{URL("admin/car/trims")}}'>
                    <div class="form-group car_id">
                        <label class="control-label col-sm-3" for="brand">Car Make:</label>
                        <div class="col-sm-6">
                            <select id='select_add_cars' name = 'car_id' class='form-control' style='width:100%;' url='{{URL('admin/cardata')}}'>
                                <option value=''>Select Car Make</option>
                                @if(count($carResult)>0)
                                    @foreach($carResult as $result)
                                        <option value='{{ $result->id }}'>{{ $result->brand }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <span id='car_id'></span>
                        </div>
                    </div>
                    <div class="form-group year_id">
                        <label class="control-label col-sm-3" for="brand">Car Year:</label>
                        <div class="col-sm-6">
                            <select url='{{URL('admin/get-car-modal')}}' id='select_add_carmodel' name = 'year_id' class='form-control' style='width:100%;'>
                            </select>
                            <span id='year_id'></span>
                        </div>
                    </div>
                    <div class="form-group car_model_id">
                        <label class="control-label col-sm-3" for="car-model">Car Model:</label>
                        <div class="col-sm-6">
                            <select id='select_add_cartrim' name = 'car_model_id' style='width: 100%;'>
                                
                            </select>
                            <span id='car_model_id'></span>
                        </div>
                    </div>
                    <div class="form-group car_trim_name">
                        <label class="control-label col-sm-3" for="car-trim">Trim Name:</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name = 'car_trim_name' placeholder="Car Trim">
                            <span id='car_trim_name'></span>
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


<!-- Modal - Edit Car Trim-->
<div id="update_cartrim_modal" class="modal fade" role="dialog" data-toggle="modal">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Update Car Trim</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id='form_update_cartrim' method='post'>
                    <div class="form-group car_id">
                        <label class="control-label col-sm-3" for="brand">Car Make:</label>
                        <div class="col-sm-6">
                            <select id='update_add_cars' name = 'car_id' class='form-control' style='width:100%;' url='{{URL('admin/cardata')}}'>
                                <option value=''>Select Car Make</option>
                                @if(count($carResult)>0)
                                    @foreach($carResult as $result)
                                        <option value='{{ $result->id }}'>{{ $result->brand }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <span id='car_id'></span>
                        </div>
                    </div>
                    <div class="form-group year_id">
                        <label class="control-label col-sm-3" for="brand">Car Year:</label>
                        <div class="col-sm-6">
                            <select url='{{URL('admin/get-car-modal')}}' id='update_add_carmodel' name = 'year_id' class='form-control' style='width:100%;'>
                            </select>
                            <span id='year_id'></span>
                        </div>
                    </div>
                    <div class="form-group car_model_id">
                        <label class="control-label col-sm-3" for="car-model">Car Model:</label>
                        <div class="col-sm-6">
                            <select id='select_update_cartrim' name = 'car_model_id' style='width: 100%;'>
                                
                            </select>
                            <span id='car_model_id'></span>
                        </div>
                    </div>

                    <div class="form-group car_trim_name">
                        <label class="control-label col-sm-3" for="car-trim">Trim Name :</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name = 'car_trim_name' id='car_trim' placeholder="Car Trim">
                            <span id='car_trim_name'></span>
                        </div>
                    </div>                 
                    {{ csrf_field()}}   
                    {{ method_field('PUT') }}
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

<!-- Modal- Delete Car Trim -->
<div class="modal fade" id="delete_cartrim_modal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                <form id='form_delete_cartrim' method='post'> 

                    {{ method_field('DELETE') }}
                    {{ csrf_field()}}

                    <p class='text-center'>Are you sure you want to delete car trim ?</p>
                    <div class="modal-footer">
                        <div class='row'>
                            <div class='col-sm-8 modal_btn'>
                                <button type="submit" class="btn btn-info">Yes</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">No</button> 
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