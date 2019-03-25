@extends('web.layouts.index')

@section('title', 'Terms Of Use | Uncle Fitter')
@section('description', 'Customer terms and conditions')
@section('keywords', '')

@section('content')

<div class="container-fluid no-padding legal-pages-slider">
    @include('web/blocks/partials/page--banner')
</div>
<div class="container"> 
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item active">{{$page->post_title}}</li>
    </ol>
</div>
<div class="container legal-pages">
    <h1>{{$page->post_title}}</h1>
    <div class="well page_content">
        <?php echo $page->post_content; ?>
    </div>
</div>
<div class="container-fluid no-padding bg--color" id="more">
    @include('web/blocks/partials/how--we--help')
</div>
<div class="container-fluid no-padding">
    @include('web/blocks/partials/footer')
</div>

@endsection