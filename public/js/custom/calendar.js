
$(document).click(function (e) {
    if (isVisible & clickedAway) {
        $('.popover').popover('hide');
        isVisible = clickedAway = false;
    } else {
        clickedAway = true;
    }
});
var clickedAway = false;
var isVisible = false;
$(document).ready(function () {
    var sDateTime = new Date();
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,listMonth' //agendaWeek,agendaDay,
        },
        //editable: true,
        //minDate: sDateTime,
        defaultDate: sDateTime,
        navLinks: false, // can click day/week names to navigate views
        businessHours: true, // display business hours
        //editable: false,
        droppable: false, // this allows things to be dropped onto the calendar
        drop: function () {
            // is the "remove after drop" checkbox checked?
            if ($('#drop-remove').is(':checked')) {
                // if so, remove the element from the "Draggable Events" list
                $(this).remove();
            }
        },
        eventRender: function (event, eventElement) {
            if (event.description == "9")
                eventElement.addClass('event-cancelled');
            $(eventElement).popover({
                title: function () {
                    return event.title;
                },
                placement: 'auto',
                html: true,
                toggle: 'popover',
                trigger: 'click',
                animation: 'false',
                content: function () {
                    clickedAway = false;
                    isVisible = true;
                    return '<div class="modal-font"><b>Start Time:</b> ' + moment(new Date(event.start._i)).format($('#time_format').val()) + '<br/></div>';
                },
                container: 'body'
            }).popover('show');
        },
        eventClick: function (calEvent, jsEvent, view) {
            console.log('eEvent: ' + calEvent.title);
            console.log('eCoordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
            console.log('eView: ' + view.name);
        },
        dayClick: function (date, jsEvent, view) {
            if (validClick(date))
            {
                var currentday_date = validateToday(date);
                if (currentday_date != "0" && currentday_date != "1") {
                    var time = currentday_date.split('|');
                    initiateSlider(currentday_date, parseInt(time[0]), 1140, time[1], '07:00 PM');
                } else if (currentday_date == "0")
                {
                    initiateSlider(currentday_date, 420, 1140, '07:00 AM', '07:00 PM');
                } else
                    return false;
                $('.booking-date').text(date.format($('#time_format').val()));
                $('#schedule-booking-modal').modal('toggle');
                loadAvailableTimes(date.format());
            }
        },
        viewRender: function (currentView) {
            var maxDate = moment(sDateTime).add(14, 'days');//.format($('#time_format').val());
            console.log(maxDate);
            $('.fc-past,.fc-today').each(function () {
                $(this).addClass('fc-other-month');
            })
            $('.fc-future').each(function () {
                if (new Date($(this).data('date')) >= new Date(maxDate))
                {
                    // console.log(new Date($(this).data('date')));
                    $(this).addClass('fc-other-month');
                }
            });
        }
    });
    $('.fc-prev-button,.fc-next-button,.fc-month-button').click(function () {
        loadEvents();
    });
    loadEvents();
    initiateSlider();
});
function loadAvailableTimes(date)
{
    var url = '/user/booking/available-times/';
    var booking_id = $('.booking-id').data('booking_id');
    var selector = $(this);
    $.ajax({
        url: url + date + '/' + booking_id,
        type: "get",
        success: function (result) {
            $(".schedule-availability").html(result);
            $('.time input').each(function () {
                var self = $(this),
                        label = self.next(),
                        label_text = label.text();
                label.remove();
                self.iCheck({
                    checkboxClass: 'icheckbox_line-blue',
                    radioClass: 'iradio_line-blue',
                    insert: '<div class="icheck_line-icon"></div>' + label_text
                });
            });
            $('.time input').each(function () {
                if ($(this).hasClass('disabled')) {
                    $(this).parent('div').addClass('disabled');
                    $(this).remove();
                }
            });
        }
    });
}
function loadEvents()
{
    $('#calendar').fullCalendar('removeEvents');
    var booking_id = $('.booking-id').data('booking_id');
    var dt = $('#calendar').fullCalendar('getDate')._d;
    if (!dt)
        return;
    var tf = $('#time_format').val();
    var start_date = moment(new Date(dt.getFullYear(), dt.getMonth(), 1)).format('YYYY-MM-DD');
    var dt = new Date(start_date)
    var end_date = moment(new Date(dt.getFullYear(), dt.getMonth() + 1, 0)).format('YYYY-MM-DD');
    $.ajax({
        url: '/user/booking/get-scheduled-bookings/' + booking_id + '/' + start_date + '/' + end_date,
        success: function (result) {
            $.each(result.bookings, function (key, value) {
                var myEvent = {
                    start: moment(value.schedule_date).format("YYYY-MM-DD") + 'T' + (moment(value.schedule_start_time, ["h:mm A"]).format("HH:mm:00")),
                    end: moment(value.schedule_date).format("YYYY-MM-DD") + 'T' + (moment(value.schedule_end_time, ["h:mm A"]).format("HH:mm:00")),
                    title: 'Booking Scheduled For Id : ' + value.id,
                    allDay: false,
                    description: value.status
                }
                $("#calendar").fullCalendar('renderEvent', myEvent);
            });
            //callback(events);
        }
    });
}
