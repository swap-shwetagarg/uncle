@extends('layouts.admin')

@section('title', 'Refer a Friend | Uncle Fitter')

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
                                <h4>Refer A Friend</h4> 
                            </div>
                        </div>
                        <div class="panel-body center-block">
                            <form id="rate_mechanic" class="form-horizontal" method="POST" action="{{URL("user/submit-rating")}}">                                
                                <div class="star_rating">
                                    <div class="col-md-12 has-error">
                                        <span class="help-block text-error text-center">
                                            <h3><strong class="error-on-schedule"></strong></h3>
                                        </span>
                                    </div>
                                    <h2>Rate your mechanic</h2>
                                    <p>Did your mechanic arrive on time?</p>
                                    <fieldset class="rating">
                                        @for ($i = 10; $i >= 1; $i--)
                                        <input type="radio" id="field1_star{{$i}}" name="rating1" value="{{$i}}" /><label class = "full" for="field1_star{{$i}}"></label>        
                                        @endfor
                                    </fieldset>
                                    <p>Did your mechanic leave your premises clean?</p>
                                    <fieldset class="rating">
                                        @for ($i = 10; $i >= 1; $i--)
                                        <input type="radio" id="field2_star{{$i}}" name="rating2" value="{{$i}}" /><label class = "full" for="field2_star{{$i}}"></label>
                                        @endfor
                                    </fieldset>
                                    <p>How would you rate your mechanic's professionalism?</p>
                                    <fieldset class="rating">
                                        @for ($i = 10; $i >= 1; $i--)
                                        <input type="radio" id="field3_star{{$i}}" name="rating3" value="{{$i}}" /><label class = "full" for="field3_star{{$i}}"></label>
                                        @endfor
                                    </fieldset>
                                    <p>Did your mechanic successfully fix/diagnose the problem?</p>
                                    <fieldset class="rating">
                                        @for ($i = 10; $i >= 1; $i--)
                                        <input type="radio" id="field4_star{{$i}}" name="rating4" value="{{$i}}" /><label class = "full" for="field4_star{{$i}}"></label>
                                        @endfor
                                    </fieldset>
                                    <p>How likely are you to recommend your mechanic?</p>
                                    <fieldset class="rating">
                                        @for ($i = 10; $i >= 1; $i--)
                                        <input type="radio" id="field5_star{{$i}}" name="rating5" value="{{$i}}" /><label class = "full" for="field5_star{{$i}}"></label>
                                        @endfor
                                    </fieldset>
                                    <h4>Overall Rating?</h4>
                                    <fieldset class="rating star">
                                        @for ($i = 5; $i >= 1; $i--)
                                        <input type="radio" id="field6_star{{$i}}" name="rating6" value="{{$i}}" /><label class = "full" for="field6_star{{$i}}"></label>
                                        @endfor
                                    </fieldset>
                                    {{ csrf_field()}}
                                    <div class='row '>
                                        <div class='col-sm-12 modal_btn btn-center'>                                
                                            <button type="button" id='submit-rating' class="btn btn-info">SUBMIT</button>                                
                                        </div>
                                    </div>
                                    <input type="hidden" id='booking_id' name='booking_id' value="{{ $booking_id}}"/>
                                    <input type="hidden" id='mechanic_id' name='mechanic_id' value="{{ $mechanic_id}}"/>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section> <!-- /.content -->
    </div> <!-- /.content-wrapper -->
</div> 

@endsection