<footer class="main-footer">
    <div class="pull-right hidden-xs"> <b>Version</b> 1.0</div>
    <strong>Copyright &copy; 2016-2017 <a href="#">UncleFitter</a>.</strong> All rights reserved. <i class="fa fa-heart color-green"></i>
</footer>
</div>
<!--Google Place Search Api-->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyBdmkkzqcEpQEH-NhthuXWq6Ra9vEbcCFQ"></script>
<script type="text/javascript" src="{{ asset('js/custom/googleplacesearch.js')}}"></script>

<!-- Scripts -->
<script src="{{ asset('assets/plugins/jQuery/jquery-1.12.4.min.js')}}" type="text/javascript"></script>
<!-- jquery-ui --> 
<script src="{{ asset('assets/plugins/jquery-ui-1.12.1/jquery-ui.min.js')}}" type="text/javascript"></script>
<!-- Star rating js -->
<script src="{{ asset('assets/plugins/jquery-ui-1.12.1/jquery.rateyo.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.cookie.js')}}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.validate.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.flexdatalist.min.js')}}" type="text/javascript"></script>
<!-- Custom js file -->
<script src="{{ asset('js/custom/custom.js')}}" type="text/javascript"></script>
<!-- Common js file -->
<script src="{{ asset('js/common.js')}}" type="text/javascript"></script>
<!-- Bootstrap -->
<script src="{{ asset('assets/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
<!-- lobipanel -->
<script src="{{ asset('assets/plugins/lobipanel/lobipanel.min.js')}}" type="text/javascript"></script>
<!-- Pace js -->
<script src="{{ asset('assets/plugins/pace/pace.min.js')}}" type="text/javascript"></script>
<!-- SlimScroll -->
<script src="{{ asset('assets/plugins/slimScroll/jquery.slimscroll.min.js')}}" type="text/javascript"></script>
<!-- FastClick -->
<script src="{{ asset('assets/plugins/fastclick/fastclick.min.js')}}" type="text/javascript"></script>
<!-- AdminBD frame -->
<script src="{{ asset('assets/dist/js/frame.js')}}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/toastr/toastr.min.js')}}" type="text/javascript"></script>
<!-- iCheck js -->
<script src="{{ asset('assets/plugins/icheck/icheck.min.js') }}" type="text/javascript"></script>
<!-- Bootstrap toggle -->
<script src="{{ asset('assets/plugins/bootstrap-toggle/bootstrap-toggle.min.js') }}" type="text/javascript"></script>
<!-- Sparkline js -->
<script src="{{ asset('assets/plugins/sparkline/sparkline.min.js')}}" type="text/javascript"></script>
<!-- Data maps js -->
<script src="{{ asset('assets/plugins/datamaps/d3.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/datamaps/topojson.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/datamaps/datamaps.all.min.js')}}" type="text/javascript"></script>
<!-- Counter js -->
<script src="{{ asset('assets/plugins/counterup/waypoints.js')}}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/counterup/jquery.counterup.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('js/custom/user.js')}}" type="text/javascript"></script>
<!-- Emojionearea -->
<script src="{{ asset('assets/plugins/emojionearea/emojionearea.min.js')}}" type="text/javascript"></script>
<!-- Monthly js -->
<script src="{{ asset('assets/plugins/monthly/monthly.js')}}" type="text/javascript"></script>

<!-- FullCalendar JS-->
<script src="{{ asset('assets/plugins/fullcalendar/lib/moment.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/fullcalendar/fullcalendar.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('js/custom/calendar.js')}}" type="text/javascript"></script>

<!-- End Page Lavel Plugins
=====================================================================-->
<!-- Start Theme label Script
=====================================================================-->

<!-- ckeditor js -->
<script src="{{ asset('assets/plugins/ckeditor/ckeditor.js')}}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/ckeditor/adapters/jquery.js')}}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/ckeditor/config.js')}}" type="text/javascript"></script>

<!-- Bootstrap Multiselect -->
<script src="{{ asset('assets/plugins/multiselect/bootstrap-multiselect.js')}}" type="text/javascript"></script>

<!-- Dashboard js -->
<script src="{{ asset('assets/dist/js/dashboard.js')}}" type="text/javascript"></script>

<!-- Custom js file -->
<script src="{{ asset('js/custom/slider.js')}}" type="text/javascript"></script>
<!-- DateTime Picker -->
<script src="{{ asset('assets/bootstrap/js/bootstrap-datetimepicker.js')}}" type="text/javascript"></script>
<!-- Select2 js -->
<script src="{{ asset('assets/select2/select2.min.js')}}"></script>

<!-- Global variables for route -->
<script type="text/javascript">
var currentUrl = '<?php echo (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>';
</script>
<script src="{{ asset('js/custom/admin.js')}}" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function () {
    "use strict";
    $('textarea.editor').ckeditor();

    // notification
    setTimeout(function () {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            showMethod: 'slideDown',
            timeOut: 4000
        };
    }, 1300);
    //data maps
    if (document.getElementById("map1")) {
        var basic_choropleth = new Datamap({
            element: document.getElementById("map1"),
            projection: 'mercator',
            fills: {
                defaultFill: "#37a000",
                authorHasTraveledTo: "#fa0fa0"
            },
            data: {
                USA: {fillKey: "authorHasTraveledTo"},
                JPN: {fillKey: "authorHasTraveledTo"},
                ITA: {fillKey: "authorHasTraveledTo"},
                CRI: {fillKey: "authorHasTraveledTo"},
                KOR: {fillKey: "authorHasTraveledTo"},
                DEU: {fillKey: "authorHasTraveledTo"}
            }
        });
        var colors = d3.scale.category10();
        window.setInterval(function () {
            basic_choropleth.updateChoropleth({
                USA: colors(Math.random() * 10),
                RUS: colors(Math.random() * 100),
                AUS: {fillKey: 'authorHasTraveledTo'},
                BRA: colors(Math.random() * 50),
                CAN: colors(Math.random() * 50),
                ZAF: colors(Math.random() * 50),
                IND: colors(Math.random() * 50)
            });
        }, 2000);
    }

    //Chat list
    $('.chat_list').slimScroll({
        size: '3px',
        height: '305px'
    });
    // Message
    $('.message_inner').slimScroll({
        size: '3px',
        height: '320px'
    });
});
</script>
<script src="{{asset('assets/plugins/NotificationStyles/js/modernizr.custom.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/plugins/NotificationStyles/js/classie.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/plugins/NotificationStyles/js/notificationFx.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/plugins/NotificationStyles/js/snap.svg-min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/plugins/sweetalert/sweetalert.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/plugins/toastr/toastr.min.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('assets/notification/respond.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/notification/pusher.min.js')}}"></script>
<script type="text/javascript">
var title = $(document).attr("title");
Pusher.logToConsole = false;
var pusher = new Pusher('6c26c37f7618e14418f3', {
    cluster: 'ap2',
    encrypted: true
});
var channel = pusher.subscribe('booking-channel');
"@role('Admin')"
channel.bind('booking-event', function (data)
{
    if (data.title === 'booking')
    {
        var notificationsWrapper = $('.notifications-menu');
        var notificationsToggle = notificationsWrapper.find('a[data-toggle]');
        var notificationsCountElem = notificationsToggle.find('i[data-count]');
        var notoficationSpanElem = notificationsToggle.find('span');
        var notificationsCount = parseInt(notificationsCountElem.data('count'));
        var notifications = notificationsWrapper.find('ul li ul.menu');
        var notificationslistElem = notificationsWrapper.find('ul li.header');
        if (notificationsCount <= 0) {
            //notificationsWrapper.hide();
        }

        var existingNotifications = notifications.html();
        var avatar = Math.floor(Math.random() * (71 - 20 + 1)) + 20;
        var newNotificationHtml = "<li><a href='{{URL('admin/bookings')}}'><i class='ti-announcement color-green'></i> " + data.message + " </a></li>";
        notifications.html(newNotificationHtml + existingNotifications);
        notificationsCount += 1;
        notificationsCountElem.attr('data-count', notificationsCount);
        notoficationSpanElem.text(notificationsCount);
        notificationslistElem.text('You have ' + notificationsCount + ' pending Bookings');
        notificationsWrapper.show();
        $(document).attr("title", '(' + notificationsCount + ') ' + title);
    }
    notifyMe(data.message);
});

channel.bind('confirm-event', function (data)
{
    notifyMe(data.message);                 // show the notification
});

channel.bind('mech_confirmation-event', function (data)
{
    notifyMe(data.message);                 // show the notification
});

channel.bind('complete-event', function (data)
{
    notifyMe(data.message);                 // show the notification
});

channel.bind('mechanic_created-event', function (data)
{
    notifyMe(data.message);                 // show the notification
});
"@endrole"

"@role('User')"
channel.bind("quoted-event-{{(Auth::check()?Auth::id():'')}}", function (data)
{
    notifyMe(data.message);                 // show the notification
});

channel.bind("assign-event-{{(Auth::check()?Auth::id():'')}}", function (data)
{
    notifyMe(data.message);                 // show the notification
});

channel.bind("complete-event-{{(Auth::check()?Auth::id():'')}}", function (data)
{
    notifyMe(data.message);                 // show the notification
});
channel.bind("mechanic-location-{{(Auth::check()?Auth::id():'')}}", function (data)
{
    notifyMe(data.message);                 // show the notification
});
"@endrole"

// request permission on page load
document.addEventListener('DOMContentLoaded', function () {
    if (Notification.permission !== "granted")
        Notification.requestPermission();
});

function notifyMe(message) {
    if (!Notification) {
        console.log('Desktop notifications not available in your browser. Try Chromium.');
        return;
    }

    if (Notification.permission !== "granted")
        Notification.requestPermission();
    else {
        var notification = new Notification('Booking', {
            icon: '{{asset("web/img/uncle-fitter-logo.png")}}',
            body: message,
        });

        notification.onclick = function () {
            window.open("{{URL('/')}}");
        };
    }
}

$(document).ready(function () {
    var error_type = '<?php echo (Session::has('error_type')) ? Session::get('error_type') : 'error'; ?>';
    if ((error_type && error_type === 'success') || error_type && error_type === 'danger') {
        var error_message = "<?php echo (Session::has('error_message')) ? Session::get('error_message') : 'error'; ?>";
        toastr.success(error_message, error_type, {timeOut: 2500, progressBar: true, debug: true});
    }
});
</script>
</body>
</html>
