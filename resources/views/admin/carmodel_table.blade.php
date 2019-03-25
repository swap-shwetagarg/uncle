<div class="table-responsive" id="carmodel-table-container">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Car Make</th>
                <th>Car Year</th>
                <th>Model Name</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody> 
            <?php 
            $page_number = (isset($page_number) && $page_number) ? (($page_number - 1) * 15) : 0;
            $i = 0 + $page_number;
            ?>
            @if(count($carModel)>0)
            @foreach($carModel as $carmodel)
            <tr>
                <td><?php echo ++$i; ?></td>
                <td>{{ $carmodel->years->cars->brand }}</td>
                <td>{{ $carmodel->years->year }}</td>
                <td>{{ $carmodel->modal_name }}</td>
                <td>                    
                    @if($carmodel->status == 1)
                    <input type="checkbox" class="status-toggle" checked data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                           data-size="mini" data-type="carmodel" data-id="{{$carmodel->id}}" data-status="{{ $carmodel->status }}" data-on="Active" data-off="Inactive" value="0">
                    @elseif($carmodel->status == 0)
                    <input type="checkbox" class="status-toggle" checked data-toggle="toggle" data-onstyle="danger" data-offstyle="success"
                           data-size="mini" data-type="carmodel" data-id="{{$carmodel->id}}" data-status="{{ $carmodel->status }}" data-on="Inactive" data-off="Active" value="1">
                    @endif
                </td>
                <td>
                    <button class="btn btn-info btn-sm update_carmodel"  data-toggle="modal" data-target = "#update_carmodal" data-url ='{{URL("admin/car/models")}}/{{ $carmodel->id }}' title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                    &nbsp;&nbsp;
                    <button class="btn btn-danger btn-sm delete_carmodel" data-toggle="modal" data-target = "#delete_carmodal" data-placement="right" data-url ='{{URL("admin/car/models")}}/{{ $carmodel->id }}' title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
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
            @if($carModel && $carModel->links())
            <tr>
                <td colspan="6" align="center">
                    <nav class="pagination"> {{ $carModel->links() }} </nav>
                </td>
            </tr>
            @endif
            <tr class="records">
                <td colspan="6" align="center">Total Records: {{ $carModel->total() }}</td>
            </tr>
        </tfoot>
    </table>
</div>
