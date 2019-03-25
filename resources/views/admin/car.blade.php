@extends('layouts.admin')

@section('title', "Car Makes | Uncle Fitter")

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
                                <div class="col-sm-11"><h4>Car Makes</h4></div>
                                <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#add_car_service_modal">Add</button>
                            </div>
                        </div>
                        <div class="panel-body">
                            @include('admin.car_table')
                        </div>
                    </div>
                </div>
            </div>
        </section> <!-- /.content -->
    </div> <!-- /.content-wrapper -->
</div> 

<!-- Modal - Add Car Service-->
<div id="add_car_service_modal" class="modal fade" role="dialog" data-toggle="modal">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Car Make</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id='form_add_car_service' method='post' action='{{URL("admin/car/makes")}}' enctype="multipart/form-data">

                    <div class="form-group brand">
                        <label class="control-label col-sm-3" for="brand">Make Name:</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name = 'brand' placeholder="Brand">
                            <span id='brand'></span>
                        </div>
                    </div>

                    <div class="form-group description">
                        <label class="control-label col-sm-3" for="description">Description :</label>
                        <div class="col-sm-6">
                            <textarea class="form-control" name = 'description' placeholder="Description"></textarea>
                            <span id='description'></span>
                        </div>
                    </div>

                    <div class="form-group car_image">
                        <label class="control-label col-sm-3" for="description">Upload Image :</label>
                        <div class="col-sm-6">
                            <input type='file' class="form-control file" name = 'car_image' >
                            <span id='car_image'></span>
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

<!-- Modal - Edit Car Service-->
<div id="update_car_service_modal" class="modal fade" role="dialog" data-toggle="modal">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Update Car Make</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id='form_update_car_service' method='post'>
                    <div class="form-group brand">
                        <label class="control-label col-sm-3" for="brand">Make Name :</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name = 'brand' id ="carBrand" placeholder="Brand">
                            <span id='brand'></span>
                        </div>
                    </div>

                    <div class="form-group description">
                        <label class="control-label col-sm-3" for="description">Description :</label>
                        <div class="col-sm-6">
                            <textarea class="form-control" name = 'description' id='carDescription' placeholder="Description"></textarea>
                            <span id='description'></span>
                        </div>
                    </div>

                    <div class="form-group car_image">
                        <label class="control-label col-sm-3" for="image">Upload Image :</label>
                        <div class="col-sm-6">
                            <input type='file' class="form-control file" name = 'car_image' >
                            <span id='car_image'></span>
                        </div>
                    </div>
                    <input type='hidden' id='carImageUrl' name='car_image_url'>
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

<!-- Modal- Delete car service -->
<div class="modal fade" id="delete_car_service_modal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                <form id='form_delete_car_service' method='post' action = ''> 

                    {{ method_field('DELETE') }}
                    {{ csrf_field()}}

                    <p class='text-center'>Are you sure you want to delete this car make ?</p>
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