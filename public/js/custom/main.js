var own_service_description = '';
//var review_button_html = "<div class='row'><div class='col-md-12 col-sm-12 col-xs-12 text-right'><button type='button' data-loading-text='Loading...' id='selected_container_review_btn' class='btn btn-primary pull-right review-and-book'>Review &amp; Book</button></div></div>"
var review_button_html = ""
// Common function for ajax failure 
function ajaxErrorMessage(event, selector) {
    $('img.spinner').hide();
    $.each(event.responseJSON, function (key, val) {
        selector.find('#' + key).html(val).addClass('help-block');
        selector.find('div.' + key).addClass('has-error');
    });
}

// Common function for create cookie
function createCookie(name, value, days) {
    var expires;
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    } else {
        expires = "";
    }
    document.cookie = encodeURIComponent(name) + "=" + encodeURIComponent(value) + expires + "; path=/";
}

// Common function for read cookie
function readCookie(name) {
    var nameEQ = encodeURIComponent(name) + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) === ' ')
            c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0)
            return decodeURIComponent(c.substring(nameEQ.length, c.length));
    }
    return null;
}

// Common function for Erase cookie
function eraseCookie(name) {
    createCookie(name, "", -1);
}

$(document).ready(function () {
    // Add smooth scrolling to all links
    $(document).on('click', 'a', function (event) {
        var string = this.hash;
        if (this.hash !== "" && string.indexOf('faq') === -1) {
            // Prevent default anchor click behavior
            event.preventDefault();
            // Store hash
            var hash = this.hash;
            // Using jQuery's animate() method to add smooth page scroll
            // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
            $('html, body').animate({
                scrollTop: $(hash).offset().top
            }, 1200);
        }
    });
});

// Resize jQuery Steps When content load
function resizeJquerySteps() {
    $('.wizard .content').animate({
        height: $('.body.current').outerHeight()
    }, 'fast');
}

function resizeServiceTab() {
    $('.service-type-nav a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        resizeJquerySteps();
    });
}

$(document).ready(function () {
    resizeServiceTab();
    resizeJquerySteps();
    if (typeof $(document).find('ul.selected-car').html() !== 'undefined') {
        if (($(document).find('ul.selected-car').html().trim().length !== 0) || (readCookie('uf_car_info'))) {
            $("#example-form").children("div").steps("next");
            if (typeof $(document).find('.review-and-book-container .selected-services').html() !== 'undefined') {
                if (($(document).find('.review-and-book-container .selected-services').html().trim().length !== 0) || (readCookie('uf_services'))) {
                    $("#example-form").children("div").steps("next");
                    $(document).find('.review-and-book-container').removeClass('hidden');
                }
            }
            $('#example-form .steps ul li.done').addClass('disabled');
            $('.selected-car-step2').html($(".selected-car"));
        }
    }

    // Search Location
    $(document).on("change", '#location', function (evt) {
        $('.location-message').removeClass('success failed')
        $('.users-car-container').removeClass('hidden').html('');
        $('#booking-loader').removeClass('hidden');
        evt.preventDefault();
        resizeJquerySteps();
        var location = $(this).val();
        var selector = $(this);
        $.ajax({
            url: 'http://localhost/unclefitter/public/check-service-availability/' + location,
            type: 'GET',
            success: function (response, textStatus, request) {
                $('#booking-loader').addClass('hidden');
                resizeJquerySteps();
                if (response.status === 'success') {
                    $('.location-message').removeClass('hidden failed').addClass(response.status).html(response.data);
                    $('.confirm--zip').removeClass('hidden');
                    $('#confirm-location').removeClass('hidden');
                } else if (response.status === 'failed') {
                    $('#confirm-location').addClass('hidden');
                    $('.location-message').removeClass('hidden success').addClass(response.status).html(response.data);
                }
                resizeJquerySteps();
            },
            error: function (event) {
                $('#booking-loader').addClass('hidden');
                ajaxErrorMessage(event, selector);
            }
        });
    });

    // Confirm Location and Load Car's Lists
    $(document).on("click", '#confirm-location', function (evt) {
        evt.preventDefault();
        $('.users-car-container').removeClass('hidden').html('');
        $('#booking-loader').removeClass('hidden');
        var selector = $(this);
        var $btn = $(this).button('loading');
        $.ajax({
            url: 'http://localhost/unclefitter/public/show-cars/0',
            type: 'GET',
            success: function (result) {
                $('#booking-loader').addClass('hidden');
                $btn.button('reset');
                if (result) {
                    resizeJquerySteps();
                    $('#confirm-location').addClass('hidden');
                    $('.car-info-container').removeClass('hidden');
                    $('.cars-listing').removeClass('hidden').html(result);
                    resizeJquerySteps();
                }
            },
            error: function (event) {
                $('#booking-loader').addClass('hidden');
                $btn.button('reset');
                ajaxErrorMessage(event, selector);
            }
        });
    });

    // Select a Car and Load all the years
    $(document).on("change", '.car', function (evt) {
        evt.preventDefault();
        var car_id = $(this).val();
        var name = $(this).data('name');
        var selector = $(this);
        $('#booking-loader').removeClass('hidden');
        $.ajax({
            url: 'http://localhost/unclefitter/public/show-years/' + car_id,
            type: 'GET',
            success: function (result) {
                $('#booking-loader').addClass('hidden');
                if (result && result != 0) {
                    resizeJquerySteps();
                    $('.cars-listing').addClass('hidden');
                    $('.years-listing').removeClass('hidden').html(result);
                    $('.selected-car-container').removeClass('hidden');
                    var html = "<li class='col-md-3 col-sm-3 no--padding'><input checked disabled class='radio-custom car' type='radio' value='" + car_id + "' name='selected_car' id='selected-car'/><label class='radio-custom-label' for='selected-car'>" + name + "</label></li>";
                    $('.selected-car').append(html);
                    resizeJquerySteps();
                } else if (result == 0) {
                    $('#error-msg').html("Years Not Exists!");
                }
            },
            error: function (event) {
                $('#booking-loader').addClass('hidden');
                ajaxErrorMessage(event, selector);
            }
        });
    });

    // Select a Year and Load all the years
    $(document).on("change", '.year', function (evt) {
        evt.preventDefault();
        var year_id = $(this).val();
        $('#booking-loader').removeClass('hidden');
        var name = $(this).data('name');
        var selector = $(this);
        $.ajax({
            url: 'http://localhost/unclefitter/public/show-models/' + year_id,
            type: 'GET',
            success: function (result) {
                $('#booking-loader').addClass('hidden');
                if (result && result != 0) {
                    resizeJquerySteps();
                    $('.years-listing').addClass('hidden');
                    $('.models-listing').removeClass('hidden').html(result);
                    var html = "<li class='col-md-3 col-sm-3 no--padding'><input checked disabled class='radio-custom year' type='radio' value='" + year_id + "' name='selected_year' id='selected-year'/><label class='radio-custom-label' for='selected-year'>" + name + "</label></li>";
                    $('.selected-car').append(html);
                    resizeJquerySteps();
                } else if (result == 0) {
                    $('#error-msg').html("Car Models Not Exists!");
                }
            },
            error: function (event) {
                $('#booking-loader').addClass('hidden');
                ajaxErrorMessage(event, selector);
            }
        });
    });

    // Select a Model and Load all the years
    $(document).on("change", '.model', function (evt) {
        evt.preventDefault();
        var model_id = $(this).val();
        $('#booking-loader').removeClass('hidden');
        var name = $(this).data('name');
        var selector = $(this);
        $.ajax({
            url: 'http://localhost/unclefitter/public/show-trims/' + model_id,
            type: 'GET',
            success: function (result) {
                $('#booking-loader').addClass('hidden');
                if (result && result != 0) {
                    resizeJquerySteps();
                    $('.models-listing').addClass('hidden');
                    $('.trims-listing').removeClass('hidden').html(result);
                    var html = "<li class='col-md-3 col-sm-3 no--padding'><input checked disabled class='radio-custom model' type='radio' value='" + model_id + "' name='selected_model' id='selected-model'/><label class='radio-custom-label' for='selected-model'>" + name + "</label></li>";
                    $('.selected-car').append(html);
                    resizeJquerySteps();
                } else if (result == 0) {
                    $('#error-msg').html("Car Trims Not Exists!");
                }
            },
            error: function (event) {
                $('#booking-loader').addClass('hidden');
                ajaxErrorMessage(event, selector);
            }
        });
    });

    // Select a Trim and Load all the years
    $(document).on("change", '.trim', function (evt) {
        evt.preventDefault();
        var trim_id = $(this).val();
        $('#booking-loader').removeClass('hidden');
        var name = $(this).data('name');
        var selector = $(this);
        $.ajax({
            url: 'http://localhost/unclefitter/public/show-car-info/' + trim_id,
            type: 'GET',
            success: function (result) {
                console.log(result)
                $('#booking-loader').addClass('hidden');
                if (result.status) {
                    resizeJquerySteps();
                    if ($('.selected-car-step2').length) {
                        $('.selected-car-step2').html(result.car_info_view);
                        $("#example-form").children("div").steps("next");
                        $('#example-form .steps ul li.done').addClass('disabled');
                        resizeJquerySteps();
                    } else {
                        $("div.select_car").addClass('hidden');
                    }
                    $.ajax({
                        url: 'http://localhost/unclefitter/public/show-sub-services/' + result.service_id,
                        type: 'GET',
                        success: function (result) {
                            $('#booking-loader').addClass('hidden');
                            if (result && result != 0) {
                                resizeJquerySteps();
                                $('.services-container').addClass('hidden');
                                if ($(document).find('.sub-services-container').html().trim().length !== 0) {
                                    $('.sub-services-container').removeClass('hidden').append(result);
                                } else {
                                    $('.sub-services-container').removeClass('hidden').html(result);
                                }
                                $('.own-service-container').addClass('hidden');
                                $('.review-book-action-container').removeClass('hidden');
                                resizeJquerySteps();
                            } else if (result == 0) {
                                $('#error-msg').html("Sub-Service Not Exists!");
                            }
                        },
                        error: function (event) {
                            $('#booking-loader').addClass('hidden');
                            ajaxErrorMessage(event, selector);
                        }
                    });
                } else if (result && result != 0) {
                    resizeJquerySteps();
                    $('.trims-listing').addClass('hidden');
                    var html = "<li class='col-md-3 col-sm-3 no--padding'><input checked disabled class='radio-custom trim' type='radio' value='" + trim_id + "' name='selected_trim' id='selected-trim'/><label class='radio-custom-label' for='selected-trim'>" + name + "</label></li>";
                    $('.selected-car').append(html);
                    $("#example-form").children("div").steps("next");
                    $('#example-form .steps ul li.done').addClass('disabled');

                    if ($(document).find('ul.selected-car').html().trim().length !== 0) {
                        $('.selected-car-step2').html($(".selected-car"));
                    }

                    resizeJquerySteps();
                } else if (result == 0) {
                    $('#error-msg').html("Car Info Not Exists!");
                }
            },
            error: function (event) {
                $('#booking-loader').addClass('hidden');
                ajaxErrorMessage(event, selector);
            }
        });
    });

    // Select a service and Load all Sub-Services
    $(document).on("click", '.service', function (evt) {
        evt.preventDefault();
        $('#booking-loader').removeClass('hidden');
        var service_id = $(this).data('id');
        var selector = $(this);
        $.ajax({
            url: 'http://localhost/unclefitter/public/show-sub-services/' + service_id,
            type: 'GET',
            success: function (result) {
                $('#booking-loader').addClass('hidden');
                if (result && result != 0) {
                    resizeJquerySteps();
                    $('.services-container').addClass('hidden');
                    if ($(document).find('.sub-services-container').html().trim().length !== 0) {
                        $(document).find('.next-step-button').remove();
                        $('.sub-services-container').removeClass('hidden').append(result.service_listing);
                    } else {
                        $('.sub-services-container').removeClass('hidden').html(result.service_listing);
                    }
                    $('.own-service-container').addClass('hidden');
                    $('.review-book-action-container').removeClass('hidden');
                    if (result.selected) {
                        $(".selected_services-container").removeClass('hidden').html('').html(result.selected);
                        if (own_service_description) {
                            var li_html = "<li class='no--padding'><input checked='' disabled='' class='radio-custom car' type='radio'><label class='radio-custom-label' for='selected-car'>" + own_service_description + " <span class='pull-right'><a class='delete-custom-service'><img src='/web/img/dustbin.png'></a></span></label></li>";
                            $(".selected_services_ul").append(li_html);
                        }
                        $(".selected_services_ul").append(review_button_html)
                    } else {
                        $(".selected_services-container").addClass('hidden')
                        if (own_service_description) {
                            var ul_li_html = "<h1>Selected Services</h1><ul class='selected-car-step2 selected-car' style='padding-left: 0px !important;'><ul class='no--padding selected_services_ul' style='padding-left: 0px !important;'><li class='no--padding'><input checked='' disabled='' class='radio-custom car' type='radio'><label class='radio-custom-label' for='selected-car'>" + own_service_description + " <span class='pull-right'><a class='delete-custom-service'><img src='/web/img/dustbin.png'></a></span></label></li></ul></ul>";
                            $(".selected_services-container").removeClass('hidden').html('').html(ul_li_html);
                        }
                        $(".selected_services_ul").append(review_button_html)
                    }
                    resizeJquerySteps();
                } else if (result == 0) {
                    $('#error-msg').html("Sub-Service Not Exists!");
                }
            },
            error: function (event) {
                $('#booking-loader').addClass('hidden');
                ajaxErrorMessage(event, selector);
            }
        });
    });

    // Select a service and Load all Sub-Services
    $(document).on("change", '.sub-service', function (evt) {
        evt.preventDefault();
        $('#booking-loader').removeClass('hidden');
        if ($(this).prop('checked')) {
            var sub_service_id = $(this).val();
            var selector = $(this);
            $.ajax({
                url: 'http://localhost/unclefitter/public/show-options/' + sub_service_id,
                type: 'GET',
                success: function (result) {
                    $('#booking-loader').addClass('hidden');
                    if (result && result != 0) {
                        $('#options-container').css({'display': 'block'}).html(result);
                    } else if (result == 0) {
                        $('#error-msg').html("Options Not Exists!");
                    }
                },
                error: function (event) {
                    $('#booking-loader').addClass('hidden');
                    ajaxErrorMessage(event, selector);
                }
            });
        } else {
            $('#booking-loader').addClass('hidden');
            $('#options-container').css({'display': 'none'});
        }
    });

    // Select a service and Load all Sub-Services
    $(document).on("click", '#review-and-book', function (evt) {
        evt.preventDefault();
        var service_ids = '';
        $.each($('input[name="service_id[]"]'), function (key, value) {
            if (service_ids.length == 0) {
                service_ids = $(value).val();
            } else {
                service_ids += ',' + $(value).val();
            }
        });

        $('#booking-loader').removeClass('hidden');
        resizeJquerySteps();
        $('#own_service_description').removeClass('input-fields-border');
        $('.own-service-container .required-msg').addClass('hidden').html('');
        var selector = $(this);
        if (!$('.own-service-container').hasClass('hidden')) {
            if (own_service_description === '' && own_service_description.length === 0) {
                $('#booking-loader').addClass('hidden');
                $('#own_service_description').css('border', '1px solid #fd4339');
                $('.own-service-container .required-msg').removeClass('hidden').html('Please enter your own service description')
                return false;
            }
        }
        var _token = $('input[name="_token"]').val();
        var $btn = $(this).button('loading');
        $.ajax({
            url: 'http://localhost/unclefitter/public/review-and-book',
            data: {own_service_description: own_service_description, _token: _token, service_ids: service_ids},
            type: 'POST',
            success: function (result) {
                $('#booking-loader').addClass('hidden');
                $btn.button('reset');
                if (result && result != 0) {
                    resizeJquerySteps();
                    $('.review-and-book-container').removeClass('hidden').html(result);
                    $("#example-form").children("div").steps("next");
                    $('#example-form .steps ul li.done').addClass('disabled');
                    resizeJquerySteps();
                } else if (result == 0) {
                    $('#error-msg').html("Options Not Exists!");
                }
            },
            error: function (event) {
                $('#booking-loader').addClass('hidden');
                $btn.button('reset');
                ajaxErrorMessage(event, selector);
            }
        });
    });

    // Select a service and Load all Sub-Services
    $(document).on("change", 'input[name="user"]', function (evt) {
        evt.preventDefault();
        $('#booking-loader').removeClass('hidden');
        resizeJquerySteps();
        var value = $(this).val();
        if (value === 'already') {
            resizeJquerySteps();
            $('#new-user-container').addClass('hidden');
            $('#already-user-container').removeClass('hidden').html();
            resizeJquerySteps();
        } else if (value === 'new') {
            resizeJquerySteps();
            $('#already-user-container').addClass('hidden');
            $('#new-user-container').removeClass('hidden').html();
            resizeJquerySteps();
        }
        $('#booking-loader').addClass('hidden');
    });

    // Signup via AJAX
    $(document).on("click", '#signup', function (evt) {
        evt.preventDefault();
        $('#booking-loader').removeClass('hidden');
        $('#name, #email_address, #mobile, #npassword, #password_confirmation').removeClass('input-fields-border');
        $('.signup-name-error-msg, .signup-email-error-msg, .signup-mobile-error-msg, .signup-password-error-msg, .signup-cpassword-error-msg').addClass('hidden').html('');
        var selector = $(this);
        var name = $('#name').val();
        if (name === '' && name.length === 0) {
            $('#booking-loader').addClass('hidden');
            $('#name').addClass('input-fields-border');
            $('.signup-name-error-msg').removeClass('hidden').html('Please enter name');
            return false;
        }
        var email = $('#email_address').val();
        if (email === '' && email.length === 0) {
            $('#booking-loader').addClass('hidden');
            $('#email_address').addClass('input-fields-border');
            $('.signup-email-error-msg').removeClass('hidden').html('Please enter email');
            return false;
        }
        var mobile_country_code = $('#mobile_country_code').val();
        var mobile = $('#mobile').val();
        if (mobile === '' && mobile.length === 0) {
            $('#booking-loader').addClass('hidden');
            $('#mobile').addClass('input-fields-border');
            $('.signup-mobile-error-msg').removeClass('hidden').html('Please enter mobile');
            return false;
        }
        var password = $('#npassword').val();
        if (password === '' && password.length === 0) {
            $('#booking-loader').addClass('hidden');
            $('#npassword').addClass('input-fields-border');
            $('.signup-password-error-msg').removeClass('hidden').html('Please enter password');
            return false;
        }
        var password_confirmation = $('#password_confirmation').val();
        if (password_confirmation === '' && password_confirmation.length === 0) {
            $('#booking-loader').addClass('hidden');
            $('#password_confirmation').addClass('input-fields-border');
            $('.signup-cpassword-error-msg').removeClass('hidden').html('Please enter confirm password');
            return false;
        }
        if (password !== password_confirmation) {
            $('#booking-loader').addClass('hidden');
            $('#password_confirmation').addClass('input-fields-border');
            $('.signup-cpassword-error-msg').removeClass('hidden').html('Password and confirm password must be same');
            return false;
        }
        var default_location = $('#default_location').val();
        var remember_token = $('#already-user-container input[name="_token"]').val();
        var request_from = 'AJAX';
        var $btn = $(this).button('loading');
        $.ajax({
            url: 'http://localhost/unclefitter/public/register',
            data: {name: name, email: email, mobile: mobile, password: password, password_confirmation: password_confirmation,
                _token: remember_token, request_from: request_from, default_location: default_location, mobile_country_code: mobile_country_code},
            type: 'POST',
            success: function (response, textStatus, request) {
                $('#booking-loader').addClass('hidden');
                $btn.button('reset');
                if (response.status === 'success') {
                    resizeJquerySteps();
                    $('#already-user-container').addClass('hidden');
                    $('#new-user-container').addClass('hidden');
                    $('.select-action-row').addClass('hidden');
                    $('#verify-user-container').removeClass('hidden');
                    //$('#submit-quote-container').removeClass('hidden');
                    resizeJquerySteps();
                } else if (response.status === 'failed') {
                    $('#error-msg').html("Options Not Exists!");
                }
            },
            error: function (event) {
                $('#booking-loader').addClass('hidden');
                $btn.button('reset');
                ajaxErrorMessage(event, selector);
            }
        });
    });

    // Signin via AJAX
    $(document).on("click", '#signin', function (evt) {
        evt.preventDefault();
        $('#booking-loader').removeClass('hidden');
        $('#password, #email').removeClass('input-fields-border');
        $('.login-email-error-msg, .login-password-error-msg').addClass('hidden').html('');
        $('#user-error-container').addClass('hidden');
        $('#user-error-container .alert').html('');
        var selector = $(this);
        var email = $('#email').val();
        if (email === '' && email.length === 0) {
            $('#booking-loader').addClass('hidden');
            $('#email').addClass('input-fields-border');
            $('.login-email-error-msg').removeClass('hidden').html('Please enter email');
            return false;
        }
        var password = $('#password').val();
        if (password === '' && password.length === 0) {
            $('#booking-loader').addClass('hidden');
            $('#password').addClass('input-fields-border');
            $('.login-password-error-msg').removeClass('hidden').html('Please enter password');
            return false;
        }
        var remember_token = $('#password_confirmation').val();
        var remember_token = $('#new-user-container input[name="_token"]').val();
        var request_from = 'AJAX';
        var $btn = $(this).button('loading');
        $.ajax({
            url: 'http://localhost/unclefitter/public/login',
            data: {email: email, password: password, _token: remember_token, ajax: request_from},
            type: 'POST',
            success: function (response, textStatus, request) {
                $('#booking-loader').addClass('hidden');
                $btn.button('reset');
                if (response.status === 'success') {
                    resizeJquerySteps();
                    $('#already-user-container').addClass('hidden');
                    $('#new-user-container').addClass('hidden');
                    $('.select-action-row').addClass('hidden');
                    $('#submit-quote-container').removeClass('hidden');
                    resizeJquerySteps();
                } else if (response.status === 'failed') {
                    $('#error-msg').html("Options Not Exists!");
                } else if (response.status === 'error') {
                    $('#user-error-container').removeClass('hidden');
                    $('#user-error-container .alert').addClass('alert-danger').html(response.email);
                }
            },
            error: function (event) {
                $('#booking-loader').addClass('hidden');
                $btn.button('reset');
                ajaxErrorMessage(event, selector);
            }
        });
    });

    $(document).on("click", "#add-more-services-from-review", function () {
        $("#example-form").children("div").steps("previous")
        $("#add-more-services").trigger("click")
    })

    // Add More Services
    $(document).on("click", '#add-more-services,.add_custom_services,.delete-custom-service', function (evt) {
        evt.preventDefault();
        $('#booking-loader').removeClass('hidden');
        if ($(this).hasClass('add_custom_services')) {
            own_service_description = $("#own_service_description").val()
        }
        if ($(this).hasClass('delete-custom-service')) {
            own_service_description = ''
        }
        resizeJquerySteps();
        var selector = $(this);
        $.ajax({
            url: 'http://localhost/unclefitter/public/add-more-services',
            type: 'GET',
            success: function (result) {
                $('#booking-loader').addClass('hidden');
                if (result && result != 0 && result.show_services) {
                    resizeJquerySteps();
                    $('.sub-services-container').html('').addClass('hidden');
                    $('.recommended-services-container').addClass('hidden');
                    $('.own-service-container').addClass('hidden');
                    $('.review-book-action-container').addClass('hidden');
                    $('.services-container').removeClass('hidden').html(result.show_services);
                    $('.sub-services-container').each(function () {
                        if (!$(this).text().match(/^\s*$/)) {
                            $(this).insertBefore($(this).prev('.services-container'));
                        }
                    });
                    if (result.selected) {
                        $(".selected_services-container").removeClass('hidden').html('').html(result.selected);
                        if (own_service_description) {
                            var li_html = "<li class='no--padding'><input checked='' disabled='' class='radio-custom car' type='radio'><label class='radio-custom-label' for='selected-car'>" + own_service_description + " <span class='pull-right'><a class='delete-custom-service'><img src='/web/img/dustbin.png'></a></span></label></li>";
                            $(".selected_services_ul").append(li_html);
                        }
                        $(".selected_services_ul").append(review_button_html)
                    } else {
                        $(".selected_services-container").addClass('hidden')
                        if (own_service_description) {
                            var ul_li_html = "<h1>Selected Services</h1><ul class='selected-car-step2 selected-car' style='padding-left: 0px !important;'><ul class='no--padding selected_services_ul' style='padding-left: 0px !important;'><li class='no--padding'><input checked='' disabled='' class='radio-custom car' type='radio'><label class='radio-custom-label' for='selected-car'>" + own_service_description + " <span class='pull-right'><a class='delete-custom-service'><img src='/web/img/dustbin.png'></a></span></label></li></ul></ul>";
                            $(".selected_services-container").removeClass('hidden').html('').html(ul_li_html);
                        }
                        $(".selected_services_ul").append(review_button_html)
                    }
                    resizeJquerySteps();
                } else if (result == 0) {
                    $('#error-msg').html("Sub-Service Not Exists!");
                }
            },
            error: function (event) {
                $('#booking-loader').addClass('hidden');
                ajaxErrorMessage(event, selector);
            }
        });
    });

    // Delete Selected Service
    $(document).on("click", 'a.delete-selected-service', function (evt) {
        evt.preventDefault();
        $('#booking-loader').removeClass('hidden');
        var service_id = $(this).data('id');
        swal({
            title: "Are you sure want to delete service!",
            text: " ",
            type: "error",
            showCancelButton: true,
            confirmButtonText: "Yes, Delete it..",
            cancelButtonText: "No, cancel it!",
            closeOnConfirm: true,
            closeOnCancel: true,
            showLoaderOnConfirm: true
        },
                function (isConfirm) {
                    if (isConfirm) {
                        resizeJquerySteps();
                        var selector = $(this);
                        $.ajax({
                            url: 'http://localhost/unclefitter/public/delete-selected-service/' + service_id,
                            type: 'GET',
                            success: function (response, textStatus, request) {
                                $('#booking-loader').addClass('hidden');
                                if (response.status === 'success') {
                                    $(document).find('.sub-service-parent' + service_id).remove();
                                    $(document).find('.recommended-service' + service_id).remove();
                                    $('.sub-services-container').html('').addClass('hidden');
                                    $('.recommended-services-container').addClass('hidden');
                                    $('.own-service-container').addClass('hidden');
                                    $('.review-book-action-container').addClass('hidden');
                                    if (response.tag == "single_delete") {
                                        var make_url = '/add-more-services';
                                        $.ajax({
                                            url: make_url,
                                            type: 'GET',
                                            success: function (result) {
                                                $('#booking-loader').addClass('hidden');
                                                if (result && result != 0 && result.show_services) {
                                                    resizeJquerySteps();
                                                    $('.services-container').removeClass('hidden').html(result.show_services);
                                                    if (result.selected) {
                                                        $(".selected_services-container").removeClass('hidden').html('').html(result.selected);
                                                        if (own_service_description) {
                                                            var li_html = "<li class='no--padding'><input checked='' disabled='' class='radio-custom car' type='radio'><label class='radio-custom-label' for='selected-car'>" + own_service_description + " <span class='pull-right'><a class='delete-custom-service'><img src='/web/img/dustbin.png'></a></span></label></li>";
                                                            $(".selected_services_ul").append(li_html);
                                                        }
                                                        $(".selected_services_ul").append(review_button_html)
                                                    } else {
                                                        $(".selected_services-container").addClass('hidden')
                                                        if (own_service_description) {
                                                            var ul_li_html = "<h1>Selected Services</h1><ul class='selected-car-step2 selected-car' style='padding-left: 0px !important;'><ul class='no--padding selected_services_ul' style='padding-left: 0px !important;'><li class='no--padding'><input checked='' disabled='' class='radio-custom car' type='radio'><label class='radio-custom-label' for='selected-car'>" + own_service_description + " <span class='pull-right'><a class='delete-custom-service'><img src='/web/img/dustbin.png'></a></span></label></li></ul></ul>";
                                                            $(".selected_services-container").removeClass('hidden').html('').html(ul_li_html);
                                                        }
                                                        $(".selected_services_ul").append(review_button_html)
                                                    }
                                                    resizeJquerySteps();
                                                } else if (result == 0) {
                                                    $('#error-msg').html("Sub-Service Not Exists!");
                                                }
                                            },
                                            error: function (event) {
                                                $('#booking-loader').addClass('hidden');
                                                ajaxErrorMessage(event, selector);
                                            }
                                        });
                                    }
                                    if (response && response != 0 && response.show_services) {
                                        resizeJquerySteps();
                                        $('.services-container').removeClass('hidden').html(response.show_services);
                                        if (response.selected) {
                                            $(".selected_services-container").removeClass('hidden').html('').html(response.selected);
                                            if (own_service_description) {
                                                var li_html = "<li class='no--padding'><input checked='' disabled='' class='radio-custom car' type='radio'><label class='radio-custom-label' for='selected-car'>" + own_service_description + " <span class='pull-right'><a class='delete-custom-service'><img src='/web/img/dustbin.png'></a></span></label></li>";
                                                $(".selected_services_ul").append(li_html);
                                            }
                                            $(".selected_services_ul").append(review_button_html)
                                        } else {
                                            $(".selected_services-container").addClass('hidden')
                                            if (own_service_description) {
                                                var ul_li_html = "<h1>Selected Services</h1><ul class='selected-car-step2 selected-car' style='padding-left: 0px !important;'><ul class='no--padding selected_services_ul' style='padding-left: 0px !important;'><li class='no--padding'><input checked='' disabled='' class='radio-custom car' type='radio'><label class='radio-custom-label' for='selected-car'>" + own_service_description + " <span class='pull-right'><a class='delete-custom-service'><img src='/web/img/dustbin.png'></a></span></label></li></ul></ul>";
                                                $(".selected_services-container").removeClass('hidden').html('').html(ul_li_html);
                                            }
                                            $(".selected_services_ul").append(review_button_html)
                                        }
                                        resizeJquerySteps();
                                    } else if (response == 0) {
                                        $('#error-msg').html("Sub-Service Not Exists!");
                                    }
                                } else {
                                    $('.own-service-container').addClass('hidden');
                                    $('.recommended-services-container').addClass('hidden');
                                    $('.review-book-action-container').addClass('hidden');
                                }
                                resizeJquerySteps();
                            },
                            error: function (event) {
                                $('#booking-loader').addClass('hidden');
                                ajaxErrorMessage(event, selector);
                            }
                        });

                    } else {
                        $('#booking-loader').addClass('hidden');
                    }
                });
    });

    // Add New Car
    $(document).on("click", 'button.add-new-car', function (evt) {
        evt.preventDefault();
        $('#booking-loader').removeClass('hidden');
        resizeJquerySteps();
        var selector = $(this);
        var $btn = $(this).button('loading');
        $.ajax({
            url: 'http://localhost/unclefitter/public/show-cars/1',
            type: 'GET',
            success: function (result) {
                $('#booking-loader').addClass('hidden');
                $btn.button('reset');
                if (result && result != 0) {
                    resizeJquerySteps();
                    $('.cars-listing.listings').removeClass('hidden').append(result);
                    $('.user-cars-row').addClass('hidden');
                    resizeJquerySteps();
                } else if (result == 0) {
                    $('#error-msg').html("Sub-Service Not Exists!");
                }
            },
            error: function (event) {
                $('#booking-loader').addClass('hidden');
                $btn.button('reset');
                ajaxErrorMessage(event, selector);
            }
        });
    });

    // Select A User's Car
    $(document).on("change", 'select#selected-user-car', function (evt) {
        evt.preventDefault();
        $('#booking-loader').removeClass('hidden');
        resizeJquerySteps();
        var trim_id = $(this).val();
        var selector = $(this);
        $.ajax({
            url: 'http://localhost/unclefitter/public/show-car-info/' + trim_id + '/1',
            type: 'GET',
            success: function (result) {
                $('#booking-loader').addClass('hidden');
                if (result.status) {
                    resizeJquerySteps();
                    if ($('.selected-car-step2').length) {
                        $('.selected-car-step2').html(result.car_info_view);
                        $("#example-form").children("div").steps("next");
                        $('#example-form .steps ul li.done').addClass('disabled');
                        resizeJquerySteps();
                    } else {
                        $("div.select_car").addClass('hidden');
                    }
                    $.ajax({
                        url: 'http://localhost/unclefitter/public/show-sub-services/' + result.service_id,
                        type: 'GET',
                        success: function (result) {
                            $('#booking-loader').addClass('hidden');
                            if (result && result != 0) {
                                resizeJquerySteps();
                                $('.services-container').addClass('hidden');
                                if ($(document).find('.sub-services-container').html().trim().length !== 0) {
                                    $(document).find('.next-step-button').remove();
                                    $('.sub-services-container').removeClass('hidden').append(result);
                                } else {
                                    $('.sub-services-container').removeClass('hidden').html(result);
                                }
                                $('.own-service-container').addClass('hidden');
                                $('.review-book-action-container').removeClass('hidden');
                                resizeJquerySteps();
                            } else if (result == 0) {
                                $('#error-msg').html("Sub-Service Not Exists!");
                            }
                        },
                        error: function (event) {
                            $('#booking-loader').addClass('hidden');
                            ajaxErrorMessage(event, selector);
                        }
                    });
                } else if (result && result != 0) {
                    resizeJquerySteps();
                    $('.selected-car-step2').html(result);
                    $("#example-form").children("div").steps("next");
                    $('#example-form .steps ul li.done').addClass('disabled');
                    resizeJquerySteps();
                } else if (result == 0) {
                    $('#error-msg').html("Car Info Not Exists!");
                }
            },
            error: function (event) {
                $('#booking-loader').addClass('hidden');
                ajaxErrorMessage(event, selector);
            }
        });
    });

    // Save Sub Service Option into Cookie    
    $(document).on("change", '.sub-service-option', function (evt) {
        evt.preventDefault();
        $('#booking-loader').removeClass('hidden');
        var action = 'add';
        var type = 1;
        if ($(this).attr('type') == 'radio') {
            var action = 'add';
        } else {
            if ($(this).prop('checked')) {
                var action = 'add';
            } else {
                var action = 'remove';
            }
            var type = 0;
        }

        var ss_option_id = $(this).val();
        var ss_id = $(this).attr('data-sub_service_id')
        var s_id = $(this).attr('data-service_id')
        var selector = $(this);
        $.ajax({
            url: 'http://localhost/unclefitter/public/save-option/' + s_id + '/' + ss_id + '/' + ss_option_id + '/' + action + '/' + type,
            type: 'GET',
            success: function (result) {
                var make_url = '/add-more-services';
                $.ajax({
                    url: make_url,
                    type: 'GET',
                    success: function (result) {
                        $('#booking-loader').addClass('hidden');
                        if (result && result != 0 && result.selected) {
                            resizeJquerySteps();
                            if (result.selected) {
                                $(".selected_services-container").removeClass('hidden').html('').html(result.selected);
                                if (own_service_description) {
                                    var li_html = "<li class='no--padding'><input checked='' disabled='' class='radio-custom car' type='radio'><label class='radio-custom-label' for='selected-car'>" + own_service_description + " <span class='pull-right'><a class='delete-custom-service'><img src='/web/img/dustbin.png'></a></span></label></li>";
                                    $(".selected_services_ul").append(li_html);
                                }
                                $(".selected_services_ul").append(review_button_html)
                            } else {
                                $(".selected_services-container").addClass('hidden')
                                if (own_service_description) {
                                    var ul_li_html = "<h1>Selected Services</h1><ul class='selected-car-step2 selected-car' style='padding-left: 0px !important;'><ul class='no--padding selected_services_ul' style='padding-left: 0px !important;'><li class='no--padding'><input checked='' disabled='' class='radio-custom car' type='radio'><label class='radio-custom-label' for='selected-car'>" + own_service_description + " <span class='pull-right'><a class='delete-custom-service'><img src='/web/img/dustbin.png'></a></span></label></li></ul></ul>";
                                    $(".selected_services-container").removeClass('hidden').html('').html(ul_li_html);
                                }
                                $(".selected_services_ul").append(review_button_html)
                            }
                            resizeJquerySteps();
                        } else if (result == 0) {
                            $('#error-msg').html("Sub-Service Not Exists!");
                        }
                    },
                    error: function (event) {
                        $('#booking-loader').addClass('hidden');
                        ajaxErrorMessage(event, selector);
                    }
                });
            },
            error: function (event) {
                $('#booking-loader').addClass('hidden');
                ajaxErrorMessage(event, selector);
            }
        });
    });

    // Add Own Service
    $(document).on("click", '.add-own-service', function (evt) {
        evt.preventDefault();
        $('#booking-loader').removeClass('hidden');
        resizeJquerySteps();
        $('.own-service-container').removeClass('hidden');
        $('.review-book-action-container').removeClass('hidden');
        resizeJquerySteps();
        $('#booking-loader').addClass('hidden');
    });

    // Select Service according to Service Type
    $(document).on("click", '.service-types-container .service-type-nav li a', function (evt) {
        evt.preventDefault();
        $('#booking-loader').removeClass('hidden');
        resizeJquerySteps();
        resizeServiceTab();
        resizeJquerySteps();
        resizeServiceTab();
        $('#booking-loader').addClass('hidden');
    });

    // Select a Diagnostics Service
    $(document).on("click", '.diagnostics-service', function (evt) {
        evt.preventDefault();
        $('#booking-loader').removeClass('hidden');
        resizeJquerySteps();
        resizeServiceTab();
        var service_id = $(this).data('id');
        var selector = $(this);
        $.ajax({
            url: 'http://localhost/unclefitter/public/show-diagnostics-sub-services/' + service_id,
            type: 'GET',
            success: function (result) {
                $('#booking-loader').addClass('hidden');
                if (result && result != 0) {
                    //resizeJquerySteps();
                    //resizeServiceTab();
                    $('.services-container').addClass('hidden');
                    if ($(document).find('.sub-services-container').html().trim().length !== 0) {
                        $(document).find('.next-step-button').remove();
                        $('.sub-services-container').removeClass('hidden').append(result);
                    } else {
                        $('.sub-services-container').removeClass('hidden').html(result);
                    }
                    //resizeJquerySteps();
                    //resizeServiceTab();
                } else if (result == 0) {
                    $('#error-msg').html("Sub-Service Not Exists!");
                }
            },
            error: function (event) {
                $('#booking-loader').addClass('hidden');
                ajaxErrorMessage(event, selector);
            }
        });
    });

    // Select a Diagnostics Service options
    $(document).on("change", '.diagnostics-sub-service-option', function (evt) {
        evt.preventDefault();
        $('#booking-loader').removeClass('hidden');
        resizeJquerySteps();
        resizeServiceTab();
        var sub_service_id = $(this).data('ss_id_ref');
        var service_id = $(this).data('service_id');
        var p_sub_service_id = $(this).data('sub_service_id');
        var sub_service_option = $(this).val();
        var service = "sub_service_" + sub_service_id;
        var parent = $(this).data('parent');
        var recommend_service_id = $(this).data('recommend_service_id');

        $('.recommended-service-link-container').remove();

        if (typeof p_sub_service_id !== 'undefined') {
            $(document).find('.next-sub-service' + p_sub_service_id).remove();
        }
        if (typeof sub_service_id !== 'undefined') {
            $(document).find('.next-sub-service' + sub_service_id).remove();
        }

        if (parent == '1') {
            $(document).find('.next-sub-service').remove();
        }

        var next_sub_service = sub_services_json[service];
        $(next_sub_service).each(function (index, value) {
            var title = '<p class="next-sub-service-name">' + value['sub_service_name']
                    + '<input class="next-sub-service-hidden" type="hidden" name="sub_service_id_' + service_id + '[]" value="' + value['sub_service_id'] + '">'
                    + '</p>';
            var desc = '<p><small class="next-sub-service-desc">' + unescape(value['sub_service_desc']) + '</small></p>';
            resizeJquerySteps();
            resizeServiceTab();
            var options = '';
            if (typeof value['sub_service_options'] !== 'undefined') {
                options = '<ul class="next-sub-service-option-lists sub-service-options-lists">';
                $(value['sub_service_options']).each(function (o_index, o_value) {
                    var recommend_service_id = (o_value['recommend_service_id'] && o_value['recommend_service_id'] != '' && o_value['recommend_service_id'] != null) ? o_value['recommend_service_id'] : '';
                    options += '<li class="col-md-3 col-sm-3 col-xs-4 no--padding sub-services-option">'
                            + '<input class="radio-custom diagnostics-sub-service-option" type="radio" value="' + o_value['option_id'] + '" '
                            + 'name="sub_service_option_' + sub_service_id + '[]"'
                            + 'id="sub_service_option' + sub_service_id + '' + o_index + '" '
                            + 'data-name="' + o_value['option_name'] + '" '
                            + 'data-ss_id_ref="' + o_value['sub_service_id_ref'] + '" data-service_id="' + service_id + '"'
                            + 'data-parent="0"'
                            + 'data-recommend_service_id="' + recommend_service_id + '"'
                            + 'data-sub_service_id="' + value['sub_service_id'] + '">'
                            + '<label class="radio-custom-label" for="sub_service_option' + sub_service_id + '' + o_index + '">' + o_value['option_name'] + '</label>'
                            + '</li>'
                });
                options += '</ul>';
            }
            var html = '<div class="front--rear sub-services-option-container next-sub-service next-sub-service' + p_sub_service_id + '">' + title + unescape(desc) + options + '</div>';

            // Recommended Service HTML Start
            var recommended_service_html = '';
            if (recommend_service_id != '' && recommend_service_id != null) {
                var rm_service_id = recommend_service_id;
                recommended_service_html = '<div class="recommended-service-link-container">';
                recommended_service_html += '<a data-id="' + rm_service_id + '" href="javascript:void(0);">Add Recommended Service</a>';
                recommended_service_html += '</div>';
            }

            if (options == '' && options.length == 0 && recommended_service_html == '' && recommended_service_html.length == 0) {
                recommended_service_html = '<div class="recommended-service-link-container">';
                recommended_service_html += '<a id="back-to-the-services" href="javascript:void(0);">Back</a>';
                recommended_service_html += '</div>';
            }
            // Recommended Service HTML End
            $('#booking-loader').addClass('hidden');

            $('.diagnostics-sub-services-container').append(html + recommended_service_html);
            resizeJquerySteps();
            resizeServiceTab();
        });
    });

    // Select a Diagnostics Service option image
    $(document).on("click", '.diagnostics-sub-service-option-img', function (evt) {
        evt.preventDefault();
        $('#booking-loader').removeClass('hidden');
        $(".sub-services-option-container .diagnostics-sub-service-option-img").removeClass("active");
        $(this).addClass("active");

        var sub_service_id = $(this).data('ss_id_ref');
        var service_id = $(this).data('service_id');
        var p_sub_service_id = $(this).data('sub_service_id');
        var sub_service_option = $(this).data('value');
        var service = "sub_service_" + sub_service_id;
        var parent = $(this).data('parent');
        var recommend_service_id = $(this).data('recommend_service_id');
        $('.recommended-service-link-container').remove();

        if (typeof p_sub_service_id !== 'undefined') {
            $(document).find('.next-sub-service' + p_sub_service_id).remove();
        }
        if (typeof sub_service_id !== 'undefined') {
            $(document).find('.next-sub-service' + sub_service_id).remove();
        }

        if (parent == '1') {
            $(document).find('.next-sub-service').remove();
        }

        var next_sub_service = sub_services_json[service];
        $(next_sub_service).each(function (index, value) {
            var title = '<p class="next-sub-service-name">' + value['sub_service_name']
                    + '<input class="next-sub-service-hidden" type="hidden" name="sub_service_id_' + service_id + '[]" value="' + value['sub_service_id'] + '">'
                    + '<input class="selected-sub-service-option-hidden" type="hidden" name="selected_sub_service_op_id" value="' + sub_service_option + '">'
                    + '</p>';
            var desc = '<p><small class="next-sub-service-desc">' + unescape(value['sub_service_desc']) + '</small></p>';
            var options = '';
            if (typeof value['sub_service_options'] !== 'undefined') {
                options = '<ul class="next-sub-service-option-lists sub-service-options-lists">';
                $(value['sub_service_options']).each(function (o_index, o_value) {
                    var recommend_service_id = (o_value['recommend_service_id'] && o_value['recommend_service_id'] != '' && o_value['recommend_service_id'] != null) ? o_value['recommend_service_id'] : '';

                    options += '<li class="col-md-3 col-sm-3 col-xs-4 no--padding sub-services-option">'
                            + '<input class="radio-custom diagnostics-sub-service-option" type="radio" value="' + o_value['option_id'] + '" '
                            + 'name="sub_service_option_' + sub_service_id + '[]"'
                            + 'id="sub_service_option' + sub_service_id + '' + o_index + '" '
                            + 'data-name="' + o_value['option_name'] + '" '
                            + 'data-ss_id_ref="' + o_value['sub_service_id_ref'] + '" data-service_id="' + service_id + '"'
                            + 'data-parent="0"'
                            + 'data-recommend_service_id="' + recommend_service_id + '"'
                            + 'data-sub_service_id="' + value['sub_service_id'] + '">'
                            + '<label class="radio-custom-label" for="sub_service_option' + sub_service_id + '' + o_index + '">' + o_value['option_name'] + '</label>'
                            + '</li>'
                });
                options += '</ul>';
            }
            var html = '<div class="front--rear sub-services-option-container next-sub-service next-sub-service' + p_sub_service_id + '">' + title + desc + options + '</div>';

            // Recommended Service HTML Start
            var recommended_service_html = '';
            if (recommend_service_id != '' && recommend_service_id != null) {
                var rm_service_id = recommend_service_id;
                recommended_service_html = '<div class="recommended-service-link-container">';
                recommended_service_html += '<a data-id="' + rm_service_id + '" href="javascript:void(0);">Add Recommended Service</a>';
                recommended_service_html += '</div>';
            }

            if (options == '' && options.length == 0 && recommended_service_html == '' && recommended_service_html.length == 0) {
                recommended_service_html = '<div class="recommended-service-link-container">';
                recommended_service_html += '<a id="back-to-the-services" href="javascript:void(0);">Back</a>';
                recommended_service_html += '</div>';
            }

            // Recommended Service HTML End
            $('#booking-loader').addClass('hidden');

            $('.diagnostics-sub-services-container').append(html + recommended_service_html);
            resizeJquerySteps();
            resizeServiceTab();
        });
    });

    // Select a recommended Service
    $(document).on("click", '.recommended-service-link-container a', function (evt) {
        resizeJquerySteps();
        $('#booking-loader').removeClass('hidden');
        evt.preventDefault();
        var service_ids = $(this).data('id');
        var selector = $(this);
        $.ajax({
            url: 'http://localhost/unclefitter/public/show-recommended-services/' + service_ids,
            type: 'GET',
            success: function (result) {
                $('#booking-loader').addClass('hidden');
                if (result && result != 0) {
                    resizeJquerySteps();
                    $('.review-book-action-container').removeClass('hidden');
                    $('.sub-services-container').addClass('hidden').html('');
                    $('.recommended-services-container').html('').removeClass('hidden').html(result);
                    resizeJquerySteps();
                } else if (result == 0) {
                    $('#error-msg').html("Sub-Service Not Exists!");
                }
            },
            error: function (event) {
                $('#booking-loader').addClass('hidden');
                ajaxErrorMessage(event, selector);
            }
        });
    });

    // Show a recommended Service
    $(document).on("click", '.show-recommended-service', function (evt) {
        evt.preventDefault();
        resizeJquerySteps();
        $('#booking-loader').removeClass('hidden');
        var service_ids = $(this).data('recommend_service_id');
        var selector = $(this);
        $.ajax({
            url: 'http://localhost/unclefitter/public/show-recommended-services/' + service_ids,
            type: 'GET',
            success: function (result) {
                $('#booking-loader').addClass('hidden');
                if (result && result != 0) {
                    resizeJquerySteps();
                    $('.services-container').addClass('hidden').html('');
                    $('.review-book-action-container').removeClass('hidden');
                    $('.recommended-services-container').html('').removeClass('hidden').html(result);
                    resizeJquerySteps();
                } else if (result == 0) {
                    $('#error-msg').html("Sub-Service Not Exists!");
                }
            },
            error: function (event) {
                $('#booking-loader').addClass('hidden');
                ajaxErrorMessage(event, selector);
            }
        });
    });

    // Resend Verification Code to the user's mobile number
    $(document).on("click", '#ResendVerificationCode', function (evt) {
        evt.preventDefault();
        $('#response-message').removeClass('alert-success').addClass('hidden').html('');
        $.ajax({
            url: 'http://localhost/unclefitter/public/resend-verification-code',
            type: 'GET',
            success: function (result) {
                if (result.status === 'success') {
                    $('#response-message').removeClass('hidden').addClass('alert-success').html('').html(result.message);
                } else {
                    $('#response-message').removeClass('alert-success').addClass('hidden').html('');
                }
            },
            error: function (event) {
                $('#response-message').removeClass('alert-success').addClass('hidden').html('');
            }
        });
    });

    // Resend Verification Code to the user's mobile number
    $(document).on("click", '#ResendOtpCode', function (evt) {
        evt.preventDefault();
        var mobile = $("input[name='mobile']").val()
        if (mobile == '' || mobile == null || mobile.length !== 10) {
            $(".add_message").html('')
            $('<div />', {
                'class': "alert alert-danger",
                html: '<strong>Mobile number should be 10 digit</strong>'
            }).appendTo(".add_message");
            return false;
        }
        var country_code = $("input[name='mobile_country_code']").val();
        if (country_code == '' || country_code == undefined || country_code == null) {
            country_code = $("#mobile_country_code").val();
        }
        $.ajax({
            url: 'http://localhost/unclefitter/public/re-send-otp',
            type: 'GET',
            data: {mobile: mobile, mobile_country_code: country_code},
            success: function (result) {
                $(".add_message").html('')
                $('<div />', {
                    'class': "alert alert-success",
                    html: '<strong>Verification code sent to your mobile number</strong>'
                }).appendTo(".add_message");
                if ($('div').hasClass('add_verification')) {
                    $('.add_verification').html('')
                    $('<div />', {
                        'class': "col-md-12 col-sm-12 log_email",
                        html: '<input type="text" name="verification_code" placeholder="verification code" required>'
                    }).appendTo(".add_verification");

                    $('.switch_button').html('');
                    $('<input />', {
                        type: 'submit',
                        name: 'submit',
                        value: 'Submit'
                    }).appendTo(".switch_button");

                    $('.resend-code').html('').append('Not receive yet? Please <a href="javascript:void(0);" id="ResendOtpCode">Re-send Verification Code</a>');
                }
            },
            error: function (event) {

            }
        });
    });

    // Verify User by Verification Code
    $(document).on("click", '#verify-user-container #verify', function (evt) {
        evt.preventDefault();
        $('#response-message').removeClass('alert-danger').removeClass('alert-success').addClass('hidden').html('');
        var verification_code = $('#verify-user-container #verification_code').val();
        var _token = $('#verify-user-container input[name="_token"]').val();
        $.ajax({
            url: 'http://localhost/unclefitter/public/verify-account',
            type: 'POST',
            data: {verification_code: verification_code, _token: _token, ajax_request: 1},
            success: function (result) {
                if (result.status === 'success') {
                    $('#already-user-container').addClass('hidden');
                    $('#new-user-container').addClass('hidden');
                    $('.select-action-row').addClass('hidden');
                    $('#verify-user-container').addClass('hidden');
                    $('#submit-quote-container').removeClass('hidden');
                    resizeJquerySteps();
                } else if (result.status === 'error') {
                    $('#response-message').removeClass('alert-success').removeClass('hidden').addClass('alert-danger').html('').html(result.message);
                    resizeJquerySteps();
                }
            },
            error: function (event) {
                $('#response-message').removeClass('alert-success').addClass('hidden').html('');
            }
        });
    });

    // Back to the services (Repair and Diagnostics)
    $(document).on('click', '#back-to-the-services', function () {
        resizeJquerySteps();
        var selector = $(this);
        $.ajax({
            url: 'http://localhost/unclefitter/public/delete-selected-services',
            type: 'GET',
            success: function (response, textStatus, request) {
                $('#booking-loader').addClass('hidden');
                $('.sub-services-container').html('').addClass('hidden');
                $('.recommended-services-container').addClass('hidden');
                $('.own-service-container').addClass('hidden');
                $('.review-book-action-container,.selected_services-container').addClass('hidden');
                own_service_description = '';
                $('.services-container').removeClass('hidden').html(response.show_services);
                resizeJquerySteps();
            },
            error: function (event) {
                $('#booking-loader').addClass('hidden');
                ajaxErrorMessage(event, selector);
            }
        });
    });

    $(document).on('click', 'a.view-service-description', function () {
        resizeJquerySteps();
        if ($('.view-service-description-div').hasClass('hidden')) {
            $('.view-service-description-div').delay(5000).removeClass('hidden');
            $(this).text('Hide Service Description');
        } else {
            $('.view-service-description-div').delay(5000).addClass('hidden');
            $(this).text('View Service Description');
        }
        resizeJquerySteps();
    });
});

$(document).ready(function () {

    $(document).on("click", "li[role='presentation'], li a[href='#tab2']", function (evt) {
        if ($(this).hasClass("category_custom_service_button")) {
            if (own_service_description) {
                $("#own_service_description").text(own_service_description)
                resizeJquerySteps();
                $("#add_custom_services_container").removeClass("hidden");
                resizeJquerySteps();
            }
            $.ajax({
                url: 'http://localhost/unclefitter/publicget-selected-services',
                success: function (result) {
                    $(".sub-services-container").html(result).addClass("hidden")
                }
            })
        } else {
            $("#add_custom_services_container").addClass("hidden");
        }
    })

    $(document).on("input", "#own_service_description", function (e) {
        resizeJquerySteps();
        if ($(this).val()) {
            if ($("#add_custom_services_container").hasClass("hidden")) {
                $("#add_custom_services_container").removeClass("hidden");
            }
        } else {
            $("#add_custom_services_container").addClass("hidden");
            own_service_description = ''
        }
        resizeJquerySteps();
    })

    $(document).on("click", "#selected_container_review_btn", function (evt) {
        $("#review-and-book").trigger("click")
    })

    $(document).on("keyup", 'input[name="search-service"]', function (event) {
        var search = $(this).val();
        $.ajax({
            url: 'http://localhost/unclefitter/public/search-services/broader/' + search,
            type: 'GET',
            success: function (response, textStatus, request) {
                $('#unclefitter-services').html(response);
            },
            error: function (event) {

            }
        });
    });

    $('#search-repair-services').on("keyup", function (event) {
        var search = $(this).val();
        $.ajax({
            url: 'http://localhost/unclefitter/public/search-services/repair/' + search,
            type: 'GET',
            success: function (response, textStatus, request) {
                if (search && search.length != 0) {
                    $('.service-category-nav').css('display', 'none');
                } else {
                    $('.service-category-nav').css('display', 'block');
                }
                $('#repaire-tab').html(response);
            },
            error: function (event) {

            }
        });
    });

    $('#search-diagnostic-services').on("keyup", function (event) {
        var search = $(this).val();
        $.ajax({
            url: 'http://localhost/unclefitter/public/search-services/diagnostic/' + search,
            type: 'GET',
            success: function (response, textStatus, request) {
                $('#diagnostics-tab').html(response);
            },
            error: function (event) {

            }
        });
    });

});
