<div class="col-md-12 has-error">
    <span class="help-block text-error">
        <h3><strong class="error-on-schedule"></strong></h3>
    </span>
</div>
<div class="col-md-12">
    <div class="i-check col-md-2 time {{$available_times[0]->A == 0 ? 'disabled' :''}}">
        <input tabindex="19" type="radio" id="radio-seven" class="rdo-7 {{$available_times[0]->A == 0 ? 'disabled' :''}}" name="line-radio-time" data-time="07:00 AM" group="" >
        <label for="line-radio-time">07:00 AM</label> 
    </div>
    <div class="i-check col-md-2 time {{$available_times[0]->B == 0 ? 'disabled' :''}}">
        <input tabindex="19" type="radio" id="radio-seven" class="rdo-9 {{$available_times[0]->B == 0 ? 'disabled' :''}}" name="line-radio-time" data-time="09:00 AM" group="">
        <label for="line-radio-time">09:00 AM</label> 
    </div>
    <div class="i-check col-md-2 time {{$available_times[0]->C == 0 ? 'disabled' :''}}">
        <input tabindex="19" type="radio" id="radio-seven" class="rdo-11 {{$available_times[0]->C == 0 ? 'disabled' :''}}" name="line-radio-time" data-time="11:00 AM" group="">
        <label for="line-radio-time">11:00 AM</label> 
    </div>
    <div class="i-check col-md-2 time {{$available_times[0]->D == 0 ? 'disabled' :''}}">
        <input tabindex="19" type="radio" id="radio-seven" class="rdo-13 {{$available_times[0]->D == 0 ? 'disabled' :''}}" name="line-radio-time" data-time="01:00 PM" group="">
        <label for="line-radio-time">01:00 PM</label> 
    </div>
    <div class="i-check col-md-2 time {{$available_times[0]->E == 0 ? 'disabled' :''}}">
        <input tabindex="19" type="radio" id="radio-seven" class="rdo-15 {{$available_times[0]->E == 0 ? 'disabled' :''}}" name="line-radio-time" data-time="03:00 PM" group="">
        <label for="line-radio-time">03:00 PM</label> 
    </div>
    <div class="i-check col-md-2 time {{$available_times[0]->F == 0 ? 'disabled' :''}}">
        <input tabindex="19" type="radio" id="radio-seven" class="rdo-17 {{$available_times[0]->F == 0 ? 'disabled' :''}}" name="line-radio-time" data-time="05:00 PM" group="">
        <label for="line-radio-time">05:00 PM</label> 
    </div>
</div>
<br/>
<div class="col-sm-12" >  
    <script>
        var address = '{{ $address}}';
        var latlong = address.split(',');
        var loc = "{!!$location!!}";
        console.log('address', address);
        console.log('latlong', latlong);
        console.log('loc', loc);
        initialize(loc, latlong[0], latlong[1]);
    </script>
    <div class="form-group add_1">
        <div class="col-sm-12">
            <input id="searchInput" class="form-control input-controls" type="text" placeholder="Enter a location">
            <div class="map" id="map" style="width: 100%; height: 200px;"></div>
            <input type="hidden" name="lat" id="latlong">
        </div>
    </div>
</div>
