<div id='user-car-container'>
    @if(isset($usercars) && $usercars && count($usercars)>0)
    @foreach($usercars as $cartrim)
    <div class="car_details">
        <div class="row">
            <div class="col-md-3 col-sm-3 col-xs-12 img_car">
                <img width="100" src ='{{ ($cartrim->usercars->carmodel->years->cars->image_url) ? asset($cartrim->usercars->carmodel->years->cars->image_url) : asset('web/img/No_image.png') }}'>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12 car_details_style">
                <p>{{ $cartrim->usercars->carmodel->years->year }}</p>
                <h3>{{ $cartrim->usercars->carmodel->years->cars->brand }}</h3>
                <h5>{{ $cartrim->usercars->carmodel->modal_name }}</h5>
                <p>{{ $cartrim->usercars->car_trim_name }}</p>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12 vertical-center">
                <a target="_blank" class="get-a-quote-link" href="{{ URL('/book-service') }}/{{ $cartrim->car_trim_id }}">BOOK A SERVICE</a>
            </div>
            <div class="col-md-1 col-sm-1 col-xs-12">
                <a href='#' data-toggle="modal" data-target="#user_car_services_modal" data-url = '{{ url("user/cars/booking") }}/{{ $cartrim->car_trim_id }}' 
                   class='view_usercar_service' title="View Service History">
                    <img src="{{asset('web/img/car-service.png')}}" class="car_service">
                </a>
                
                <a href='#' data-toggle="modal" data-target="#user_car_health_modal" data-url = '{{ url("user/cars/car-health") }}/{{ $cartrim->id }}' 
                   class='view_usercar_health' title="View Car Health">
                    <img src="{{asset('web/img/car-health.png')}}" class="car_service">
                </a>
                
                <a href='#' data-toggle="modal" data-target="#user_car_extra_details" data-url = '{{ url("user/cars/car-details") }}/{{ $cartrim->id }}' 
                   class='user_car_extra_details' title="View Car Details">
                    <img src="{{asset('web/img/car-health.png')}}" class="car_service">
                </a>
            </div>
            <div class="col-md-1 col-sm-1 col-xs-12 pull-right text-right">
                <a href='#' data-toggle="modal" class='delete_user_car' data-target="#delete_user_car_modal" title="Delete Car"
                   url='{{url("user/cars")}}/{{ $cartrim->id }}'>
                    <i class="fa fa-times"></i>
                </a>
            </div>
        </div>
    </div>
    @endforeach
    @endif
</div>