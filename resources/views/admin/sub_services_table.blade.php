<div class="table-responsive" id="sub-services-table-container">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>#</th>                
                <th>Title (SS ID)</th>
                <th>Service</th>
                <!--<th>Description</th>-->
                <th>Order</th>
                <th>Selection Type</th>
                <th>Optional</th>
                <td>Status</td>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $page_number = (isset($page_number) && $page_number) ? (($page_number - 1) * 15) : 0;
            $i = 0 + $page_number;
            ?>
            @if(count($subServices)>0)
            @foreach($subServices as $result)
            <tr>
                <td><?php echo ++$i; ?></td>                
                <td>
                    {{ $result->title }} ({{ $result->id }})
                    <br/>
                    @if(isset($result->display_text) && $result->display_text)
                    <strong>Display Text: </strong>{{ $result->display_text }}
                    @endif
                </td>              
                <td>
                    {{ $result->service->title }}                    
                </td>
                <!--
                <td>
                    {{ implode(' ', array_slice(explode(' ', $result->description), 0, 10)) }}...
                </td>
                -->
                <td>{{ $result->order }}</td>
                <td>@if($result->selection_type=="M"){{ "Multiple" }}@else{{ "Single" }}@endif</td>
                <td>@if($result->optional== 0){{ "No" }}@else{{ "Yes" }}@endif</td>
                <td>
                    @if($result->status == 1)
                    <input type="checkbox" class="status-toggle" checked data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                           data-size="mini" data-type="subservice" data-id="{{$result->id}}" data-status="{{ $result->status }}" data-on="Active" data-off="Inactive" value="0">
                    @elseif($result->status == 0)
                    <input type="checkbox" class="status-toggle" checked data-toggle="toggle" data-onstyle="danger" data-offstyle="success"
                           data-size="mini" data-type="subservice" data-id="{{$result->id}}" data-status="{{ $result->status }}" data-on="Inactive" data-off="Active" value="1">
                    @endif
                </td>
                <td>
                    <button class="btn btn-info btn-sm update_sub_service"  data-toggle="modal" data-target = "#update_sub_service_modal" url = '{{ url("admin/sub-services") }}/{{ $result->id }}' title="Edit" ><i class="fa fa-pencil" aria-hidden="true"></i></button>
                    &nbsp;&nbsp;
                    <button class="btn btn-danger btn-sm delete_sub_service" data-toggle="modal" data-target = "#delete_sub_service_modal" data-placement="right" url = '{{ url("admin/sub-services") }}/{{ $result->id }}' title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
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
            @if($subServices && $subServices->links())
            <tr>
                <td colspan="8" align="center">
                    <nav class="pagination"> {{ $subServices->links() }} </nav>
                </td>
            </tr>
            @endif
            <tr class="records">
                <td colspan="8" align="center">Total Records: {{ $subServices->total() }}</td>
            </tr>
        </tfoot>
    </table>
</div>
