@extends('web.layouts.index')
@section('title', 'Request A Quote | Uncle Fitter')
@section('description', 'Save some good cash when you book a service with Uncle Fitter. Free online service history, maintenance reminders and more�')
@section('content')

<div class="container-fluid no-padding header--alter">
    @include('web/blocks/partials/new_header')
</div>

<div class="container-fluid tab--tab">
    @include('web/blocks/partials/tab')
</div>

<div class="container-fluid no-padding">
    @include('web/blocks/partials/footer')
</div>

@endsection