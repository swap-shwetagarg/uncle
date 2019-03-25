@extends('layouts.admin')

@section('title', "Service Categories | Uncle Fitter")

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
                                <div class="col-sm-11"><h4>Category</h4></div>
                                <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#add_category_modal">Add New</button>
                            </div>
                        </div>
                        <div class="panel-body">
                            @include('admin.category_table')
                        </div>
                    </div>
                </div>
            </div>
        </section> <!-- /.content -->
    </div> <!-- /.content-wrapper -->
</div> 

<!-- Modal - Add Category -->
<div id="add_category_modal" class="modal fade" role="dialog" data-toggle="modal">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Category</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id='form_add_category' method='post' action='{{URL("admin/categories")}}'>

                    <div class="form-group service_type_id">
                        <label class="control-label col-sm-3" for="service">Service :</label>
                        <div class="col-sm-9">
                            <select id='select_add_service_type' class='form-control' name='service_type_id' style='width:100%;'>
                                <option value=''>Select Service Type</option>
                                @if(count($service_type)>0)
                                @foreach($service_type as $service)
                                <option value='{{ $service->id }}'>{{ $service->service_type }}</option>
                                @endforeach
                                @endif
                            </select>
                            <span id='service_type_id'></span>
                        </div>
                    </div>

                    <div class="form-group category_name">
                        <label class="control-label col-sm-3" for="category">Category Name :</label>
                        <div class="col-sm-9">
                            <input type='text' name='category_name' class='form-control' placeholder="Category Name">
                            <span id='category_name'></span>
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


<!-- Modal - Update Category  -->
<div id="update_category_modal" class="modal fade" role="dialog" data-toggle="modal">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Update Category</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id='form_update_category' method='post'>
                    <div class="form-group service_type_id">
                        <label class="control-label col-sm-3" for="service">Service :</label>
                        <div class="col-sm-9">
                            <select id='select_update_service_type' class='form-control' name='service_type_id' id='service_type' style='width:100%;'>
                                <option value=''>Select Service Type</option>
                                @if(count($service_type)>0)
                                @foreach($service_type as $service)
                                <option value='{{ $service->id }}'>{{ $service->service_type }}</option>
                                @endforeach
                                @endif
                            </select>
                            <span id='service_type_id'></span>
                        </div>
                    </div>

                    <div class="form-group category_name">
                        <label class="control-label col-sm-3" for="category">Category Name :</label>
                        <div class="col-sm-9">
                            <input type='text' name='category_name' class='form-control' id='category' placeholder="Category Name">
                            <span id='category_name'></span>
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



<!-- Modal- Delete category -->
<div class="modal fade" id="delete_category_modal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                <form id='form_delete_category' method='post' action = ''> 

                    {{ method_field('DELETE') }}
                    {{ csrf_field()}}

                    <p class='text-center'>Are you sure you want to delete category ?</p>
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