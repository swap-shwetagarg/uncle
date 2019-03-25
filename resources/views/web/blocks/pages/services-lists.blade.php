@if(isset($data) && $data && count($data))
@foreach($data as $category)
<div class="form-group">
    <div class="row unclefitter-services-heading">
        <div class="col-md-4">
            <h2 class="g-header-text">{{$category->category_name}}</h2>
        </div>
    </div>
    <div class="row unclefitter-service">
        <?php $services = $category->service; ?>                        
        @foreach($services as $service)
        <div class="col-md-4 col-sm-12 col-xs-12">
            <a class="btn" href="{{ URL('services') }}/{{$service->id}}">{{$service->title}}</a>
        </div>
        @endforeach                    
    </div>
</div>
@endforeach
@else
<div class="form-group">
    <div class="row unclefitter-service">
        @if($services && count($services))
        @foreach($services as $service)
        <div class="col-md-4 col-sm-12 col-xs-12">
            <a class="btn" href="{{ URL('services') }}/{{$service->id}}">{{$service->title}}</a>
        </div>
        @endforeach
        @endif
    </div>
</div>
@endif