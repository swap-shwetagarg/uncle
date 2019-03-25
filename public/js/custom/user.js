$(document).ready(function () {
    if (typeof is_rated !== 'undefined')
    {
        if (is_rated != 0)
            swal("Thank you, for your feedback!!", "", "success");
        else
            swal("Error while submit Rating", "", "error");
    }
    if (typeof is_booked !== 'undefined')
    {
        if (payment_status == 4)
        {
            swal("Your payment is under process.", "", "warning");
        } else
        {
            var isSuccess = (is_booked != 0 && payment_status == 0);
            if (isSuccess)
            {
                swal("Booked!", "", "success");
            } else
            {
                swal("Error while making payment", "", "error");
            }
        }
    }

    $('.i-check input').each(function () {
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
});
$(document).on("click", '.pay-online', function () {
    var selector = $(this);
    swal({
        title: "Please confirm you want cash on site",
        text: "You can pay online as well",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, Cash on site",
        cancelButtonText: "No, cancel it!",
        closeOnConfirm: false,
        closeOnCancel: true,
        showLoaderOnConfirm: true},
            function (isConfirm) {
                if (isConfirm) {
                    var bookingId = selector.data('bookingid');
                    var status = 1;
                    var url = '/user/bookings/update/' + bookingId + '/' + status;
                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function (result) {
                            swal("Booked!", result.message, "success");
                            $('.tab-pane').load($('.nav-tabs li.active a:first[data-toggle="ajaxload"]').attr('href'));
                        },
                        error: function (event) {
                            swal("Some error while booking please try again later", "", "error");
                        }
                    });
                } else {

                }
            });
});
$(document).on("click", '.pay-now', function () {
    var selector = $(this);
    var bookingId = selector.data('bookingid');
    payNow(bookingId);
});
$(document).on("click", '#delete_booking', function () {
    var selector = $(this);
    swal({
        title: "Please confirm you want delete booking",
        text: "The booking will be removed from your booking list",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel it!",
        closeOnConfirm: false,
        closeOnCancel: true,
        showLoaderOnConfirm: true},
            function (isConfirm) {
                if (isConfirm) {
                    var bookingId = selector.data('booking_id');
                    var status = selector.data('status');
                    var url = (status == 4 ? '/user/bookings/delete/' + bookingId : '/user/bookings/update/' + bookingId + '/5')
                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function (result) {
                            swal("Deleted!", result.message, "success");
                            $('.tab-pane').load($('.nav-tabs li.active a:first[data-toggle="ajaxload"]').attr('href'));
                        },
                        error: function (event) {
                            swal("Some error while booking please try again later", "", "error");
                        }
                    });
                } else {

                }
            });
});
$(document).on("click", '.cancel_booking', function () {
    var selector = $(this);
    swal({
        title: "Please confirm you want Cancel booking",
        text: "The booking will be cancelled",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        closeOnConfirm: false,
        closeOnCancel: true,
        showLoaderOnConfirm: true},
            function (isConfirm) {
                if (isConfirm) {
                    var bookingId = selector.data('booking_id');
                    var status = 9;
                    var url = '/user/bookings/update/' + bookingId + '/' + status
                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function (result) {
                            if (result.status != 'Failed')
                            {
                                swal("Cancelled!", result.message, "success");
                            } else
                                swal("Error!", result.message, "Error");
                            $('.tab-pane').load($('.nav-tabs li.active a:first[data-toggle="ajaxload"]').attr('href'));
                        },
                        error: function (event) {
                            swal("Some error while booking please try again later", "", "error");
                        }
                    });
                } else {

                }
            });
});
$(document).on('click', "a.load-booking-detail", function (e) {
    e.preventDefault();
    var url = $(this).data("url");
    $.ajax({
        url: url,
        data: {},
        type: "get",
        success: function (result) {
            $(".booking-detail").html(result);
        },
    });
});
$(document).on('click', "a.load-mechanic-profile", function (e) {
    e.preventDefault();
    var url = $(this).data("url");
    var selector = $(this);
    $.ajax({
        url: url,
        data: {},
        type: "get",
        success: function (result) {
            selector.popover({content: result}).popover('show');
        }
    });
});
function payNow(url, bookingId)
{
    /* swal({
     title: "Please confirm you want to pay now",
     text: "You will be redirected to the Payment gatway page.",
     type: "warning",
     showCancelButton: true,
     confirmButtonText: "Yes, Continue..",
     cancelButtonText: "No, cancel it!",
     closeOnConfirm: false,
     closeOnCancel: true,
     showLoaderOnConfirm: true},
     function (isConfirm) {
     if (isConfirm) {     */
    var url = url + bookingId;
    $.ajax({
        url: url,
        type: 'GET',
        success: function (result) {
            location.href = result.payment_url;
            //swal("Booked!", result.message, "success");
            //selector.closest('.tab-pane').load($('li.active a[data-toggle="ajaxload"]').attr('href'));
        },
        error: function (event) {
            swal("Some error while booking please try again later", "", "error");
        }
    });
    /*} else {
     
     }
     });*/
}
$(document).on('submit', "#form_book_schedule", function (e) {
    e.preventDefault();
    var sc_time = '';
    $('.error-on-schedule').empty();
    if ($('#latlong').val() == "")
    {
        $('.error-on-schedule').append('Please select booking address !');
        notSubmit();
        return false;
    }
    $('.time input').each(function () {
        if ($(this).is(':checked')) {
            sc_time = $(this).data('time');
        }
    });
    if (sc_time != '')
    {
        var payment_mode = false;
        var booking_id = $('.booking-id').data('booking_id');
        var schedule_date = $('.booking-date').text();
        var schedule_start_time = sc_time;
        var schedule_end_time = sc_time;
        var isOffline = $('#radio-cash-on-delivery').is(':checked');
        if (isOffline) {
            payment_mode = 'COS';
        }
        var isPaid = $('.booking_status').data('status');
        var address = $('#latlong').val();
        var token = $('input[name="_token"]').val();
        var selector = $(this);
        var obj = {'payment_mode': payment_mode, 'address': encodeURIComponent(address), 'booking_id': booking_id, 'date': schedule_date, 'sTime': schedule_start_time, 'eTime': schedule_end_time, '_token': token};
        $.ajax({
            url: $(this).data('url'),
            data: obj,
            type: "POST",
            success: function (result) {
                if (result.status == 'success')
                {
                    if (isPaid != 2)
                    {
                        if (isOffline)
                        {
                            var status = 1;
                            var url = '/user/bookings/update/' + booking_id + '/' + status;
                            $.ajax({
                                url: url,
                                type: 'GET',
                                success: function (result) {
                                    swal({
                                        title: "Booking Confirmed!",
                                        text: "",
                                        type: "success",
                                        confirmButtonText: "OK"
                                    },
                                            function (isConfirm) {
                                                if (isConfirm) {
                                                    window.location.href = "/user/bookings";
                                                }
                                            });
                                },
                                error: function (event) {
                                    swal("Some error while booking please try again later", "", "error");
                                }
                            });
                        } else
                        {
                            if ($('#radio-pay-now-sly').is(':checked'))
                            {
                                var url = $('#radio-pay-now-sly').data('url');
                                payNow(url, booking_id);
                            }
                            if ($('#radio-pay-now-exp').is(':checked'))
                            {
                                var url = $('#radio-pay-now-exp').data('url');
                                expressPay(url, booking_id);
                            }
                            if (!$('#radio-pay-now-sly').is(':checked') && !$('#radio-pay-now-exp').is(':checked'))
                            {
                                swal({
                                    title: "Booking Re-scheduled!",
                                    text: "",
                                    type: "success",
                                    confirmButtonText: "OK"
                                },
                                        function (isConfirm) {
                                            if (isConfirm) {
                                                window.location.href = "/user/bookings";
                                            }
                                        });
                            }
                        }
                    }
                }
            },
            error: function (event) {
                swal("Some error while booking please try again later", "", "error");
            },
        });
    } else
    {
        $('.error-on-schedule').append('Please select booking time !');
        notSubmit();
    }
});
function notSubmit() {
    setTimeout(function () {
        $('button[type=submit]').removeAttr('disabled');
        $('#schedule-timer-spinner').css('display', 'none');
    }, 200);
}
$(document).on('click', ".copy-to-clipboard", function (e) {
    e.preventDefault();
    var aux = document.createElement("input");
    aux.setAttribute("value", $('#copy-to-clipboard').val());
    document.body.appendChild(aux);
    aux.select();
    document.execCommand("copy");
    document.body.removeChild(aux);
    toastr.success("Copied", "", {timeOut: 2500, progressBar: true, debug: true});
});
$(document).on('submit', "#send_referral_form", function (e) {
    e.preventDefault();
    var url = $(this).data('url');
    $.ajax({
        url: url,
        type: 'POST',
        data: $('#send_referral_form').serialize(),
        success: function (result) {
            ajaxSuccessMessage(result, $(this));
        },
        error: function (event) {
            ajaxErrorMessage(event, $(this));
        }
    });
});
$('#send_referral_modal').on('shown.bs.modal', function (e) {
    $("#data-emails").val();
    $(this).find('button[type=submit]').attr('disabled', false);
});
function expressPay(url, bookingId)
{
    $.ajax({
        url: url + '/' + bookingId,
        data: {},
        type: "get",
        success: function (result) {
            if (result.result.status == 1)
            {
                location.href = result.url + "?token=" + result.result.token;
            } else
            {
                swal({
                    title: "Some error occured while making payment",
                    text: "",
                    type: "Error",
                    confirmButtonText: "OK"
                },
                        function (isConfirm) {
                            if (isConfirm) {
                                window.location.href = "/user/bookings";
                            }
                        });
            }
        }
    });
}

$(document).on('change', '#user_addres_list', function (e) {
    e.preventDefault();
    var add = $('#user_addres_list :selected').text() != 'Custom' ? $('#user_addres_list :selected').text() : '';
    $('#booking_address').val(add);
});


/*Rating JS Start*/

$(".rating label.full").click(function () {
    $(this).parent().find("label").css({"background-color": "#d8d8d8"});
    $(this).css({"background-color": "#ffc100"});
    $(this).nextAll().css({"background-color": "#ffc100"});
});

$(".star label").click(function () {
    $(this).parent().find("label").css({"color": "#d8d8d8"});
    $(this).css({"color": "#ffc100"});
    $(this).nextAll().css({"color": "#ffc100"});
    $(this).css({"background-color": "transparent"});
    $(this).nextAll().css({"background-color": "transparent"});
});

$(document).on('click', '#submit-rating', function (e) {
    e.preventDefault();
    $('.error-on-schedule').empty();
    for (i = 1; i <= 6; i++) {
        if (!$('input[name=rating' + i + ']').is(':checked')) {
            $('.error-on-schedule').append('Please rate for all!');
            $('button[type=submit]').removeAttr('disabled');
            return false;
        }
    }
    $('#rate_mechanic').submit();
});
/* Rating JS End*/

$(document).on('click', '.req-a-quote', function (e) {
    e.preventDefault();
    $(this).attr('disabled', 'disabled');
    var bookingId = $(this).data('booking_id');
    var status = 4;
    var url = '/user/bookings/update/' + bookingId + '/' + status;
    $.ajax({
        url: url,
        type: 'GET',
        success: function (result) {
            $('.tab-pane').load($('.nav-tabs li.active a:first[data-toggle="ajaxload"]').attr('href'));
        },
        error: function (event) {
            swal("Some error while booking please try again later", "", "error");
        },
        complete: function (event) {
            $(this).removeAttr('disabled');
        }
    });
});

$('a.sidebar-toggle').click(function () {
    $('#app').css('overflow-y', 'scroll');
});