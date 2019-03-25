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
                        <div class="panel-body">
                            <div class="form-group name">
                                <h5 class="control-label col-sm-2" for="name">
                                    <strong>Your Referral Link :</strong>
                                </h5>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="copy-to-clipboard" value="{{$referral_link}}" readonly>
                                </div>
                                <button class="btn btn-primary  copy-to-clipboard">Copy</button>
                                <button class='btn btn-info' data-toggle="modal" data-target = "#send_referral_modal">Send referral email to friend's</button>

                                <div class="referral-social">
                                    <a target="_blank" href="http://www.facebook.com/sharer.php?u={{ $referral_link }}" title="Click to share">
                                        <i class="fa fa-facebook" aria-hidden="true"></i>
                                    </a>
                                    <!--
                                    <a target="_blank" href="https://www.linkedin.com/shareArticle?url={{ $referral_link }}title=Uncle Fitter Referral" title="Click to share">
                                        <i class="fa fa-linkedin" aria-hidden="true"></i>
                                    </a>
                                    -->
                                    <a target="_blank" href="https://twitter.com/home?status={{ $referral_link }}title=Uncle Fitter Referral" title="Click to share">
                                        <i class="fa fa-twitter" aria-hidden="true"></i>
                                    </a>
                                    <!--
                                    <a target="_blank" href="https://www.instagram.com/shareArticle?url={{ $referral_link }}title=Uncle Fitter Referral" title="Click to share">
                                        <i class="fa fa-instagram" aria-hidden="true"></i>
                                    </a>
                                    -->
                                </div>
                            </div>
                            @include('web.user.refer.refer_a_friend_table')
                        </div>
                    </div>
                </div>
            </div>
        </section> <!-- /.content -->
    </div> <!-- /.content-wrapper -->
</div> 

<div id="send_referral_modal" class="modal fade" role="dialog" data-toggle="modal">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Send Referral Email</h4>
            </div>
            <div class="modal-body">
                <form id="send_referral_form" class="form-horizontal" method='post' data-url='{{url("user/send-referral-email")}}'>
                    <div class="form-group add_1">
                        <div class="col-sm-12">
                            <textarea class="form-control row col-sm-offset-0" rows="6" name='referral_email' id="data-emails" placeholder="Add friend's email addresses"></textarea>
                            <span id="referral_email"></span>
                        </div>
                    </div>
                    {{ csrf_field()}}
                    <div class="modal-footer">
                        <div class='row'>
                            <div class='col-sm-8 modal_btn'>                                
                                <button type="submit" class="btn btn-info">Send</button>                                
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target = "#preview_referral_modal" >Preview</button>
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
<div id="preview_referral_modal" class="modal fade" role="dialog" data-toggle="modal">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Preview Referral Email</h4>
            </div>
            <div class="modal-body">
                <div>
                    Your friend <strong class="capitalize"> {{$user_name}}</strong> thought you should try us for your next car service, repair or diagnostics so we are rewarding you with &#x20B5; 30.<br/><br/>
                    To redeem, book one of our services online and one of our mobile mechanics will come to your home or office to service your vehicle, 7 days a week.<br/><br/>
                    Click {{$referral_link}} today to sign up and get &#x20B5; 30 off.<br/><br/>
                    You can learn more about Uncle Fitter at: <a href="https://www.unclefitter.com">https://www.unclefitter.com</a>
                </div>
                <div class="modal-footer">
                    <div class='row'>
                        <div class='col-sm-7 modal_btn'>                             
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                        </div>
                        <img src='{{ asset('images/spin.gif')}}' class='spinner'>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
