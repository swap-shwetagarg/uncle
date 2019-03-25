<form class="form-horizontal" id='form_add_user_car_details' method='post' action='{{URL("user/cars-submit-extra-details")}}'>
    <input type="hidden" name="id" value="{{$check_user_car->id}}">
    @foreach($decoded_car_details as $key => $value)
        <div class="form-group car_model_id">
            <label class="control-label col-sm-4" for="Model">{{ucwords(str_replace("_"," ",$key))}} :</label>
            <div class="col-sm-6">
                <input class="form-control" name="{{$key}}" value="{{{$value or ''}}}">
            </div>
        </div>
    @endforeach
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