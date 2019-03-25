
@extends('web.layouts.index')

@section('pageTitle', 'Uncle Fitter')

@section('content')

<div class="container legal-pages">    
    <!--<h1>{{$page->post_title}}</h1>-->
    <div class="well page_content web-view-content">
        <?php
        //echo html_entity_decode(nl2br(e($page->post_content)));
        echo $page->post_content;
        ?>
    </div>
</div>

@endsection