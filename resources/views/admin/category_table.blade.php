<div class="table-responsive" id="category-table-container">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>#</th>                
                <th>Category Name</th>
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
            @if(count($categories)>0)
            @foreach($categories as $category)
            <tr>
                <td><?php echo ++$i; ?></td>                
                <td>{{ $category->category_name }}</td>
                <td>{{ $category->servicetype->service_type }}</td>
                <td>                    
                    @if($category->status == 1)
                    <input type="checkbox" class="status-toggle" checked data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                           data-size="mini" data-type="category" data-id="{{$category->id}}" data-status="{{ $category->status }}" data-on="Active" data-off="Inactive" value="0">
                    @elseif($category->status == 0)
                    <input type="checkbox" class="status-toggle" checked data-toggle="toggle" data-onstyle="danger" data-offstyle="success"
                           data-size="mini" data-type="category" data-id="{{$category->id}}" data-status="{{ $category->status }}" data-on="Inactive" data-off="Active" value="1">
                    @endif
                </td>
                <td>
                    <button class="btn btn-info btn-sm update_category"  data-toggle="modal" data-target = "#update_category_modal" url ='{{URL("admin/categories")}}/{{ $category->id }}' title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                    <button class="btn btn-danger btn-sm delete_category" data-toggle="modal" data-target = "#delete_category_modal" data-placement="right" url ='{{URL("admin/categories")}}/{{ $category->id }}' title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
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
            @if($categories && $categories->links())
            <tr>
                <td colspan="5" align="center">
                    <nav class="pagination"> {{ $categories->links() }} </nav>
                </td>
            </tr>
            @endif
            <tr class="records">
                <td colspan="5" align="center">Total Records: {{ $categories->total() }}</td>
            </tr>
        </tfoot>
    </table>
</div>
