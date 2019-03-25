<div class="table-responsive" id="year-table-container">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Car Make</th>
                <th>Year</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $page_number = (isset($page_number) && $page_number) ? (($page_number - 1) * 15) : 0;
            $i = 0 + $page_number;
            ?>
            @if(count($years)>0)
            @foreach($years as $year)
            <tr>
                <td><?php echo ++$i; ?></td>
                <td>{{ $year->Cars->brand }}</td>
                <td>{{ $year->year }}</td>
                <td>
                    @if($year->status == 1)
                    <input type="checkbox" class="status-toggle" checked data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                           data-size="mini" data-type="year" data-id="{{$year->id}}" data-status="{{ $year->status }}" data-on="Active" data-off="Inactive" value="0">
                    @elseif($year->status == 0)
                    <input type="checkbox" class="status-toggle" checked data-toggle="toggle" data-onstyle="danger" data-offstyle="success"
                           data-size="mini" data-type="year" data-id="{{$year->id}}" data-status="{{ $year->status }}" data-on="Inactive" data-off="Active" value="1">
                    @endif
                </td>
                <td>
                    <button class="btn btn-info btn-sm update_year"  data-toggle="modal" data-target = "#update_year_modal" data-url ='{{URL("admin/car/years")}}/{{ $year->id }}' title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                    <button class="btn btn-danger btn-sm delete_year" data-toggle="modal" data-target = "#delete_year_modal" data-placement="right" data-url ='{{URL("admin/car/years")}}/{{ $year->id }}' title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                </td>
            </tr> 
            @endforeach
            @else
            <tr>
                <td colspan="5" align="center">No Record Exists</td>
            </tr>
            @endif 
        </tbody>
        <tfoot>
            @if($years && $years->links())
            <tr>
                <td colspan="5" align="center">
                    <nav class="pagination"> {{ $years->links() }} </nav>
                </td>
            </tr>
            @endif
            <tr class="records">
                <td colspan="5" align="center">Total Records: {{ $years->total() }}</td>
            </tr>
        </tfoot>
    </table>
</div>
