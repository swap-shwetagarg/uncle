<!doctype html>
<html lang="en-US">
    @include('web.blocks.services.head')
    <body>

        <div class="promotor-block">
            <a href="/en/close-promotor" class="close-promotor-link gtm-promoter-close">
                <div class="close-promotor gtm-promoter-close">✕</div>
            </a>
            <a href="http://goo.gl/8SJeuL" class="navigate-to-app gtm-promoter-download">
                <div class="brand-info gtm-promoter-download">
                    <div class="brand-image gtm-promoter-download">
                        <img class="image" width="52" height="auto" srcset="{{asset('web/img/playstore-icon.png')}}">
                    </div>
                    <div class="app-descr gtm-promoter-download">
                        <span class="brand-text gtm-promoter-download">UncleFitter</span>
                        <br><span class="brand-download-info gtm-promoter-download">Free - on Google Play</span>
                        <div class="action-button h6 gtm-promoter-download">FREE</div>
                    </div>
                </div>
            </a>
        </div>

        @role('User')
        @if(Auth::check() && isset(Auth::user()->mobile) && isset(Auth::user()->email) && !Auth::user()->verified)
        <div class="header-banner mod-warning">
            <p class="u-bottom">
                <strong>Please confirm your email address: {{Auth::user()->email}}.</strong> 
                <a href="http://gmail.com" class="header-banner-link-left quiet" target="_blank" rel="noreferrer" style="
                   ">Check your inbox</a>
                <a class="header-banner-link-left quiet js-resend-confirmation-email" href="{{URL('send-verification-link')}}">Resend email.</a>
            </p>
        </div>
        @endif
        @if(Auth::check())
        @if(!isset(Auth::user()->email) || !isset(Auth::user()->mobile))
        <div class="header-banner mod-warning">
            <p class="u-bottom"><strong>Please update your profile for Quotation</strong> 
                <a href="{{URL('user/profile')}}" class="header-banner-link-left quiet" rel="noreferrer" style="
                   ">Go to profile</a>
            </p>
        </div>
        @endif
        @endif
        @endrole
        <div class="site">
            @yield('content')            
        </div>
        @include('web.blocks.services.script')
        @if(Session::has('alert_msg'))
        <script type="text/javascript">
            toastr.success("{{ Session::get('alert_msg') }}", 'Success', {timeOut: 1500});
        </script>
        @endif	
    </body>
</html>
