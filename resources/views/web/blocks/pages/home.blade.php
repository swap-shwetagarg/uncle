@extends('web.layouts.index')

@section('title', 'Auto Repair by Professional Mechanics | Uncle Fitter')
@section('description', 'Forget the repair shop hassle. Our highly skilled mobile mechanics come to you at your most convenient location and time.')

@section('content')

<div class="container-fluid no-padding">
    @include('web/blocks/pages/navbar')
    @include('web/blocks/partials/home--slider')
</div>
<div class="container-fluid no-padding" id="about-us">
    @include('web/blocks/partials/about--us')
</div>
<div class="container-fluid no-padding" id="our-customers">
    @include('web/blocks/partials/our--customers')
</div>
<div class="container-fluid no-padding" id="services">
    @include('web/blocks/partials/repair--services')
</div>
<div class="container-fluid no-padding" id="service-model">
    @include('web/blocks/partials/service--model')
</div>
<div class="container-fluid no-padding bg--color" id="more">
    @include('web/blocks/partials/how--we--help')
</div>
<div class="container-fluid no-padding">
    @include('web/blocks/partials/footer')
</div>

@endsection