<div class="table-responsive" id="user-table-container">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>#</th>
                @if (isset($page) && $page == 'mechanic')
                <th>Profile Photo</th>
                @endif
                <th>Username</th>
                <th>Email</th>
                <th>Phone</th>
                @if (isset($page) && $page == 'mechanic')
                <th>Rating</th>
                @endif
                @if (isset($page) && ($page == 'mechanic' || $page == 'user' || ($page == 'admin' && Auth::user()->hasRole('Master'))))
                <th>Status</th>
                <th>Approved</th>
                <th>Action</th>
                @endif
            </tr>
        </thead>
        <tbody>
            <?php $i = 0; ?>
            @if(count($result)>0)
            @foreach($result as $user)
            <?php
            $mean_overAllRating = 0;
            $ratings = $user->getRating;
            if ($ratings->isNotEmpty()) {
                $mean_overAllRating = $ratings->avg('overall_rating');
            }
            if (isset($page) && $page == 'mechanic') {
                $role = 'Mechanic';
            } else {
                $role = 'User';
            }
            ?>
            <tr>
                <td><?php echo ++$i; ?></td>
                @if (isset($page) && $page == 'mechanic')
                <td>
                    @if($user->profile_photo && $user->profile_photo != '')
                    <img class="mechanic-profile-img" src="{{asset($user->profile_photo)}}" width="50" height="50" />
                    @else
                    <img class="mechanic-profile-img" src="{{asset('/images/profile_photo/dummy-mechanic.png')}}" width="50" height="50" />
                    @endif
                </td>
                @endif
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->mobile }}</td>
                
                @if (isset($page) && $page == 'mechanic')
                <td>{{ number_format($mean_overAllRating, 2) }} <i class="fa fa-star mechanic-ratings"></i></td>
                @endif
                
                @if (isset($page) && ($page == 'mechanic' || $page == 'user' || ($page == 'admin' && Auth::user()->hasRole('Master'))))
                <td>                    
                    @if($user->verified == 1)
                    <input type="checkbox" class="status-toggle" checked data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                           data-size="mini" data-type="user" data-id="{{$user->id}}" data-status="{{ $user->verified }}" data-on="Active" data-off="Inactive" value="0">
                    @elseif($user->verified == 0)
                    <input type="checkbox" class="status-toggle" checked data-toggle="toggle" data-onstyle="danger" data-offstyle="success"
                           data-size="mini" data-type="user" data-id="{{$user->id}}" data-status="{{ $user->verified }}" data-on="Inactive" data-off="Active" value="1">
                    @endif
                </td>
                <td>      
                    @if($user->approved)
                    <input type="checkbox" class="status-toggle" checked data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                           data-size="mini" data-type="approved" data-id="{{$user->id}}" data-status="{{ $user->approved }}" data-on="Yes" data-off="No" value="0">
                    @else($user->approved)
                    <input type="checkbox" class="status-toggle" checked data-toggle="toggle" data-onstyle="danger" data-offstyle="success"
                           data-size="mini" data-type="approved" data-id="{{$user->id}}" data-status="{{ $user->approved }}" data-on="No" data-off="Yes" value="1">
                    @endif
                </td>
                <td>
                    <button class="btn btn-info btn-sm update_user"  data-toggle="modal" data-target = "#update_user_modal" 
                            title="Edit" data-url ='{{URL("admin/user")}}/{{ $user->id }}'>
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                    </button>
                    
                    @if (isset($page) && $page == 'mechanic')
                    <a class="btn btn-info btn-sm update_user" 
                            title="View profile" href='{{URL("admin/user/mechanic")}}/{{ $user->id }}'>
                        <i class="fa fa-eye" aria-hidden="true"></i>
                    </a>
                    @endif

                    <button class="btn btn-danger btn-sm delete_user" data-toggle="modal" data-target = "#delete_user_modal" 
                            data-placement="right" title="Delete" data-url ='{{URL("admin/user")}}/{{ $user->id }}'>
                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                    </button>

                    @if (isset($page) && $page != 'mechanic' && Auth::user()->hasRole('Master'))
                    <div class="btn-group s-b-5">
                        <button type="button" data-toggle="dropdown" class="btn btn-success btn-sm dropdown-toggle" aria-expanded="false">Change Role 
                            <span class="caret"></span>
                        </button>
                        <ul role="menu" class="dropdown-menu">
                            @if(isset($page) && ($page == 'user'))
                            <li>
                                <a class="change-role" data-url="{{url('admin/user/role/Admin/'.$user->id)}}" >Admin</a>
                            </li>
                            @elseif(isset($page) && ($page == 'admin'))
                            <li>
                                <a class="change-role" data-url="{{url('admin/user/role/User/'.$user->id)}}" >User</a>
                            </li>
                            @endif
                        </ul>
                    </div>
                    @endif

                    @if(isset($page) && ($page == 'user'))
                    <a class="btn btn-primary btn-sm" href="{{ URL('admin/user/switch/start/'.$user->id) }}">Login as User</a>
                    @endif
                    
                </td>
                @endif
            </tr>  
            @endforeach
            @else
            <tr>
                <td colspan="<?php echo (isset($page) && $page == 'mechanic') ? 9 : 7; ?>" align="center">No Record Exists</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
            @if($result && $result->links())
            <tr>
                <td colspan="<?php echo (isset($page) && $page == 'mechanic') ? 9 : 7; ?>" align="center">
                    <nav class="pagination"> {{ $result->links() }} </nav>
                </td>
            </tr>
            @endif
            <tr class="records">
                <td colspan="<?php echo (isset($page) && $page == 'mechanic') ? 9 : 7; ?>" align="center">Total Records: {{ $result->total() }}</td>
            </tr>
        </tfoot>
    </table>
</div>
