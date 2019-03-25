@extends('layouts.admin')

@section('title', "Car Models | Uncle Fitter")

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
                                <div class="col-sm-11"><h4>Car Models</h4></div>
                                <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#add_car_modal">Add</button>
                            </div>
                        </div>
                        <div class="panel-body">
                            @include('admin.carmodel_table')
                        </div>
                    </div>
                </div>
            </div>
        </section> <!-- /.content -->
    </div> <!-- /.content-wrapper -->
</div> 

<!-- Modal - Add Car model-->
<div id="add_car_modal" class="modal fade" role="dialog" data-toggle="modal">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Car Model</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id='form_add_carmodel' method='post' action='{{URL('admin/car/models')}}'>

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
                            <select id='select_add_carmodel' name = 'year_id' class='form-control' style='width:100%;'>
                            </select>
                            <span id='year_id'></span>
                        </div>
                    </div>

                    <div class="form-group modal_name">
                        <label class="control-label col-sm-3" for="modal-name">Model Name :</label>
                        <div class="col-sm-6">
                            <input type='text' name='modal_name' class="form-control" placeholder="Model Name">
                            <span id='modal_name'></span>
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

<!-- Modal - Edit Car Model-->
<div id="update_carmodal" class="modal fade" role="dialog" data-toggle="modal">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Update Car Model</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id='form_update_carmodel' method='post'>
                    <div class="form-group car_id">
                        <label class="control-label col-sm-3" for="brand">Car Make:</label>
                        <div class="col-sm-6">
                            <select id='select_update_cars' name = 'car_id' class='form-control' style='width:100%;' url='{{URL('admin/cardata')}}'>
                                <option value=''>Select Car</option>
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
                        <label class="control-label col-sm-3" for="Year">Car Year:</label>
                        <div class="col-sm-6">
                            <select id='select_update_carmodel' name = 'year_id' class="form-control" style='width: 100%;'>
                            </select>
                            <span id='year_id'></span>
                        </div>
                    </div>

                    <div class="form-group modal_name">
                        <label class="control-label col-sm-3" for="modal-name">Model Name :</label>
                        <div class="col-sm-6 modal_name">
                            <input type='text' name='modal_name' id='modalName' class="form-control" placeholder="Model Name">
                            <span id='modal_name'></span>
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

<!-- Modal- Delete Car Model  -->
<div class="modal fade" id="delete_carmodal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                <form id='form_delete_carmodel' method='post'> 

                    {{ method_field('DELETE') }}
                    {{ csrf_field()}}

                    <p class='text-center'>Are you sure you want to delete car model ?</p>
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