@extends('layouts.admin')

@section('title', "Users | Uncle Fitter")

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

                                <div class="row">
                                    <div class="col-sm-12 col-md-2 user__booking">
                                        @if(isset($page) && $page && $page == 'user')
                                        <h4>Users</h4>
                                        @elseif(isset($page) && $page && $page == 'mechanic')
                                        <h4>Mechanics</h4>
                                        @elseif(isset($page) && $page && $page == 'admin')
                                        <h4>Admins</h4>
                                        @endif
                                    </div>  
                                    @if(isset($page) && $page && $page == 'user')
                                    <div class="col-sm-12 col-md-6 search">
                                        <form method="GET" class="search_users_form" id="search_users_form" action="{{ URL('/admin/user/search') }}">
                                            <div class="search_users">    
                                                <div class="col-sm-12 col-md-10 search__input">
                                                    <input type="text" class="form-control" name="search_users" id="search_users" 
                                                           placeholder="Search by User Name or Email Address or Mobile Number">
                                                    <span id="searchclear" class="glyphicon glyphicon-remove-circle"></span>
                                                </div>
                                                <div class="col-sm-12 col-md-2 search__input__button">
                                                    <div class="btn-group">
                                                        <button class="btn btn-info btn-md" name="btn_search_users" type="button"
                                                                id="btn_search_users">Search</button>                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>                                    
                                    <div class="col-sm-12 col-md-2 pull-right">
                                        <a href="{{URL("admin/export")}}/User" class="btn btn-warning btn-sm pull-right">Export</a>     
                                    </div>
                                    <div class="col-sm-12 col-md-2 pull-right">
                                        <a href="{{ URL('admin/user/add/user') }}" class="btn btn-sm btn-primary">Add New User</a>
                                    </div>
                                    @elseif(isset($page) && $page && $page == 'mechanic')
                                    <div class="col-sm-12 col-md-10 pull-right">
                                        <a href="{{URL("admin/export")}}/Mechanic" class="btn btn-warning btn-sm pull-right">Export</a>
                                    </div>
                                    @endif
                                </div>
                            </div>                            
                        </div>
                        <div class="panel-body">
                            @include('admin.user_table')
                        </div>
                    </div>
                </div>
            </div>
        </section> <!-- /.content -->
    </div> <!-- /.content-wrapper -->
</div> 

<!-- Modal - Update User -->
<div id="update_user_modal" class="modal fade" role="dialog" data-toggle="modal">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">
                    <h4>Update
                        @if(isset($page) && $page && $page == 'user')
                        User
                        @elseif(isset($page) && $page && $page == 'mechanic')
                        Mechanic
                        @elseif(isset($page) && $page && $page == 'admin')
                        Admin
                        @endif 
                        Info</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id='form_update_user' method='post' enctype="multipart/form-data">
                    <div class="form-group name">
                        <label class="control-label col-sm-3" for="Name">Name:</label>
                        <div class="col-sm-6">
                            <input type='text' class='form-control' name='name' id='user_name' placeholder="Name">
                            <span id='name'></span>
                        </div>
                    </div>

                    <div class="form-group email">
                        <label class="control-label col-sm-3" for="email">E-Mail Id:</label>
                        <div class="col-sm-6">
                            <input type='text' class='form-control' name='email' id='user_email' placeholder="E-Mail Id">
                            <span id='email'></span>
                        </div>
                    </div>

                    <div class="form-group mobile">
                        <label class="control-label col-sm-3" for="phone">Phone:</label>
                        <div class="col-sm-6">
                            <input type='text' class='form-control' name='mobile' id='user_phone' placeholder="Phone">
                            <span id='mobile'></span>
                        </div>
                    </div>

                    <div class="form-group mobile">
                        <label class="control-label col-sm-3" for="phone">Profile Photo:</label>
                        <div class="col-sm-6">
                            <input type='file' name='profile_photo' id='profile_photo'>
                            <span id='profile_photo'></span>
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

<!-- Modal- Delete year  -->
<div class="modal fade" id="delete_user_modal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                <form id='form_delete_user' method='post'> 

                    {{ method_field('DELETE') }}
                    {{ csrf_field()}}

                    <p class='text-center'>Are you sure you want to delete user ?</p>
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