@extends('layouts.admin')

@section('title', "Settings | Uncle Fitter")

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
                                <h4>Settings</h4>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <form action="{{ url("admin/save-settings") }}" method="POST">
                                        <div class="col-md-12 form-group">
                                            <label id="vat_tax">VAT (Percentage)</label>
                                            <div class="input-group">
                                                <input type="text" name="vat_tax" id="vat_tax" class="form-control" 
                                                   value="<?php echo (isset($settings) && $settings && sizeof($settings)) ? $settings['vat_tax'] : ''; ?>" />
                                                <span class="input-group-addon" id="basic-addon2">%</span>
                                            </div>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            {{ csrf_field()}}
                                            <button type="submit" name="save-settings" id="save-settings" class="btn btn-primary">Save</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-6">
                                    <form action="{{ url("admin/save-settings") }}" method="POST">
                                        <div class="col-md-12 form-group">
                                            <label id="services_counter">Service Counter</label>
                                            <input type="text" name="services_counter" id="services_counter" class="form-control" 
                                                   readonly value="<?php echo (isset($settings) && $settings && sizeof($settings)) ? $settings['services_counter'] : ''; ?>" />
                                        </div>
                                        <div class="col-md-12 form-group">
                                            {{ csrf_field()}}
                                            <button type="submit" name="save-settings" id="save-settings" class="btn btn-primary">Save</button>
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