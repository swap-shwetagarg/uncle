@extends('layouts.admin')

@section('title', "Referral Settings | Uncle Fitter")

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
                                <h4>Referral Settings</h4>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <form action="{{ url("admin/save-referral-settings") }}" method="POST">
                                        <div class="col-md-12 form-group">
                                            <label id="referral_amount">Referral Amount</label>
                                            <input type="text" name="referral_amount" id="referral_amount" class="form-control" 
                                                   value="<?php echo (isset($referral_settings) && $referral_settings) ? $referral_settings['referral_amount'] : ''; ?>" />
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label id="referral_link_text">Referral Text (For APP)</label>
                                            <input type="text" name="referral_link_text" id="referral_link_text" class="form-control"
                                                   value="<?php echo (isset($referral_settings) && $referral_settings) ? $referral_settings['referral_link_text'] : ''; ?>" />
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label id="referral_heading">Referral Heading (For APP)</label>
                                            <input type="text" name="referral_heading" id="referral_heading" class="form-control"
                                                   value="<?php echo (isset($referral_settings) && $referral_settings) ? $referral_settings['referral_heading'] : ''; ?>" />
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label id="referral_content">Referral Content (For APP)</label>
                                            <input type="text" name="referral_content" id="referral_content" class="form-control"
                                                   value="<?php echo (isset($referral_settings) && $referral_settings) ? $referral_settings['referral_content'] : ''; ?>" />
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label id="referral_share_text">Referral Share Content (For APP)</label>
                                            <textarea name="referral_share_text" id="referral_share_text" class="form-control" 
                                                      rows="10"><?php echo (isset($referral_settings) && $referral_settings) ? $referral_settings['referral_share_text'] : ''; ?></textarea>
                                            <small>{REFERRAL_SHARE_LINK}: This will be unique for each user.</small>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            {{ csrf_field()}}
                                            <button type="submit" name="save-settings" id="save-settings" class="btn btn-primary">Save Settings</button>
                                        </div>
                                    </form>
                                </div>    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div> 
@endsection