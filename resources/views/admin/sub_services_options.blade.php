@extends('layouts.admin')

@section('title', "Sub-Service Options | Uncle Fitter")

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
                                <div class="col-sm-11"><h4>Sub-Services Options</h4></div>
                                <button type="button" class="btn btn-info btn-md" data-toggle="modal" 
                                        data-target="#add_sub_service_opt_modal">Add New</button>
                            </div>
                        </div>
                        <div class="panel-body">
                            @include('admin.sub_services_options_table')
                        </div>
                    </div>
                </div>
            </div>
        </section> <!-- /.content -->
    </div> <!-- /.content-wrapper -->
</div> 

<!-- Modal - Add Sub Services Options-->
<div id="add_sub_service_opt_modal" class="modal fade" role="dialog" data-toggle="modal">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Sub-Service Option</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id='form_add_sub_service_opt' method='post' action='{{URL("admin/sub-service-options")}}'
                      enctype="multipart/form-data">
                    <div class="form-group sub_service_id">
                        <label class="control-label col-sm-2" for="service-type">Sub-Service Type :</label>
                        <div class="col-sm-10">
                            <select id='select_add_subservice_opt' class='form-control' name='sub_service_id' style='width: 100%;'>
                                <option value=''>Select Sub-Service</option>
                                @if(count($subServices)>0)
                                @foreach($subServices as $result)
                                <option value='{{ $result->id }}'>{{ $result->title }} ({{ $result->id }})</option>
                                @endforeach
                                @endif
                            </select>
                            <span id='sub_service_id'></span>
                        </div>
                    </div>

                    <div class="form-group option_type">
                        <label class="control-label col-sm-2" for="title">Option Type :</label>
                        <div class="col-sm-4">
                            <select class="form-control" name="option_type" id="option_type">
                                <option value="1">Text Type</option>
                                <option value="2">Image Type</option>
                            </select>
                            <span id='option_type'></span>
                        </div>
                    </div>

                    <div class="form-group option_name">
                        <label class="control-label col-sm-2" for="title">Option Name :</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name = 'option_name' placeholder="Option Name">
                            <span id='option_name'></span>
                        </div>
                    </div>

                    <div class="form-group option_image hidden">
                        <label class="control-label col-sm-2" for="description">Upload Option Image :</label>
                        <div class="col-sm-6">
                            <input type='file' class="form-control file" name = 'option_image' >
                            <span id='option_image'></span>
                        </div>
                    </div>

                    <div class="form-group recommend_service_id">
                        <label class="control-label col-sm-2" for="recommend_service_id">Recommend Inspection Service :</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="recommend_service_id[]" id="recommend_service_id" multiple="">
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

                    <div class="form-group option_description">
                        <label class="control-label col-sm-2" for="description">Option Description :</label>
                        <div class="col-sm-10">
                            <textarea class="form-control editor" name = 'option_description' placeholder="Option Description"></textarea>
                            <span id='option_description'></span>
                        </div>
                    </div>

                    <div class="form-group option_order">
                        <label class="control-label col-sm-2" for="order">Option Order :</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name = 'option_order' placeholder="Option Order">
                            <span id='option_order'></span>
                        </div>
                    </div>

                    <div class="form-group sub_service_id_ref">
                        <label class="control-label col-sm-2" for="service-type">Next Sub-Service:</label>
                        <div class="col-sm-10">
                            <?php
                            $servicesCategory = $servicesTypes[0]->category[0];
                            ?>
                            <select id='select_next_subservice' class='form-control' name='sub_service_id_ref' style='width: 100%;'>
                                <option value='0'>Select Sub-Service</option>
                                @if(isset($servicesCategory) && $servicesCategory)
                                <?php $services = $servicesCategory->service; ?>
                                @if(isset($services) && $services)
                                @foreach($services AS $service)
                                <?php $sub_services = $service->subservice; ?>
                                @if(isset($sub_services) && $sub_services)
                                @foreach($sub_services as $result)
                                <option value='{{ $result->id }}'>{{ $result->title }}</option>
                                @endforeach
                                @endif
                                @endforeach
                                @endif
                                @endif
                            </select>
                            <span id='sub_service_id_ref'></span>
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


<!-- Modal - Update Sub Services Options-->
<div id="update_sub_service_opt_modal" class="modal fade" role="dialog" data-toggle="modal">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Update Sub-Service-Option</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id='form_update_sub_service_opt' method='post' action="{{URL('admin/subserviceopt')}}"
                      enctype="multipart/form-data">
                    <div class="form-group sub_service_id">
                        <label class="control-label col-sm-2" for="service-type">Service Type :</label>
                        <div class="col-sm-10">
                            <select id='select_update_subservice_opt' class='form-control' name='sub_service_id' style='width: 100%;'>
                                <option value=''>Select Sub-Service</option>
                                @if(count($subServices)>0)
                                @foreach($subServices as $result)
                                <option value='{{ $result->id }}'>{{ $result->title }} ({{ $result->id }})</option>
                                @endforeach
                                @endif
                            </select>
                            <span id='sub_service_id'></span>
                        </div>
                    </div>

                    <div class="form-group option_type">
                        <label class="control-label col-sm-2" for="title">Option Type :</label>
                        <div class="col-sm-4">
                            <select class="form-control" name="option_type" id="option_type">
                                <option value="1">Text Type</option>
                                <option value="2">Image Type</option>
                            </select>
                            <span id='option_type'></span>
                        </div>
                    </div>

                    <div class="form-group option_name">
                        <label class="control-label col-sm-2" for="title">Option Name :</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name = 'option_name' id='sub_service_opt_name' placeholder="Option Name">
                            <span id='option_name'></span>
                        </div>
                    </div>

                    <div class="form-group option_image hidden">
                        <label class="control-label col-sm-2" for="description">Upload Option Image :</label>
                        <div class="col-sm-6">
                            <input type='file' class="form-control file" name = 'option_image' >
                            <span id='option_image'></span>
                        </div>
                    </div>

                    <div class="form-group recommend_service_id">
                        <label class="control-label col-sm-2" for="recommend_service_id">Recommend Inspection Service :</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="recommend_service_id[]" id="recommend_service_id" multiple="">
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

                    <div class="form-group option_description">
                        <label class="control-label col-sm-2" for="description">Option Description :</label>
                        <div class="col-sm-10">
                            <textarea class="form-control editor" name = 'option_description' id ='sub_service_opt_desc' placeholder="Option Description"></textarea>
                            <span id='option_description'></span>
                        </div>
                    </div>

                    <div class="form-group option_order">
                        <label class="control-label col-sm-2" for="order">Option Order :</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name = 'option_order' id='sub_service_opt_order' placeholder="Option Order">
                            <span id='option_order'></span>
                        </div>
                    </div>

                    <div class="form-group sub_service_id_ref">
                        <label class="control-label col-sm-2" for="service-type">Next Sub-Service:</label>
                        <div class="col-sm-10">
                            <?php
                            $servicesCategory = $servicesTypes[0]->category[0];
                            ?>
                            <select id='select_update_next_subservice' class='form-control' name='sub_service_id_ref' style='width: 100%;'>
                                <option value=''>Select Sub-Service</option>
                                @if(isset($servicesCategory) && $servicesCategory)
                                <?php $services = $servicesCategory->service; ?>
                                @if(isset($services) && $services)
                                @foreach($services AS $service)
                                <?php $sub_services = $service->subservice; ?>
                                @if(isset($sub_services) && $sub_services)
                                @foreach($sub_services as $result)
                                <option value='{{ $result->id }}'>{{ $result->title }}</option>
                                @endforeach
                                @endif
                                @endforeach
                                @endif
                                @endif
                            </select>
                            <span id='sub_service_id_ref'></span>
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

<!-- Modal- Delete Sub Services options-->
<div class="modal fade" id="delete_sub_service_opt_modal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                <form id='form_delete_sub_service_opt' method='post'> 

                    {{ method_field('DELETE') }}
                    {{ csrf_field()}}

                    <p class='text-center'>Are you sure you want to delete sub-service options ?</p>
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