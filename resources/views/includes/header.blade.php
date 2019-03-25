<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title')</title>
        <meta name="description" content="@yield('description')">
        <meta name="keywords" content="@yield('keywords')">
        <link rel='shortcut icon' type='image/x-icon' href='{{asset('favicon.png')}}' />
        <link rel="stylesheet" type="text/css" href="{{asset('/css/bootstrap-notifications.min.css')}}">
        <link href="{{asset('assets/plugins/NotificationStyles/css/demo.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{asset('assets/plugins/NotificationStyles/css/ns-default.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{asset('assets/plugins/NotificationStyles/css/ns-style-growl.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{asset('assets/plugins/NotificationStyles/css/ns-style-attached.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{asset('assets/plugins/NotificationStyles/css/ns-style-bar.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{asset('assets/plugins/NotificationStyles/css/ns-style-other.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{asset('assets/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{asset('assets/plugins/toastr/toastr.css')}}" rel="stylesheet" type="text/css"/>

        <!-- Styles -->
        <link href="{{ asset('assets/plugins/jquery-ui-1.12.1/jquery-ui.min.css')}}" rel="stylesheet" type="text/css"/>
        <!-- Bootstrap -->
        <link href="{{ asset('assets/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/bootstrap/css/bootstrap-datetimepicket.css')}}" rel="stylesheet" type="text/css"/>
        <!-- Star rating css -->
        <link href="{{ asset('assets/plugins/jquery-ui-1.12.1/jquery.rateyo.min.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/plugins/lobipanel/lobipanel.min.css')}}" rel="stylesheet" type="text/css"/>
        <!-- Pace css -->
        <link href="{{ asset('assets/plugins/pace/flash.css')}}" rel="stylesheet" type="text/css"/>
        <!-- Font Awesome -->
        <link href="{{ asset('assets/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css"/>
        <!-- Pe-icon -->
        <link href="{{ asset('assets/pe-icon-7-stroke/css/pe-icon-7-stroke.css')}}" rel="stylesheet" type="text/css"/>
        <!-- Themify icons -->
        <link href="{{ asset('assets/themify-icons/themify-icons.css')}}" rel="stylesheet" type="text/css"/>
        <!-- Toastr css -->
        <link href="{{ asset('assets/plugins/toastr/toastr.css')}}" rel="stylesheet" type="text/css"/>
        <!-- Emojionearea -->
        <link href="{{ asset('assets/plugins/emojionearea/emojionearea.min.css')}}" rel="stylesheet" type="text/css"/>        
        <!-- Bootstrap Multiselect -->
        <link href="{{ asset('assets/plugins/multiselect/bootstrap-multiselect.css')}}" rel="stylesheet" type="text/css"/>        
        <!-- Monthly css -->
        <link href="{{ asset('assets/plugins/monthly/monthly.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet" type="text/css"/>
        <!-- iCheck -->
        <link href="{{ asset('assets/plugins/icheck/skins/all.css')}}" rel="stylesheet" type="text/css"/>
        <!-- Bootstrap toggle css -->
        <link href="{{ asset('assets/plugins/bootstrap-toggle/bootstrap-toggle.min.css')}}" rel="stylesheet" type="text/css"/>
        <!--Full Calendar CSS -->
        <link href="{{ asset('assets/plugins/fullcalendar/fullcalendar.min.css')}}" rel="stylesheet" type="text/css"/>
        <!-- Theme style -->
        <link href="{{ asset('assets/dist/css/styleBD.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
        <!-- Custom CSS -->
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet" type="text/css" />
        <!-- FlexDataList CSS -->
        <link href="{{ asset('css/jquery.flexdatalist.min.css') }}" rel="stylesheet" type="text/css" />
        
        <link href='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css' rel="stylesheet" type="text/css" />        
        <!-- Start Theme Layout Style
        <!-- Scripts -->
        <script type="text/javascript">
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
