@if(isset($recommended_services) && $recommended_services && sizeof($recommended_services))
@foreach($recommended_services AS $recommended_service)
<div class="recommended-service recommended-service{{ $recommended_service[0]->id }}">
    <div class="on--off">
        @if(isset($recommended_service[0]->title) && $recommended_service[0]->title)
        <div class="col-md-11 text-left">
            <p>{{ $recommended_service[0]->title }}</p>
        </div>
        @endif

        @if(isset($recommended_service[0]->id) && $recommended_service[0]->id)
        <div class="col-md-1 text-right">
            <a href="javascript: void(0);" class="delete-selected-service" data-id="{{ $recommended_service[0]->id }}">
                <img src="{{ asset('/web/img/dustbin.png') }}" />
            </a>
        </div>
        @endif

        @if(isset($recommended_service[0]->description) && $recommended_service[0]->description)
        <div class="your--service your-selected-service">
            <div class="col-md-12 text-center">
                <a href="javascript:void(0)" class="view-service-description">View Service Description</a>
            </div>
            <div class="col-md-12 hidden view-service-description-div">
                <?php echo html_entity_decode($recommended_service[0]->description); ?>
            </div>
        </div>
        @endif
        @foreach($selected_service as $ser)
            <input type="hidden" name="service_id[]" value="{{ $ser}}" />
        @endforeach
    </div>
</div>
@endforeach
@endif