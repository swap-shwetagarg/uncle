<div class="table-responsive" id="car-services-table-container">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Make Name</th>
                <th>Description</th>
                <th>Image</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if(count($carResult)>0)
            <?php 
            $page_number = (isset($page_number) && $page_number) ? (($page_number - 1) * 15) : 0;
            $i = 0 + $page_number;
            ?>
            @foreach($carResult as $carService)
            <tr>
                <td><?php echo ++$i; ?></td>
                <td>{{ $carService->brand }}</td>
                <td>{{ $carService->description }}</td>
                <td>
                    <?php
                    if ($carService->image_url) { 
                        echo "<img src='".asset($carService->image_url) . "' car_image='" . $carService->brand."' width='100'/>";
                    } else {
                        echo "<a href='javascript:void(0);'>Not Uploaded</a>";
                    }
                    ?>
                </td>
                <td>                    
                    @if($carService->status == 1)
                    <input type="checkbox" class="status-toggle" checked data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                           data-size="mini" data-type="car" data-id="{{$carService->id}}" data-status="{{ $carService->status }}" data-on="Active" data-off="Inactive" value="0">
                    @elseif($carService->status == 0)
                    <input type="checkbox" class="status-toggle" checked data-toggle="toggle" data-onstyle="danger" data-offstyle="success"
                           data-size="mini" data-type="car" data-id="{{$carService->id}}" data-status="{{ $carService->status }}" data-on="Inactive" data-off="Active" value="1">
                    @endif
                </td>
                <td>
                    <button class="btn btn-info btn-sm update_car_service"  data-toggle="modal" data-target = "#update_car_service_modal" title="Edit" data-url ='{{URL("admin/car/makes")}}/{{ $carService->id }}'><i class="fa fa-pencil" aria-hidden="true"></i></button>
                    &nbsp;&nbsp;
                    <button class="btn btn-danger btn-sm delete_car_service" data-toggle="modal" data-target = "#delete_car_service_modal" data-placement="right" title="Delete" data-url ='{{URL("admin/car/makes")}}/{{ $carService->id }}'><i class="fa fa-trash-o" aria-hidden="true"></i></button>
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
            @if($carResult && $carResult->links())
            <tr>
                <td colspan="6" align="center">
                    <nav class="pagination"> {{ $carResult->links() }} </nav>
                </td>
            </tr>
            @endif
            <tr class="records">
                <td colspan="6" align="center">Total Records: {{ $carResult->total() }}</td>
            </tr>
        </tfoot>
    </table>
</div>
