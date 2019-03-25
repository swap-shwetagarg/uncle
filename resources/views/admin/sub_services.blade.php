@extends('layouts.admin')

@section('title', "Sub Services | Uncle Fitter")

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
                                <div class="col-sm-11"><h4>Sub-Services</h4></div>
                                <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#add_sub_service_modal">Add New</button>
                            </div>
                        </div>
                        <div class="panel-body">
                            @include('admin.sub_services_table')
                        </div>
                    </div>
                </div>
            </div>
        </section> <!-- /.content -->
    </div> <!-- /.content-wrapper -->
</div> 

<!-- Modal - Add Sub Service-->
<div id="add_sub_service_modal" class="modal fade" role="dialog" data-toggle="modal">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Sub-Service</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id='form_add_sub_service' method='post' action='{{URL("admin/sub-services")}}'>
                    <div class="form-group service_id">
                        <label class="control-label col-sm-2" for="service">Service :</label>
                        <div class="col-sm-10">
                            <select id='select_add_service' class='form-control' name='service_id' style='width: 100%;'>
                                <option value=''>Select Service</option>
                                @if(count($services)>0)
                                @foreach($services as $result)
                                <option value='{{ $result->id }}'>{{ $result->title }} ({{ $result->id }})</option>
                                @endforeach
                                @endif
                            </select>
                            <span id='service_id'></span>
                        </div>
                    </div>

                    <div class="form-group title">
                        <label class="control-label col-sm-2" for="display_text">Display Text :</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name = 'display_text' placeholder="Display Text">
                            <span id='display_text'></span>
                        </div>
                    </div>

                    <div class="form-group title">
                        <label class="control-label col-sm-2" for="title">Title :</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name = 'title' placeholder="Title">
                            <span id='title'></span>
                        </div>
                    </div>

                    <div class="form-group description">
                        <label class="control-label col-sm-2" for="description">Description :</label>
                        <div class="col-sm-10">
                            <textarea class="form-control editor" name = 'description' placeholder="Description"></textarea>
                            <span id='description'></span>
                        </div>
                    </div>

                    <div class="form-group order">
                        <label class="control-label col-sm-2" for="order">Order :</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name = 'order' placeholder="Order">
                            <span id='order'></span>
                        </div>
                    </div>

                    <div class="form-group selection_type">
                        <label class="control-label col-sm-2" for="selection-type">Selection Type :</label>
                        <div class="col-sm-4">
                            <select class="form-control" name = 'selection_type'>
                                <option value=''>Select Selection Type</option>
                                <option value='M'>Multiple</option>
                                <option value='S'>Single</option>
                            </select>
                            <span id='selection_type'></span>
                        </div>
                    </div>

                    <div class="form-group optional">
                        <label class="control-label col-sm-2" for="optional">Optional :</label>
                        <div class="col-sm-4">
                            <input type="checkbox" name="optional" id="optional" value="1" />
                            <span id='optional'></span>
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


<!-- Modal - Update Sub Services-->
<div id="update_sub_service_modal" class="modal fade" role="dialog" data-toggle="modal">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Update Sub-Service</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id='form_update_sub_service' method='post'>
                    <div class="form-group service_id">
                        <label class="control-label col-sm-2" for="service">Service :</label>
                        <div class="col-sm-10">
                            <select id='select_update_service' class='form-control' name='service_id' style='width: 100%;'>
                                <option value=''>Select Service</option>
                                @if(count($services)>0)
                                @foreach($services as $result)
                                <option value='{{ $result->id }}'>{{ $result->title }} ({{ $result->id }})</option>
                                @endforeach
                                @endif
                            </select>
                            <span id='service_id'></span>
                        </div>
                    </div>

                    <div class="form-group title">
                        <label class="control-label col-sm-2" for="title">Title :</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name = 'title' id='title_sub_service' placeholder="Title">
                            <span id='title'></span>
                        </div>
                    </div>

                    <div class="form-group title">
                        <label class="control-label col-sm-2" for="display_text">Display Text :</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name = 'display_text' id='display_text_sub_service' placeholder="Display Text">
                            <span id='display_text'></span>
                        </div>
                    </div>

                    <div class="form-group description">
                        <label class="control-label col-sm-2" for="description">Description :</label>
                        <div class="col-sm-10">
                            <textarea class="form-control editor" name = 'description' id='des_sub_service' placeholder="Description"></textarea>
                            <span id='description'></span>
                        </div>
                    </div>

                    <div class="form-group order">
                        <label class="control-label col-sm-2" for="order">Order :</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name = 'order' id='order_sub_service' placeholder="Order">
                            <span id='order'></span>
                        </div>
                    </div>

                    <div class="form-group selection_type">
                        <label class="control-label col-sm-2" for="selection-type">Selection Type :</label>
                        <div class="col-sm-4">
                            <select class="form-control" name='selection_type' id='selection_type_sub_service'>
                                <option value=''>Select Selection Type</option>
                                <option value='M'>Multiple</option>
                                <option value='S'>Single</option>
                            </select>
                            <span id='selection_type'></span>
                        </div>
                    </div>

                    <div class="form-group optional">
                        <label class="control-label col-sm-2" for="optional">Optional :</label>
                        <div class="col-sm-4">                                          
                            <input type="checkbox" name="optional" id="optional_sub_service" value="1" />
                            <span id='optional'></span>
                        </div>
                    </div>

                    {{ method_field('PUT') }}
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

<!-- Modal- Delete Sub Services -->
<div class="modal fade" id="delete_sub_service_modal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                <form id='form_delete_sub_service' method='post'> 

                    {{ method_field('DELETE') }}
                    {{ csrf_field()}}
                    <p class='text-center'>Are you sure you want to delete sub-service ?</p>
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