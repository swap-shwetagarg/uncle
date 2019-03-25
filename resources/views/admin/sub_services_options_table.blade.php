<div class="table-responsive" id="sub-services-opt-table-container">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th class="col-md-1">#</th>                
                <th class="col-md-3">Title</th>
                <th class="col-md-4">Sub-Service (SS ID)</th>
                <th class="col-md-1">Option Type</th>
                <th class="col-md-1">Order</th>
                <th class="col-md-1">Status</th>
                <th class="col-md-1">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $page_number = (isset($page_number) && $page_number) ? (($page_number - 1) * 15) : 0;
            $i = 0 + $page_number;
            ?>
            @if(count($subServicesOpt)>0)
            @foreach($subServicesOpt as $result)
            <tr>
                <td><?php echo ++$i; ?></td>                
                <td>{{ $result->option_name }}</td>
                <td>{{ $result->subservice->title }} ({{ $result->sub_service_id }})</td>
                <td>{{ ($result->option_type == 1) ? 'Text' : 'Image' }}</td>
                <!--<td>{{ $result->option_description }}</td>-->
                <td>{{ $result->option_order }}</td>
                <td>                    
                    @if($result->status == 1)
                    <input type="checkbox" class="status-toggle" checked data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                           data-size="mini" data-type="subserviceoption" data-id="{{$result->id}}" data-status="{{ $result->status }}" data-on="Active" data-off="Inactive" value="0">
                    @elseif($result->status == 0)
                    <input type="checkbox" class="status-toggle" checked data-toggle="toggle" data-onstyle="danger" data-offstyle="success"
                           data-size="mini" data-type="subserviceoption" data-id="{{$result->id}}" data-status="{{ $result->status }}" data-on="Inactive" data-off="Active" value="1">
                    @endif
                </td>
                <td>
                    <button class="btn btn-info btn-sm update_sub_service_opt"  data-toggle="modal" data-target = "#update_sub_service_opt_modal" url = '{{ url("admin/sub-service-options") }}/{{ $result->id }}' title="Edit" ><i class="fa fa-pencil" aria-hidden="true"></i></button>
                    &nbsp;&nbsp;
                    <button class="btn btn-danger btn-sm delete_sub_service_opt" data-toggle="modal" data-target = "#delete_sub_service_opt_modal" data-placement="right" url = '{{ url("admin/sub-service-options") }}/{{ $result->id }}' title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
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
            @if($subServicesOpt && $subServicesOpt->links())
            <tr>
                <td colspan="7" align="center">
                    <nav class="pagination"> {{ $subServicesOpt->links() }} </nav>
                </td>
            </tr>
            @endif
            <tr class="records">
                <td colspan="7" align="center">Total Records: {{ $subServicesOpt->total() }}</td>
            </tr>
        </tfoot>
    </table>
</div>