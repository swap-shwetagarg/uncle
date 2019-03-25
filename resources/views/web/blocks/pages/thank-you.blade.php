@extends('web.layouts.index')
@section('title', 'Thank You For Quote Request | Uncle Fitter')
@section('content')
<div class="container-fluid no-padding header--alter">
    @include('web/blocks/partials/new_header')
</div>

<div class="container redircted text-center">
    <h1>Thank you!</h1>
    <h2>
        @if(Session::has('message'))
        <div class="alert alert-{{ Session::get('type') }}">
            {{ Session::get('message') }}
        </div>
        @endif
    </h2>
</div>

<div class="container-fluid no-padding">
    @include('web/blocks/partials/footer')
</div>
@endsection