<div class="table-responsive" id="service-type-table-container">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Service Type</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $page_number = (isset($page_number) && $page_number) ? (($page_number - 1) * 15) : 0;
            $i = 0 + $page_number;
            ?>
            @if(count($result)>0)
            @foreach($result as $services)
            <tr>
                <td><?php echo ++$i;?></td>
                <td>{{ $services->service_type }}</td>
                <td>                    
                    @if($services->status == 1)
                    <input type="checkbox" class="status-toggle" checked data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                           data-size="mini" data-type="servicetype" data-id="{{$services->id}}" data-status="{{ $services->status }}" data-on="Active" data-off="Inactive" value="0">
                    @elseif($services->status == 0)
                    <input type="checkbox" class="status-toggle" checked data-toggle="toggle" data-onstyle="danger" data-offstyle="success"
                           data-size="mini" data-type="servicetype" data-id="{{$services->id}}" data-status="{{ $services->status }}" data-on="Inactive" data-off="Active" value="1">
                    @endif
                </td>
                <td>
                    <button class="btn btn-info btn-sm update_service_type"  data-toggle="modal" data-target = "#update_service_type_modal" data-url = '{{ url("admin/service-types") }}/{{ $services->id }}' title="Edit" ><i class="fa fa-pencil" aria-hidden="true"></i></button>
                    &nbsp;&nbsp;
                    <button class="btn btn-danger btn-sm delete_service_type" data-toggle="modal" data-target = "#delete_service_type_modal" data-placement="right" data-url = '{{ url("admin/service-types") }}/{{ $services->id }}' title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="4" align="center">No Record Exists</td>
            </tr>
            @endif                                     
        </tbody>
        <tfoot>
            @if($result && $result->links())
            <tr>
                <td colspan="4" align="center">
                    <nav class="pagination"> {{ $result->links() }} </nav>
                </td>
            </tr>
            @endif
            <tr class="records">
                <td colspan="4" align="center">Total Records: {{ $result->total() }}</td>
            </tr>
        </tfoot>
    </table>
</div>
