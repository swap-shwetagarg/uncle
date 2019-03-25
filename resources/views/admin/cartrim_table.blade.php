<div class="table-responsive" id="cartrim-table-container">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Car Make</th>
                <th>Car Year</th>
                <th>Car Model</th>
                <th>Trim Name</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $page_number = (isset($page_number) && $page_number) ? (($page_number - 1) * 15) : 0;
            $i = 0 + $page_number;
            ?>
            @if(count($cartrimResult)>0)
            @foreach($cartrimResult as $result)
            <tr>
                <td><?php echo ++$i; ?></td>
                <td>{{ $result->carmodel->years->cars->brand }}</td>
                <td>{{ $result->carmodel->years->year }}</td>
                <td>{{ $result->carmodel->modal_name }}</td>
                <td>{{ $result->car_trim_name }}</td>
                <td>                    
                    @if($result->status == 1)
                    <input type="checkbox" class="status-toggle" checked data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                           data-size="mini" data-type="cartrim" data-id="{{$result->id}}" data-status="{{ $result->status }}" data-on="Active" data-off="Inactive" value="0">
                    @elseif($result->status == 0)
                    <input type="checkbox" class="status-toggle" checked data-toggle="toggle" data-onstyle="danger" data-offstyle="success"
                           data-size="mini" data-type="cartrim" data-id="{{$result->id}}" data-status="{{ $result->status }}" data-on="Inactive" data-off="Active" value="1">
                    @endif
                </td>
                <td>
                    <button class="btn btn-info btn-sm update_cartrim"  data-toggle="modal" data-target = "#update_cartrim_modal" data-url = '{{ url("admin/car/trims") }}/{{ $result->id }}' title="Edit" ><i class="fa fa-pencil" aria-hidden="true"></i></button>
                    &nbsp;&nbsp;
                    <button class="btn btn-danger btn-sm delete_cartrim" data-toggle="modal" data-target = "#delete_cartrim_modal" data-placement="right" data-url = '{{ url("admin/car/trims") }}/{{ $result->id }}' title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="7" align="center">No Record Exists</td>
            </tr>
            @endif                                     
        </tbody>
        <tfoot>
            @if($cartrimResult && $cartrimResult->links())
            <tr>
                <td colspan="7" align="center">
                    <nav class="pagination"> {{ $cartrimResult->links() }} </nav>
                </td>
            </tr>
            @endif
            <tr class="records">
                <td colspan="7" align="center">Total Records: {{ $cartrimResult->total() }}</td>
            </tr>
        </tfoot>
    </table>
</div>
