@extends('layouts.admin')

@section('title', "Car Years | Uncle Fitter")

@section('content')
<div class="wrapper">
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-bd">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <div class="col-sm-11"><h4>Car Years</h4></div>
                                <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#add_year_modal">Add</button>
                            </div>
                        </div>
                        <div class="panel-body">
                            @include('admin.year_table')
                        </div>
                    </div>
                </div>
            </div>
        </section> <!-- /.content -->
    </div> <!-- /.content-wrapper -->
</div> 

<!-- Modal - Add Year-->
<div id="add_year_modal" class="modal fade" role="dialog" data-toggle="modal">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Car Year</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id='form_add_year' method='post' action='{{URL("admin/car/years")}}'>
                    <div class="form-group car_id">
                        <label class="control-label col-sm-3" for="Car">Car Make:</label>
                        <div class="col-sm-6"> 
                            <select id='add_car_select' name = 'car_id' style='width: 100%'>
                                <option value=''>Select Car Make</option>
                                @if(count($cars)>0)
                                @foreach($cars as $car)
                                <option value='{{ $car->id }}'>{{$car->brand}}</option>
                                @endforeach()
                                @endif
                            </select>
                            <span id='car_id'></span>
                        </div>
                    </div>

                    <div class="form-group year">
                        <label class="control-label col-sm-3" for="year">Year :</label>
                        <div class="col-sm-6">  
                            <select id='add_year_select' name = 'year' style='width: 100%;'>
                                <option value=''>Select Year</option>
                                @for($i =1930; $i<=date('Y'); $i++)
                                <option value='{{ $i }}'>{{ $i }}</option>
                                @endfor
                            </select>
                            <span id='year'></span>
                        </div>
                    </div>

                    {{ csrf_field()}}  
                    <div class="modal-footer">
                        <div class='row'>
                            <div class='col-sm-8 modal_btn'>
                                <button type="submit" class="btn btn-info">Submit</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>    
                            </div>
                            <img src='{{ asset('images/spin.gif')}}' class='spinner'>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal - Update Year -->
<div id="update_year_modal" class="modal fade" role="dialog" data-toggle="modal">

    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Update Car Year</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id='form_update_year' method='post'>
                    <div class="form-group car_id">
                        <label class="control-label col-sm-3" for="Car">Car Make:</label>
                        <div class="col-sm-6">
                            <select id='update_car_select' name = 'car_id' style='width: 100%;'>
                                @if(count($cars)>0)
                                @foreach($cars as $car)
                                <option value='{{ $car->id }}'>{{$car->brand}}</option>
                                @endforeach()
                                @endif
                            </select>
                            <span id='car_id'></span>
                        </div>
                    </div>

                    <div class="form-group year">
                        <label class="control-label col-sm-3" for="year">Year :</label>
                        <div class="col-sm-6">
                            <select id ='update_year_select' name = 'year' style='width: 100%;'>
                                @for($i =2007; $i<=date('Y'); $i++)
                                <option value='{{ $i }}'>{{ $i }}</option>
                                @endfor
                            </select>
                            <span id='year'></span>
                        </div>
                    </div>

                    {{ csrf_field()}}    
                    {{ method_field('PUT') }}
                    <div class="modal-footer">
                        <div class='row'>
                            <div class='col-sm-8 modal_btn'>
                                <button type="submit" class="btn btn-info">Submit</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>    
                            </div>
                            <img src='{{ asset('images/spin.gif')}}' class='spinner'>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal- Delete year  -->
<div class="modal fade" id="delete_year_modal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                <form id='form_delete_year' method='post'> 

                    {{ method_field('DELETE') }}
                    {{ csrf_field()}}

                    <p class='text-center'>Are you sure you want to delete car year ?</p>
                    <div class="modal-footer">
                        <div class='row'>
                            <div class='col-sm-8 modal_btn'>
                                <button type="submit" class="btn btn-info">Yes</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">No</button> 
                            </div>
                            <img src='{{ asset('images/spin.gif')}}' class='spinner'>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection