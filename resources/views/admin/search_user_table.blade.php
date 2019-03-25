<thead>
    <tr>
        <th>#</th>
        <th>Username</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Status</th>
        <th>Approved</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    <?php $i = 0; ?>
    @if($result && count($result)>0)
    @foreach($result as $user)
    <?php
    $mean_overAllRating = 0;
    $ratings = $user->getRating;
    if ($ratings->isNotEmpty()) {
        $mean_overAllRating = $ratings->avg('overall_rating');
    }
    $role = 'User';
    ?>
    <tr>
        <td><?php echo ++$i; ?></td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->mobile }}</td>
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

            <button class="btn btn-danger btn-sm delete_user" data-toggle="modal" data-target = "#delete_user_modal" 
                    data-placement="right" title="Delete" data-url ='{{URL("admin/user")}}/{{ $user->id }}'>
                <i class="fa fa-trash-o" aria-hidden="true"></i>
            </button>

            <div class="btn-group s-b-5">
                <button type="button" data-toggle="dropdown" class="btn btn-success btn-sm dropdown-toggle" aria-expanded="false">Change Role 
                    <span class="caret"></span>
                </button>
                <ul role="menu" class="dropdown-menu">
                    <li>
                        <a class="change-role" data-url="{{url('admin/user/role/Admin/'.$user->id)}}" >Admin</a>
                    </li>
                    <li>
                        <a class="change-role" data-url="{{url('admin/user/role/User/'.$user->id)}}" >User</a>
                    </li>
                </ul>
            </div>

            <a class="btn btn-primary btn-sm" href="{{ URL('admin/user/switch/start/'.$user->id) }}">Login as User</a>
        </td>
    </tr>  
    @endforeach
    <tr>
        <td colspan="7" align="center">No Record Exists</td>
    </tr>
    @endif
</tbody>
<script type="text/javascript">
    $(document).find('.status-toggle').bootstrapToggle();
</script>