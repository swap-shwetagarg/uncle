@extends('web.layouts.index')

@section('title', "404 Page Not Found (Web) | Uncle Fitter")

@section('content')
<div class="container-fluid no-padding header--alter">
    @include('web/blocks/partials/new_header')
</div>

<div class="container redircted text-center">
    <h1>404 Page Not Found</h1>
    <h2>
        Sorry, the page you have requested could not been found. Try checking the URL for error, 
        then hit the refresh button on your browser or try something else on our app.
    </h2>
</div>

<div class="container-fluid no-padding">
    @include('web/blocks/partials/footer')
</div>
@endsection