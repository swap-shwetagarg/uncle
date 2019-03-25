@extends('layouts.admin')

@section('title', "Services | Uncle Fitter")

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
                                <div class="col-sm-11"><h4>Services</h4></div>
                                <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#add_service_modal">Add New</button>
                            </div>
                        </div>
                        <div class="panel-body">
                            @include('admin.service_table')
                        </div>
                    </div>
                </div>
            </div>
        </section> <!-- /.content -->
    </div> <!-- /.content-wrapper -->
</div> 

<!-- Modal - Add Service Type-->
<div id="add_service_modal" class="modal fade" role="dialog" data-toggle="modal">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Service</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id='form_add_service' method='post' action='{{URL("admin/services")}}'>
                    <div class="form-group category_id">
                        <label class="control-label col-sm-2" for="category">Category :</label>
                        <div class="col-sm-10">
                            <select id='select_add_category' name='category_id' style='width: 100%;'>
                                <option value=''>Select Category</option>
                                @if(count($category)>0)
                                @foreach($category as $result)
                                <option value='{{ $result->id }}'>{{ $result->category_name}}</option>
                                @endforeach
                                @endif
                            </select>
                            <span id='category_id'></span>
                        </div>
                    </div>

                    <div class="form-group title">
                        <label class="control-label col-sm-2" for="title">Title :</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name = 'title' placeholder="Service Title">
                            <span id='title'></span>
                        </div>
                    </div>

                    <div class="form-group recommend_service_id hidden">
                        <label class="control-label col-sm-2" for="recommend_service_id">Recommend Inspection Service :</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="recommend_service_id[]" id="recommend_service_id" multiple>
                                <option value="">Select Recommended Service</option>
                                @if(isset($inspection_services) && $inspection_services && !$inspection_services->isEmpty())
                                @foreach($inspection_services AS $inspection_service)
                                <option value="{{ $inspection_service->id }}">{{ $inspection_service->title }}</option>
                                @endforeach
                                @endif
                            </select>
                            <span id='recommend_service_id'></span>
                        </div>
                    </div>

                    <div class="form-group description">
                        <label class="control-label col-sm-2" for="description">Description :</label>
                        <div class="col-sm-10">
                            <textarea class="form-control editor" name = 'description' id="description" placeholder="Service Description"></textarea>
                            <span id='description'></span>
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

<!-- Modal - Edit Service Type-->
<div id="update_service_modal" class="modal fade" role="dialog" data-toggle="modal">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Update Service</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id='form_update_service' method='post'>
                    <div class="form-group category_id">
                        <label class="control-label col-sm-2" for="category">Category :</label>
                        <div class="col-sm-10">
                            <select id='select_update_category' name='category_id' style='width: 100%;'>
                                <option value=''>Select Category</option>
                                @if(count($category)>0)
                                @foreach($category as $result)
                                <option value='{{ $result->id }}'>{{ $result->category_name}}</option>
                                @endforeach
                                @endif
                            </select>
                            <span id='category_id'></span>
                        </div>
                    </div>

                    <div class="form-group title">
                        <label class="control-label col-sm-2" for="title">Title :</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name = 'title' id='service_title' placeholder="Service Title">
                            <span id='title'></span>
                        </div>
                    </div>

                    <div class="form-group recommend_service_id hidden">
                        <label class="control-label col-sm-2" for="recommend_service_id">Recommend Inspection Service :</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="recommend_service_id[]" id="recommend_service_id" multiple>
                                <option value="">Select Recommended Service</option>
                                @if(isset($inspection_services) && $inspection_services && !$inspection_services->isEmpty())
                                @foreach($inspection_services AS $inspection_service)
                                <option value="{{ $inspection_service->id }}">{{ $inspection_service->title }}</option>
                                @endforeach
                                @endif
                            </select>
                            <span id='recommend_service_id'></span>
                        </div>
                    </div>

                    <div class="form-group description">
                        <label class="control-label col-sm-2" for="description">Description :</label>
                        <div class="col-sm-10">
                            <textarea class="form-control editor" name = 'description' id='service_desc' placeholder="Service Description"></textarea>
                            <span id='description'></span>
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
<div class="modal fade" id="delete_service_modal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                <form id='form_delete_service' method='post'> 

                    {{ method_field('DELETE') }}
                    {{ csrf_field()}}

                    <p class='text-center'>Are you sure you want to delete service ?</p>
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