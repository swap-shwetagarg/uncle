@extends('layouts.admin')

@section('title', "Service Locations | Uncle Fitter")

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
                                <div class="col-sm-11"><h4>Locations</h4></div>
                                <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#add_zipcode_modal">Add</button>
                            </div>
                        </div>
                        <div class="panel-body">
                            @include('admin.zip_code_table')
                        </div>
                    </div>
                </div>
            </div>
        </section> <!-- /.content -->
    </div> <!-- /.content-wrapper -->
</div> 
<!-- Modal - Add zipcode -->
<div id="add_zipcode_modal" class="modal fade" role="dialog" data-toggle="modal">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Location</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id='form_add_zipcode' action='{{URL("admin/locations")}}' method='post'>

                    <div class="form-group zip_code">
                        <label class="control-label col-sm-3" for="zip-code">Location:</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name ='zip_code' placeholder="Location">
                            <span id='zip_code'></span>
                        </div>
                    </div>

                    <div class="form-group country_code">
                        <label class="control-label col-sm-3" for="country-code">Country Code:</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name = 'country_code' placeholder="Country code">
                            <span id='country_code'></span>
                        </div>
                    </div>

                    <div class="form-group service_availability">
                        <label class="control-label col-sm-3" for="availibility">Service Availability:</label>
                        <div class="col-sm-6">
                            <select class="form-control" name = 'service_availability'>
                                <option value=''>Select Availability</option>
                                <option value='1'>Yes</option>
                                <option value='0'>No</option>
                            </select>
                            <span id='service_availability'></span>
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

<!-- Modal - Update zipcode -->
<div id="update_zipcode_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Update Location</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id='form_update_zipcode' method='post' action = '{{url("admin/locations")}}/'>

                    <div class="form-group zip_code">
                        <label class="control-label col-sm-3" for="zip-code">Location:</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id='zipCode' name ='zip_code' placeholder="Location">
                            <span id='zip_code'></span>
                        </div>
                    </div>

                    <div class="form-group country_code">
                        <label class="control-label col-sm-3" for="country-code">Country Code:</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id='countryCode' name = 'country_code' placeholder="Country code">
                            <span id='country_code'></span>
                        </div>
                    </div>

                    <div class="form-group service_availability">
                        <label class="control-label col-sm-3" for="availibility">Service Availability:</label>
                        <div class="col-sm-6">
                            <select class="form-control" name = 'service_availability' id='serviceAvl'>
                                <option value=''>Select Availability</option>
                                <option value='1'>Yes</option>
                                <option value='0'>No</option>
                            </select>
                            <span id='service_availability'></span>
                        </div>
                    </div>
                    {{ method_field('PUT') }}
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

<!-- Modal- Delete Zip Code -->
<div class="modal fade" id="delete_zipcode_modal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                <form id='form_delete_zipcode' method='post'> 

                    {{ method_field('DELETE') }}
                    {{ csrf_field()}}

                    <p class='text-center'>Are you sure you want to delete Location ?</p>
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
