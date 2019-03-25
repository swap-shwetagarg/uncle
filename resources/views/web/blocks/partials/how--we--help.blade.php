<div class="container">
    <div class="how-to-help">
        <h1>How can we help?</h1>
        <p>Tell us what the problem is (e.g the car is not starting or I need new shock absorbers). What kind of car you drive and your contact information.</p>
    </div>
    <div class="get-help">
        <img src="{{asset('web/img/help.png')}}" alt="help">
        @if(isset($data->id))
            <a href="{{ URL('request-a-quote?request_book='.$data->id) }}">REQUEST A QUOTE</a>
        @else
            <a href="{{ URL('request-a-quote') }}">REQUEST A QUOTE</a>
        @endif
    </div>
</div>