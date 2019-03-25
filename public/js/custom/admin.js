$(function () {
    $(document).on('change', '.status-toggle', function () {
        var value = $(this).val();
        var type = $(this).data('type');
        var id = $(this).data('id');
        $.ajax({
            url: '/admin/change-status/' + id + '/' + value + '/' + type,
            type: 'GET',
            success: function (result) {
                if (result.message == 'success')
                {
                    if (value == 0)
                        $(this).val('1');
                    else
                        $(this).val('0');
                    ajaxSuccessMessage(result);
                } else
                    ajaxSuccessMessage(result);
            },
            error: function (event) {
            }
        });
    });
    
    $(document).on('change', '.is_popular-toggle', function () {
        var value = $(this).val();
        var id = $(this).data('id');
        $.ajax({
            url: '/admin/change-is-popular/' + id + '/' + value,
            type: 'GET',
            success: function (result) {
                if (result.message == 'success')
                {
                    if (value == 0)
                        $(this).val('1');
                    else
                        $(this).val('0');
                    ajaxSuccessMessage(result);
                } else
                    ajaxSuccessMessage(result);
            },
            error: function (event) {
            }
        });
    });
});
var isTimeset = false;
$('#modal-md').on('shown.bs.modal', function (e) {
    var date_from = $('#mec_booked_from').val();
    $('#time-range').find('option:first').prop('selected', 'selected');
    $('#time-range option').each(function () {
        if (this.value == date_from) {
            $('#time-range').val(date_from);
            return false;
        }
    });
//    var date_from = $('.slider-time').text();
//    var date_to = $('.slider-time2').text();
//    if (date_from != '07:00 AM' || date_to != '07:00 PM')
//        isTimeset = true;
    setTimeout(function () {
        var d = $('.datetimepicker').val();
        var tf = $('#time_format').val();
        $dp = $('.datetimepicker').datetimepicker({
            format: tf,
            minDate: moment().subtract(1, 'd'),
            maxDate: moment().add('days', 14),
        });
        if (d)
            $('.datetimepicker').val(d);
//        var start_time = $('.slider-time').text();
//        var end_time = $('.slider-time2').text();
//        var sTime = moment(start_time, ["h:mm A"]).format("HH:mm");
//        var time = sTime.split(':');
//        var min = ((parseInt(time[0]) * 60) + parseInt(time[1]));
//        var eTime = moment(end_time, ["h:mm A"]).format("HH:mm");
//        time = eTime.split(':');
//        var max = ((parseInt(time[0]) * 60) + parseInt(time[1]));
//        initiateSlider(sTime, min, max, start_time, end_time);
//        var date_from = $('#mec_booked_from').val();
//        var date_to = $('#mec_booked_to').val();
//        if (date_from && date_to)
//        {
//            setVal1 = (((new Date(date_from).getHours()) * 60) + (new Date(date_from).getMinutes()));
//            setVal2 = (((new Date(date_to).getHours()) * 60) + (new Date(date_to).getMinutes()));
//            $("#slider-range").slider('values', 0, setVal1);
//            $("#slider-range").slider('values', 1, setVal2);
//            $('.slider-time').html(ConvertToAMPM(new Date(date_from)));
//            $('.slider-time2').html(ConvertToAMPM(new Date(date_to)));
//        }
    }, 1200);
});
$(document).on('click', '.re-set-time', function (e) {
    e.preventDefault();
    $('.datetimepicker').val(moment().format($('#time_format').val()));
    $('#time-range').find('option:first').prop('selected', 'selected');
    loadAvailableTimesByMechanic();
});
$(document).on('click', "a.load-mechanic-list", function (e) {
    e.preventDefault();
    var url = $(this).data("url");
    $.ajax({
        url: url,
        data: {},
        type: "get",
        success: function (result) {
            $(".mechanic-list").html(result);
            loadAvailableTimesByMechanic();
        },
    });
});
$(document).on('change', '#mechanic_id', function (e) {
    loadAvailableTimesByMechanic();
});

function loadAvailableTimesByMechanic()
{
    var mechanic_id = $('#mechanic_id').val() == '' ? 0 : $('#mechanic_id').val();
    var parts = $('.datetimepicker').val().split("/");
    var date = moment(new Date(Number(parts[2]), Number(parts[1]) - 1, Number(parts[0]))).format('YYYY-MM-DD');
    var url = 'bookings/available-times/' + mechanic_id + '/' + date;
    var selector = $(this);
    $.ajax({
        url: url,
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
            var isAlldisable = true;
            $('button[type=submit]').removeAttr('disabled');
            $('.time input').each(function () {
                if ($(this).hasClass('disabled')) {
                    $(this).parent('div').addClass('disabled');
                    $(this).remove();
                } else
                    isAlldisable = false;
            });
            if (isAlldisable)
                $('button[type=submit]').attr('disabled', true);
        }
    });
}
function resetDate(date)
{
    var currentday_date = validateToday(date);
    if (currentday_date != "0" && currentday_date != "1") {
        var time = currentday_date.split('|');
        if (!isTimeset)
            initiateSlider(currentday_date, parseInt(time[0]), 1140, time[1], '07:00 PM');
        isTimeset = false;
    } else if (currentday_date == "0")
    {
        if (!isTimeset)
            initiateSlider(currentday_date, 420, 1140, '07:00 AM', '07:00 PM');
        isTimeset = false;
    } else
    {
        initiateSlider(currentday_date, 420, 1140, '07:00 AM', '07:00 PM');
        $('.datetimepicker').val(moment().add('days', 1).format("YYYY-MM-DD"));
    }
}
$("body").on("change dp.change", "input.datetimepicker", function (event) {
    var date = $("input.datetimepicker").val();
    loadAvailableTimesByMechanic();
    //resetDate(moment(new Date(date)));
});

$(document).on("submit", '#form_add_assignmechanic', function (evt) {
    evt.preventDefault();
    var sc_time = '';
    $('.time input').each(function () {
        if ($(this).is(':checked')) {
            sc_time = $(this).data('time');
        }
    });
    var url = $(this).attr('action');
    var mechanic_id = $('#mechanic_id').val();
    var booking_id = $('#booking_id').val();
    var schedule_date = $('.datetimepicker').val();
    var from_time = sc_time;
    var to_time = sc_time;
    if (sc_time != '') {
        if (mechanic_id == '' || booking_id == undefined || mechanic_id == undefined) {
            $('#Assign_mechanic_spinner').css('display', 'none');
            return false;
        }
        var selector = $(this);
        $.ajax({
            url: url + '/' + booking_id + '/' + mechanic_id + '/' + from_time + '/' + to_time + '?schedule_date=' + schedule_date,
            type: 'GET',
            success: function (result) {
                $('#form_add_assignmechanic')[0].reset();
                $('.tab-pane').load($('.nav-tabs li.active a:first[data-toggle="ajaxload"]').attr('href'));
                ajaxSuccessMessage(result);
            },
            error: function (event) {
                ajaxErrorMessage(event, selector);
            },
        });
    }
});

$(function () {
    // Show Recommended Service
    $('#add_service_modal #select_add_category').on('change', function (evt) {
        evt.preventDefault();
        $('#add_service_modal .recommend_service_id').addClass('hidden');
        $('#add_service_modal select#recommend_service_id').prop('selectedIndex', 0);
        if ($(this).val() == '2') {
            $('#add_service_modal .recommend_service_id').removeClass('hidden');
        } else {
            $('#add_service_modal select#recommend_service_id').prop('selectedIndex', 0);
            $('#add_service_modal .recommend_service_id').addClass('hidden');
        }
    });

    $('#update_service_modal #select_add_category').on('change', function (evt) {
        evt.preventDefault();
        $('#update_service_modal .recommend_service_id').addClass('hidden');
        $('#update_service_modal select#recommend_service_id').prop('selectedIndex', 0);
        if ($(this).val() == '2') {
            $('#update_service_modal .recommend_service_id').removeClass('hidden');
        } else {
            $('#update_service_modal select#recommend_service_id').prop('selectedIndex', 0);
            $('#update_service_modal .recommend_service_id').addClass('hidden');
        }
    });

    // Select Option Type and Show/Hide Option Image
    $('#add_sub_service_opt_modal #option_type').on('change', function (evt) {
        evt.preventDefault();
        $('#add_sub_service_opt_modal .option_image').addClass('hidden');
        if ($(this).val() == '2') {
            $('#add_sub_service_opt_modal .option_image').removeClass('hidden');
        } else {
            $('#add_sub_service_opt_modal .option_image').addClass('hidden');
        }
    });

    // Select Option Type and Show/Hide Option Image
    $('#update_sub_service_opt_modal #option_type').on('change', function (evt) {
        evt.preventDefault();
        $('#update_sub_service_opt_modal .option_image').addClass('hidden');
        if ($(this).val() == '2') {
            $('#update_sub_service_opt_modal .option_image').removeClass('hidden');
        } else {
            $('#update_sub_service_opt_modal .option_image').addClass('hidden');
        }
    });

});

$(document).ready(function () {
    $('#add_service_modal select#recommend_service_id').multiselect({
        enableFiltering: true,
        filterBehavior: 'text',
        enableFiltering: true,
        enableFullValueFiltering: true
    });
    $('#update_service_modal select#recommend_service_id').multiselect({
        enableFiltering: true,
        filterBehavior: 'text',
        enableFiltering: true,
        enableFullValueFiltering: true
    });
    $('#add_sub_service_opt_modal select#recommend_service_id').multiselect({
        enableFiltering: true,
        filterBehavior: 'text',
        enableFiltering: true,
        enableFullValueFiltering: true
    });
    $('#update_sub_service_opt_modal select#recommend_service_id').multiselect({
        enableFiltering: true,
        filterBehavior: 'text',
        enableFiltering: true,
        enableFullValueFiltering: true
    });

    $('body').on('click', function (e) {
        $('a.show-mechanic-profile, a.show-user-profile').each(function () {
            // hide any open popovers when the anywhere else in the body is clicked
            if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                $(this).popover('hide');
            }
        });
    });
    $('a.show-mechanic-profile').on('click', function (e) {
        $(this).popover('show');
        $('a.show-mechanic-profile').not(this).popover('hide');
    });
    $('a.show-user-profile').on('click', function (e) {
        $(this).popover('show');
        $('a.show-user-profile').not(this).popover('hide');
    });
});

$(document).on('click', "a.change-role", function (e) {
    e.preventDefault();
    var url = $(this).data("url");
    $.ajax({
        url: url,
        data: {},
        type: "get",
        success: function (result) {
            location.reload();
        },
    });
});