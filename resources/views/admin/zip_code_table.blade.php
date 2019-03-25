<div class="table-responsive" id="zip-code-table-container">
    <table class="table table-bordered table-hover" id='zipCodeTable'>
        <thead>
            <tr>
                <th>#</th>
                <th>Location</th>
                <th>Country Code</th>
                <th>Service Availability</th>
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
            @foreach($result as $zipcode)
            <tr>
                <td><?php echo ++$i; ?></td>
                <td>{{ $zipcode->zip_code}}</td>
                <td>{{ $zipcode->country_code}}</td>
                <td>@if($zipcode->service_availability==1){{ "Yes" }}@else{{ "No"}}@endif</td>
                <td>
                    @if($zipcode->status == 1)
                    <input type="checkbox" class="status-toggle" checked data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                           data-size="mini" data-type="zipcode" data-id="{{$zipcode->id}}" data-status="{{ $zipcode->status }}" data-on="Active" data-off="Inactive" value="0">
                    @elseif($zipcode->status == 0)
                    <input type="checkbox" class="status-toggle" checked data-toggle="toggle" data-onstyle="danger" data-offstyle="success"
                           data-size="mini" data-type="zipcode" data-id="{{$zipcode->id}}" data-status="{{ $zipcode->status }}" data-on="Inactive" data-off="Active" value="1">
                    @endif
                </td>
                <td>
                    <button class="btn btn-info btn-sm update_zipcode"  data-toggle="modal" data-target = "#update_zipcode_modal" title="Edit"  data-url ='{{url("admin/locations")}}/{{$zipcode->id}}'><i class="fa fa-pencil" aria-hidden="true"></i></button>
                    &nbsp;&nbsp;
                    <button class="btn btn-danger btn-sm delete_zipcode" data-toggle="modal" data-target = "#delete_zipcode_modal" data-placement="right" title="Delete" data-url ='{{url("admin/locations")}}/{{$zipcode->id}}'><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="6" align="center">No Record Exists</td>
            </tr>
            @endif                                           
        </tbody>
        <tfoot>
            @if($result && $result->links())
            <tr>
                <td colspan="6" align="center">
                    <nav class="pagination"> {{ $result->links() }} </nav>
                </td>
            </tr>
            @endif
            <tr class="records">
                <td colspan="6" align="center">Total Records: {{ $result->total() }}</td>
            </tr>
        </tfoot>
    </table>
</div>