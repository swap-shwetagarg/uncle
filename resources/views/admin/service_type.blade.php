@extends('layouts.admin')

@section('title', "Service Types | Uncle Fitter")

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
                                <div class="col-sm-11"><h4>Service Type</h4></div>
                                <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#add_service_type_modal">Add New</button>
                            </div>
                        </div>
                        <div class="panel-body">
                            @include('admin.service_type_table')
                        </div>
                    </div>
                </div>
            </div>
        </section> <!-- /.content -->
    </div> <!-- /.content-wrapper -->
</div> 

<!-- Modal - Add Service Type-->
<div id="add_service_type_modal" class="modal fade" role="dialog" data-toggle="modal">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Service Type</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id='form_add_service_type' method='post' action='{{URL("admin/service-types")}}'>
                    <div class="form-group service_type">
                        <label class="control-label col-sm-3" for="service-type">Service Type :</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name = 'service_type' placeholder="Service Type">
                            <span id='service_type'></span>
                        </div>
                    </div>
                    {{ csrf_field()}}  
                    <div class="modal-footer">
                        <div class='row'>
                            <div class='col-sm-12 modal_btn'>
                                <button type="submit" class="btn btn-info">Submit</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>    
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal - Edit Service Type -->
<div id="update_service_type_modal" class="modal fade" role="dialog" data-toggle="modal">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Update Service Type</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id='form_update_service_type' method='post'>
                    <div class="form-group service_type">
                        <label class="control-label col-sm-3" for="service-type">Service Type :</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name = 'service_type' id='update_service_type' placeholder="Service Type">
                            <span id='service_type'></span>
                        </div>
                    </div>
                    {{ csrf_field()}}   
                    {{ method_field('PUT') }}
                    <div class="modal-footer">
                        <div class='row'>
                            <div class='col-sm-12 modal_btn'>
                                <button type="submit" class="btn btn-info">Submit</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>    
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal- Delete Service Type -->
<div class="modal fade" id="delete_service_type_modal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                <form id='form_delete_service_type' method='post'> 

                    {{ method_field('DELETE') }}
                    {{ csrf_field()}}

                    <p class='text-center'>Are you sure you want to delete service type ?</p>
                    <div class="modal-footer">
                        <div class='row'>
                            <div class='col-sm-12 modal_btn'>
                                <button type="submit" class="btn btn-info">Yes</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">No</button> 
                            </div>
                        </div>
                    </div>
                </form>
            </div>             
        </div>
    </div>
</div>
@endsection