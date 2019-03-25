@extends('layouts.admin')
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
                                        <h4>User Profile</h4> 
                                    </div>
                                </div>
                                <div class="panel-body">
                                        <a href='javascript:void(0)' class='pull-right profile-link' id='change_password'>Change Password</a>
                                        <a href='javascript:void(0)' class='pull-right' id='edit_profile'>Edit Profile</a>
                                    <div id='user_profile_div'>
                                        <div class='row'>
                                            <div class='col-sm-12'>
                                                 <div class='col-sm-4 text-right'>
                                                     <h3>User Name</h3>
                                                </div>
                                                <div class='col-sm-4 profile-content'>
                                                     <h3>{{ $user->name }}</h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='row'>
                                            <div class='col-sm-12'>
                                                 <div class='col-sm-4 text-right'>
                                                     <h3>Email-Id</h3>
                                                </div>
                                                <div class='col-sm-4 profile-content'>
                                                     <h3>{{ $user->email }}</h3>
                                                </div>
                                            </div>
                                        </div> 
                                        <div class='row'>
                                            <div class='col-sm-12'>
                                                 <div class='col-sm-4 text-right'>
                                                     <h3>Phone</h3>
                                                </div>
                                                <div class='col-sm-4 profile-content'>
                                                     <h3>{{ $user->mobile }}</h3>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                                    <form id="edit_profile_form" class="form-horizontal form-margin" action='{{ url("admin/user")}}/{{ $user->id}}' method='post'>
                                        
                                        <div class="form-group name">
                                            <label class="control-label col-sm-3 col-sm-offset-2" for="name">Username :</label>
                                            <div class="col-sm-3">
                                              <input type="text" class="form-control" name = 'name' placeholder="Username" value="{{ $user->name }}">
                                              <span id='name'></span>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group email">
                                            <label class="control-label col-sm-3 col-sm-offset-2" for="email">Email :</label>
                                            <div class="col-sm-3">
                                              <input type="text" class="form-control" name = 'email' placeholder="Email" value="{{ $user->email }}">
                                              <span id='email'></span>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group mobile">
                                            <label class="control-label col-sm-3 col-sm-offset-2" for="phone">phone :</label>
                                            <div class="col-sm-3">
                                              <input type="text" class="form-control phone-no" name = 'mobile' placeholder="Phone" value="{{ $user->mobile }}  ">
                                              <span id='mobile'></span>
                                            </div> 
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="control-label col-sm-3 col-sm-offset-2" for="name"></label>
                                            <div class="col-sm-3 text-center">
                                                <button type="submit" class="btn btn-info">Update Profile</button>
                                            </div>
                                        </div>
                                        {{ csrf_field()}}  
                                        {{ method_field('PUT') }}
                                    </form>
                                        
                                    <form id="change_password_form" class="form-horizontal form-margin" action="{{ url('admin/change-password') }}"  method='post'>
                                        <div class="form-group old_password">
                                            <label class="control-label col-sm-3 col-sm-offset-2" for="name">Old Password :</label>
                                            <div class="col-sm-3">
                                              <input type="password" class="form-control" name = 'old_password' placeholder="Old Password">
                                              <span id="old_password"></span>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group new_password">
                                            <label class="control-label col-sm-3 col-sm-offset-2" for="email">New Password :</label>
                                            <div class="col-sm-3">
                                              <input type="password" class="form-control" name = 'new_password' placeholder="New Password">
                                              <span id="new_password"></span>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group new_password_confirmation">
                                            <label class="control-label col-sm-3 col-sm-offset-2" for="phone">Confirm Password :</label>
                                            <div class="col-sm-3">
                                              <input type="password" class="form-control" name = 'new_password_confirmation' placeholder="Password Confirmation">
                                              <span id="new_password_confirmation"></span>
                                            </div> 
                                        </div>
                                        {{ csrf_field()}}  
                                        {{ method_field('PUT') }}
                                        <div class="form-group">
                                            <label class="control-label col-sm-3 col-sm-offset-2" for="name"></label>
                                            <div class="col-sm-3 text-center">
                                                <button type="submit" class="btn btn-info">Change Password</button>
                                            </div>
                                        </div>
                                        
                                    </form>
                                        
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </section> <!-- /.content -->
            </div> <!-- /.content-wrapper -->
        </div> 
@endsection
