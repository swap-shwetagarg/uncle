<div class="table-responsive" id="user-address-container">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Address 1</th>
                <th>Address 2</th>
                <th>Zipcode</th>
                <th>Area</th>
                <th>Country</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>  
            <?php $i=0;?>
            @if(isset($address) && count($address)>0)
                @foreach($address as $userAddress)
                <tr>
                    <td><?php echo ++$i;?></td>
                    <td>{{ $userAddress->add_1 }}</td>
                    <td>{{ $userAddress->add_2 }}</td>
                    <td>{{ $userAddress->zipcode }}</td>
                    <td>{{ $userAddress->area }}</td>
                    <td>{{ $userAddress->country }}</td>
                    <td>
                        <button class="btn btn-info btn-sm update_address"  data-toggle="modal" data-target = "#update_user_address_modal"  title="Edit" data-url = '{{ url('user/address') }}/{{ $userAddress->id }}'><i class="fa fa-pencil" aria-hidden="true"></i></button>
                        <button class="btn btn-danger btn-sm delete_address" data-toggle="modal" data-target = "#delete_user_address_modal" data-placement="right"  data-url = '{{ url('user/address') }}/{{ $userAddress->id }}' title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                    </td>
                </tr> 
                @endforeach
                @else
                <tr>
                    <td colspan="7" align="center">No Record Exists</td>
                </tr>
                @endif 
        </tbody>
    </table>
</div>
