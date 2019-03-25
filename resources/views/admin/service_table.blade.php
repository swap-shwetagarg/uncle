<div class="table-responsive" id="service-table-container">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>#</th>                
                <th>Title</th>
                <th>Category</th>
                <th>Service Type</th>
                <th>Is Popular</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $page_number = (isset($page_number) && $page_number) ? (($page_number - 1) * 15) : 0;
            $i = 0 + $page_number;
            ?>
            @if(count($servicesResult)>0)
            @foreach($servicesResult as $result)
            <tr>
                <td><?php echo ++$i; ?></td>                
                <td>{{ $result->title }}</td>
                <td>{{{ $result->category->category_name or '' }}}</td>
                <td>{{{ $result->category->servicetype->service_type or ''}}}</td>
                <td>
                    @if($result->is_popular == 1)
                    <input type="checkbox" class="is_popular-toggle" checked data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                           data-size="mini" data-id="{{$result->id}}" data-is_popular="{{ $result->is_popular }}" data-on="Yes" data-off="No" value="0">
                    @elseif($result->is_popular == 0)
                    <input type="checkbox" class="is_popular-toggle" checked data-toggle="toggle" data-onstyle="danger" data-offstyle="success"
                           data-size="mini" data-id="{{$result->id}}" data-is_popular="{{ $result->is_popular }}" data-on="No" data-off="Yes" value="1">
                    @endif
                </td>
                <td>                    
                    @if($result->status == 1)
                    <input type="checkbox" class="status-toggle" checked data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                           data-size="mini" data-type="service" data-id="{{$result->id}}" data-status="{{ $result->status }}" data-on="Active" data-off="Inactive" value="0">
                    @elseif($result->status == 0)
                    <input type="checkbox" class="status-toggle" checked data-toggle="toggle" data-onstyle="danger" data-offstyle="success"
                           data-size="mini" data-type="service" data-id="{{$result->id}}" data-status="{{ $result->status }}" data-on="Inactive" data-off="Active" value="1">
                    @endif
                </td>
                <td>
                    <button class="btn btn-info btn-sm update_service"  data-toggle="modal" data-target = "#update_service_modal" url = '{{ url("admin/services") }}/{{ $result->id }}' title="Edit">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                    </button>
                    &nbsp;&nbsp;
                    <button class="btn btn-danger btn-sm delete_service" data-toggle="modal" data-target = "#delete_service_modal" data-placement="right" url = '{{ url("admin/services") }}/{{ $result->id }}' title="Delete">
                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                    </button>
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
            @if($servicesResult && $servicesResult->links())
            <tr>
                <td colspan="7" align="center">
                    <nav class="pagination"> {{ $servicesResult->links() }} </nav>
                </td>
            </tr>
            @endif
            <tr class="records">
                <td colspan="7" align="center">Total Records: {{ $servicesResult->total() }}</td>
            </tr>
        </tfoot>
    </table>
</div>