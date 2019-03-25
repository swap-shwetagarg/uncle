@extends('layouts.admin')

@section('title', 'User Profile | Uncle Fitter')

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
                            <form id="user_profile_form" class="form-horizontal" action="{{URL('user/'.$user->id)}}" method='post'>
                                {{ csrf_field()}}  
                                {{ method_field('PUT') }}
                                <div class="form-group name">
                                    <label class="control-label col-sm-3 col-sm-offset-2" for="name">Username :</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name = 'name' placeholder="Username" value="{{ $user->name }}">
                                        <span id='name'></span>
                                    </div>
                                </div>

                                <div class="form-group email">
                                    <label class="control-label col-sm-3 col-sm-offset-2" for="email">Email :</label>
                                    <div class="col-sm-4">                                                
                                        <input value='{{$user->email}}' type="text" class="form-control" name = 'email' placeholder="Email"
                                               <span id='email'></span>

                                    </div>
                                </div>

                                <div class="form-group mobile">
                                    <label class="control-label col-sm-3 col-sm-offset-2" for="phone">Mobile :</label>
                                    <div class="col-sm-4">
                                        <input value='{{$user->mobile}}' type="text" class="form-control" name = 'mobile' placeholder="Phone">
                                        <span id='mobile'></span>                                              
                                    </div> 
                                </div>
                                <span class="hidden welcome_path" data-welcome_path="{{URL('welcome')}}"></span>         
                                <div class="form-group">
                                    <label class="control-label col-sm-3 col-sm-offset-2" for="button"></label>
                                    <div class="col-sm-4 text-center">
                                        <button type="submit" class="btn btn-info">Update Profile</button>
                                    </div>
                                </div>
                            </form> 
                            <form id="user_change_password_form" class="form-horizontal user-form" action="{{ url('change-password') }}"  method='post'>
                                <div class="form-group old_password">
                                    <label class="control-label col-sm-3 col-sm-offset-2" for="name">Old Password :</label>
                                    <div class="col-sm-4">
                                        <input type="password" class="form-control" name = 'old_password' placeholder="Old Password">
                                        <span id="old_password"></span>
                                    </div>
                                </div>

                                <div class="form-group new_password">
                                    <label class="control-label col-sm-3 col-sm-offset-2" for="email">New Password :</label>
                                    <div class="col-sm-4">
                                        <input type="password" class="form-control" name = 'new_password' placeholder="New Password">
                                        <span id="new_password"></span>
                                    </div>
                                </div>

                                <div class="form-group new_password_confirmation">
                                    <label class="control-label col-sm-3 col-sm-offset-2" for="phone">Confirm Password :</label>
                                    <div class="col-sm-4">
                                        <input type="password" class="form-control" name = 'new_password_confirmation' placeholder="Password Confirmation">
                                        <span id="new_password_confirmation"></span>
                                    </div> 
                                </div>
                                {{ csrf_field()}}  
                                {{ method_field('PUT') }}
                                <div class="form-group">
                                    <label class="control-label col-sm-3 col-sm-offset-2" for="name"></label>
                                    <div class="col-sm-4 text-center">
                                        <button type="submit" class="btn btn-info">Change Password</button>
                                    </div>
                                </div>

                            </form>
                            
                            <form id="user_change_password_form" class="user_change_location_form form-horizontal user-form" action="{{ url('change-location') }}"  method='post'>
                                <div class="form-group">
                                    <label class="control-label col-sm-3 col-sm-offset-2" for="location">Location :</label>
                                    <div class="col-md-4 col-sm-4">
                                        <select class="form-control" name="location" id="location">
                                            @if(isset($locations) && $locations)
                                                @foreach($locations AS $location_value)
                                                    <option value="{{$location_value->id}}" {{($location_value->id === Auth::user()->default_location)?'selected':''}}>{{$location_value->zip_code}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>    
                                {{ csrf_field()}}  
                                <div class="form-group">
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-info">Change Location</button>
                                    </div>
                                </div>
                            </form>

                            <div id='user_address_div'>
                                <div class='row'>
                                    <input type='button' class='btn btn-primary pull-right address-content' data-toggle="modal" data-target = "#add_user_address_modal" value='Add address'>
                                </div>

                                <div class='address-table'>
                                    @include('web.user.user_address')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> <!-- /.content -->
    </div> <!-- /.content-wrapper -->
</div> 

<!-- Modal- Delete category -->
<div class="modal fade" id="delete_user_address_modal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                <form id='delete_user_address_form' method='post' action = ''> 

                    {{ method_field('DELETE') }}
                    {{ csrf_field()}}

                    <p class='text-center'>Are you sure you want to delete address ?</p>
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

<!-- Modal - Add User Address -->
<div id="add_user_address_modal" class="modal fade" role="dialog" data-toggle="modal">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Address</h4>
            </div>
            <div class="modal-body">
                <form id="user_add_address_form" class="form-horizontal" method='post' action='{{url("user/address")}}'>
                    <div class="form-group add_1">
                        <label class="control-label col-sm-3 " for="add_1">Address 1 :</label>
                        <div class="col-sm-6">
                            <textarea class="form-control" name = 'add_1' placeholder="Address 1"></textarea>
                            <span id="add_1"></span>
                        </div>
                    </div>

                    <div class="form-group add_2">
                        <label class="control-label col-sm-3 " for="add_2">Address 2 :</label>
                        <div class="col-sm-6">
                            <textarea class="form-control" name = 'add_2' placeholder="Address 2"></textarea>
                            <span id="add_2"></span>
                        </div>
                    </div>

                    <div class="form-group zipcode">
                        <label class="control-label col-sm-3 " for="zipcode">Zipcode :</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name = 'zipcode' placeholder="Zipcode">
                            <span id="zipcode"></span>
                        </div> 
                    </div>

                    <div class="form-group area">
                        <label class="control-label col-sm-3 " for="area">Area :</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name = 'area' placeholder="Area">
                            <span id="area"></span>
                        </div> 
                    </div>

                    <div class="form-group country">
                        <label class="control-label col-sm-3 " for="country">Country :</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name = 'country' placeholder="Country">
                            <span id="country"></span>
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

<!-- Modal - Add User Address -->
<div id="update_user_address_modal" class="modal fade" role="dialog" data-toggle="modal">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Update Address</h4>
            </div>
            <div class="modal-body">
                <form id="user_update_address_form" class="form-horizontal" method='post'>
                    <div class="form-group add_1">
                        <label class="control-label col-sm-3 " for="add_1">Address 1 :</label>
                        <div class="col-sm-6">
                            <textarea class="form-control" name = 'add_1' id='address_1' placeholder="Address 1"></textarea>
                            <span id="add_1"></span>
                        </div>
                    </div>

                    <div class="form-group add_2">
                        <label class="control-label col-sm-3 " for="add_2">Address 2 :</label>
                        <div class="col-sm-6">
                            <textarea class="form-control" name = 'add_2' id='address_2' placeholder="Address 2"></textarea>
                            <span id="add_2"></span>
                        </div>
                    </div>

                    <div class="form-group zipcode">
                        <label class="control-label col-sm-3 " for="zipcode">Zipcode :</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name = 'zipcode' id='address_zipcode' placeholder="Zipcode">
                            <span id="zipcode"></span>
                        </div> 
                    </div>

                    <div class="form-group area">
                        <label class="control-label col-sm-3 " for="area">Area :</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name = 'area' id='address_area' placeholder="Area">
                            <span id="area"></span>
                        </div> 
                    </div>

                    <div class="form-group country">
                        <label class="control-label col-sm-3 " for="country">Country :</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name = 'country' id='address_country' placeholder="Country">
                            <span id="country"></span>
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
@endsection
