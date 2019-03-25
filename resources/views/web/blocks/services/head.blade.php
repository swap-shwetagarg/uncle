<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">
    <meta name="author" content="">   
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel='shortcut icon' type='image/x-icon' href='{{asset('favicon.png')}}' />
    <link href="{{asset('web/css/jquery.steps.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="{{ asset('assets/plugins/toastr/toastr.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('web/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('css/custom.css')}}" rel="stylesheet">
    <!--<link href="{{asset('assets/dist/css/styleBD.css')}}" rel="stylesheet">-->
    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
        ]) !!}
        ;
    </script>
    <!-- Global Site Tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-106844001-1"></script>
    <script>  window.dataLayer = window.dataLayer || [];
    function gtag() {
        dataLayer.push(arguments)
    }
    ;
    gtag('js', new Date());
    gtag('config', 'UA-106844001-1');
    </script>
</head>
