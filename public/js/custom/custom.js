var car_model_id;
var car_trim_id;
var count = 0;
var countSec = 1;
$(document).ready(function () {
    $('#select_add_cars').select2();
    $('#add_car_select').select2();
    $('#update_car_select').select2();
    $('#add_year_select').select2();
    $('#update_year_select').select2();
})

function changeSelectParam() {
    $("#update_add_carmodel").select2().val(car_model_id).change();
}

function chnageSelectCartrim() {
    $('#select_update_cartrim').select2().val(car_trim_id).change();
}

/**
 *
 * Zip Code js
 *  
 **/
$('#form_add_zipcode').on("submit", function (evt) {
    evt.preventDefault();
    var url = $(this).attr('action');
    var formData = $(this).serialize();
    var selector = $(this);
    $.ajax({
        url: url,
        data: formData,
        type: 'POST',
        success: function (result) {
            $.ajax({
                url: currentUrl,
                success: function (zipCodes) {
                    $('#zip-code-table-container').html(zipCodes);
                }
            });
            ajaxSuccessMessage(result, selector);
        },
        error: function (event) {
            ajaxErrorMessage(event, selector);
        },
    });
});

/* Update zip code functionality */
$(document).on('click', 'button.update_zipcode', function () {
    var url = $(this).data('url');
    $('#form_update_zipcode').attr('action', url);
    $.ajax({
        url: url,
        type: 'get',
        success: function (data) {
            if (data['status'] == 'success') {
                var result = data['result'];
                $('#zipCode').val(result[0]['zip_code']);
                $('#countryCode').val(result[0]['country_code']);
                $('#serviceAvl').val(result[0]['service_availability']);
            }
        },
    });
});

$('#form_update_zipcode').on("submit", function (evt) {
    evt.preventDefault();
    var url = $(this).attr('action');
    var formData = $(this).serialize();
    var selector = $(this);
    $.ajax({
        url: url,
        data: formData,
        type: 'PUT',
        success: function (result) {
            $.ajax({
                url: currentUrl,
                success: function (zipCodes) {
                    $('#zip-code-table-container').html(zipCodes);
                }
            });
            ajaxSuccessMessage(result, selector);
        },
        error: function (event) {
            ajaxErrorMessage(event, selector);
        },
    });
});

/* Delete zip code functionality */
$(document).on('click', 'button.delete_zipcode', function () {
    var url = $(this).data('url');
    $('#form_delete_zipcode').attr('action', url);
});

$(document).on('submit', 'form#form_delete_zipcode', function (evt) {
    evt.preventDefault();
    var url = $(this).attr('action');
    var formData = $(this).serialize();
    var selector = $(this);
    $.ajax({
        url: url,
        data: formData,
        type: 'post',
        success: function (result) {
            $.ajax({
                url: currentUrl,
                success: function (zipCodes) {
                    $('#zip-code-table-container').html(zipCodes);
                }
            });
            ajaxSuccessMessage(result, selector);
        },
        error: function (event) {
            ajaxErrorMessage(event, selector);
        },
    });
});

/**
 *
 * Cars js
 *  
 **/

// Select multiple zip code -- Car services.

$('#form_add_car_service').on("submit", function (evt) {
    evt.preventDefault();
    var url = $(this).attr('action');
    var selector = $(this);
    var formData = new FormData($(this)[0]);
    $.ajax({
        url: url,
        data: formData,
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        success: function (result) {
            $.ajax({
                url: currentUrl,
                success: function (carServices) {
                    $('#car-services-table-container').html(carServices);
                }
            });
            ajaxSuccessMessage(result, selector);
        },
        error: function (event) {
            ajaxErrorMessage(event, selector);
        },
    });
});

/* Update car service functionality */
$(document).on('click', 'button.update_car_service', function () {
    var url = $(this).data('url');
    $('#form_update_car_service').attr('action', url);
    $.ajax({
        url: url,
        type: 'get',
        success: function (data) {
            if (data['status'] == 'success') {
                var result = data['result'];
                $('#carBrand').val(result.cars[0]['brand']);
                $('#carDescription').val(result.cars[0]['description']);
                $("#carImageUrl").val(result.cars[0]['image_url']);
            }
        },
    });
});

$(document).on("submit", 'form#form_update_car_service', function (evt) {
    evt.preventDefault();
    var url = $('#form_update_car_service').attr('action');
    var formData = new FormData($(this)[0]);
    var selector = $(this);
    $.ajax({
        url: url,
        data: formData,
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        success: function (result) {
            $.ajax({
                url: currentUrl,
                success: function (carServices) {
                    $('#car-services-table-container').html(carServices);
                }
            });
            ajaxSuccessMessage(result, selector);
        },
        error: function (event) {
            ajaxErrorMessage(event, selector);
        },
    });
});

/* Delete car service functionality */
$(document).on('click', 'button.delete_car_service', function () {
    var url = $(this).data('url');
    $('#form_delete_car_service').attr('action', url);
});

$(document).on('submit', 'form#form_delete_car_service', function (evt) {
    evt.preventDefault();
    var url = $(this).attr('action');
    var formData = $(this).serialize();
    var selector = $(this);
    $.ajax({
        url: url,
        data: formData,
        type: 'post',
        success: function (result) {
            $.ajax({
                url: currentUrl,
                success: function (carServices) {
                    $('#car-services-table-container').html(carServices);
                }
            });
            ajaxSuccessMessage(result, selector);
        },
        error: function (event) {
            ajaxErrorMessage(event, selector);
        },
    });
});

/**
 *
 * Year Services js
 *  
 **/

$('#form_add_year').on("submit", function (evt) {
    evt.preventDefault();
    var url = $(this).attr('action');
    var formData = $(this).serialize();
    var selector = $(this);
    $.ajax({
        url: url,
        data: formData,
        type: 'POST',
        success: function (result) {
            $.ajax({
                url: currentUrl,
                success: function (responseYear) {
                    $('#year-table-container').html(responseYear);
                }
            });
            ajaxSuccessMessage(result, selector);
        },
        error: function (event) {
            ajaxErrorMessage(event, selector);
        },
    });
});

/* Update year functionality */
$(document).on('click', 'button.update_year', function () {
    var url = $(this).data('url');
    $('#form_update_year').attr('action', url);
    $.ajax({
        url: url,
        type: 'get',
        success: function (data) {
            if (data.status == 'success') {
                $('#update_car_select').select2().val(data.result[0]['car_id']).change();
                $('#update_year_select').select2().val(data.result[0]['year']).change();
            }
        },
    });

});

$(document).on("submit", '#form_update_year', function (evt) {
    evt.preventDefault();
    var url = $(this).attr('action');
    var formData = $(this).serialize();
    var selector = $(this);
    $.ajax({
        url: url,
        data: formData,
        type: 'POST',
        success: function (result) {
            $.ajax({
                url: currentUrl,
                success: function (responseYear) {
                    $('#year-table-container').html(responseYear);
                }
            });
            ajaxSuccessMessage(result, selector);
        },
        error: function (event) {
            ajaxErrorMessage(event, selector);
        },
    });
});

/* Delete year functionality */
$(document).on('click', 'button.delete_year', function () {
    var url = $(this).data('url');
    $('#form_delete_year').attr('action', url);
});

$(document).on('submit', '#form_delete_year', function (evt) {
    evt.preventDefault();
    var url = $(this).attr('action');
    var formData = $(this).serialize();
    var selector = $(this);
    $.ajax({
        url: url,
        data: formData,
        type: 'post',
        success: function (result) {
            $.ajax({
                url: currentUrl,
                success: function (carModal) {
                    $('#year-table-container').html(carModal);
                }
            });
            ajaxSuccessMessage(result, selector);
        },
        error: function (event) {
            ajaxErrorMessage(event, selector);
        },
    });
});

/**
 *
 * Carmodal Services js
 *  
 **/

$(document).ready(function () {
    $('#select_add_carmodel').select2();
    $('#select_update_carmodel').select2();

    /* Add years functionality */
    $('#form_add_carmodel').on("submit", function (evt) {
        evt.preventDefault();
        var url = $(this).attr('action');
        var formData = $(this).serialize();
        var selector = $(this);
        $.ajax({
            url: url,
            data: formData,
            type: 'POST',
            success: function (result) {
                $.ajax({
                    url: currentUrl,
                    success: function (carModal) {
                        $('#carmodel-table-container').html(carModal);
                    }
                });
                ajaxSuccessMessage(result, selector);
            },
            error: function (event) {
                ajaxErrorMessage(event, selector);
            },
        });
    });

    /* Update car model functionality */
    $(document).on('click', 'button.update_carmodel', function () {
        var url = $(this).data('url');
        $('#form_update_carmodel').attr('action', url);
        $("#select_update_carmodel").val("").change();
        $("#select_update_carmodel").html("");
        $.ajax({
            url: url,
            type: 'get',
            success: function (data) {
                if (data.status == 'success') {
                    var result = data.result;
                    $('#modalName').val(result.carmodel[0]['modal_name']);
                    $('#select_update_cars').val(result.cars['id']).change();
                    $("#select_update_carmodel").select2().append("<option value=" + result.year['id'] + ">" + result.year['year'] + "</option>");
                    $('#select_update_carmodel').val(result.carmodel[0]['year_id']).trigger('change');
                }
            },
        });
    });

    // Append years on car changes
    $('#select_update_cars').select2().on('change', function () {
        var url = $(this).attr("url");
        if ($(this).val() == "") {
            $("#select_update_carmodel").val("").change();
            $("#select_update_carmodel").html("");
            return;
        }
        $.ajax({
            url: url + "/" + $(this).val(),
            data: {},
            type: 'get',
            success: function (data) {
                if (data.status == 'success') {
                    var result = data.result;
                    for (var i = 0; i <= result.length - 1; i++) {
                        $("#select_update_carmodel").select2().append("<option value=" + result[i]['id'] + ">" + result[i]['year'] + "</option>");
                    }
                }
            },
            error: function (event) {
                $("#select_update_carmodel").select2().append("<option value=''>Select Year</option>");
            }
        });
    });

    $(document).on("submit", '#form_update_carmodel', function (evt) {
        evt.preventDefault();
        var url = $(this).attr('action');
        var formData = $(this).serialize();
        var selector = $(this);
        $.ajax({
            url: url,
            data: formData,
            type: 'PUT',
            success: function (result) {
                $.ajax({
                    url: currentUrl,
                    success: function (carModal) {
                        $('#carmodel-table-container').html(carModal);
                    }
                });
                ajaxSuccessMessage(result, selector);
            },
            error: function (event) {
                ajaxErrorMessage(event, selector);
            },
        });
    });

    /* Delete carmodel functionality */
    $(document).on('click', 'button.delete_carmodel', function () {
        var url = $(this).data('url');
        $('#form_delete_carmodel').attr('action', url);
    });

    $(document).on('submit', '#form_delete_carmodel', function (evt) {
        evt.preventDefault();
        var url = $(this).attr('action');
        var formData = $(this).serialize();
        var selector = $(this);
        $.ajax({
            url: url,
            data: formData,
            type: 'post',
            success: function (result) {
                $.ajax({
                    url: currentUrl,
                    success: function (carModal) {
                        $('#carmodel-table-container').html(carModal);
                    }
                });
                ajaxSuccessMessage(result, selector);
            },
            error: function (event) {
                ajaxErrorMessage(event, selector);
            },
        });
    });

    $("#select_add_carmodel,#update_add_carmodel").select2().on("change", function () {
        if ($(this).val() == "" || $(this).val() == null || $(this).val() == undefined) {
            $("#select_add_cartrim,#select_update_cartrim").val("").change();
            $("#select_add_cartrim,#select_update_cartrim").html("");
            return;
        }
        count++;
        var url = $(this).attr("url");
        $("#select_add_cartrim,#select_update_cartrim").html("");
        $.ajax({
            url: url + "/" + $(this).val(),
            data: {},
            type: 'get',
            success: function (data) {
                if (data.status == 'success') {
                    var result = data.result;
                    for (var i = 0; i <= result.length - 1; i++) {
                        $("#select_add_cartrim,#select_update_cartrim").select2().append("<option value=" + result[i]['id'] + ">" + result[i]['modal_name'] + "</option>");
                    }
                    if ($("#update_cartrim_modal").hasClass("in") && count === 2) {
                        changeSelectParam();
                    } else if (count === 3) {
                        chnageSelectCartrim();
                        if (countSec === 2) {
                            count = 0;
                            return countSec = 1;
                        } else {
                            return countSec++;
                        }
                    }
                }
            },
            error: function (event) {
                //$("#select_add_carmodel").select2().append("<option value=''>Select Model</option>");
            }
        });
    })

    $('#select_add_cars,#update_add_cars').select2().on('change', function () {
        if ($(this).val() == "") {
            $("#select_add_carmodel,#update_add_carmodel").val("").change();
            $("#select_add_carmodel,#update_add_carmodel").html("");
            return;
        }
        var url = $(this).attr("url");
        $("#select_add_carmodel,#update_add_carmodel").html("");
        $.ajax({
            url: url + "/" + $(this).val(),
            data: {},
            type: 'get',
            success: function (data) {
                if (data.status == 'success') {
                    var result = data.result;
                    for (var i = 0; i <= result.length - 1; i++) {
                        $("#select_add_carmodel,#update_add_carmodel").select2().append("<option value=" + result[i]['id'] + ">" + result[i]['year'] + "</option>");
                    }
                    $("#select_add_carmodel,#update_add_carmodel").select2().change()
                }
            },
            error: function (event) {
                $("#select_add_carmodel").select2().append("<option value=''>Select Year</option>");
            }
        });
    });
});

// Update cartrim functionality
$(document).on('click', 'button.update_cartrim', function (e) {
    var url = $(this).data('url');
    $('#form_update_cartrim').attr('action', url);
    $.ajax({
        url: url,
        type: 'get',
        success: function (result) {
            if (result.status == 'success') {
                car_model_id = result.car_data.year_id;
                car_trim_id = result.car_data.modal_id;
                $('#update_add_cars').select2().val(result.car_data.car_id).change();
                $('#car_trim').val(result.result[0]['car_trim_name']);
            }
        }
    });
});

/**
 * 
 * Cartrim js
 * 
 **/
$(document).ready(function () {

    $('#select_add_cartrim').select2();
    $('#select_update_cartrim').select2();

    //Add cartrim functionality
    $('#form_add_cartrim').on('submit', function (evt) {
        evt.preventDefault();
        var url = $(this).attr('action');
        var formData = $(this).serialize();
        var selector = $(this);
        $.ajax({
            url: url,
            data: formData,
            type: 'post',
            success: function (result) {
                $.ajax({
                    url: currentUrl,
                    success: function (carTrim) {
                        $('#cartrim-table-container').html(carTrim);
                    }
                });
                ajaxSuccessMessage(result, selector);
            },
            error: function (event) {
                ajaxErrorMessage(event, selector);
            },
        });
    });

    $(document).on('submit', '#form_update_cartrim', function (evt) {
        evt.preventDefault();
        var url = $(this).attr('action');
        var formData = $(this).serialize();
        var selector = $(this);
        $.ajax({
            url: url,
            data: formData,
            type: 'post',
            success: function (result) {
                $.ajax({
                    url: currentUrl,
                    success: function (carTrim) {
                        $('#cartrim-table-container').html(carTrim);
                    }
                });
                ajaxSuccessMessage(result, selector);
            },
            error: function (event) {
                ajaxErrorMessage(event, selector);
            },
        });
    });

    // Delete cartrim functionality
    $(document).on('click', 'button.delete_cartrim', function () {
        var url = $(this).data('url');
        $('#form_delete_cartrim').attr('action', url);
    });

    $(document).on('submit', 'form#form_delete_cartrim', function (evt) {
        evt.preventDefault();
        var url = $(this).attr('action');
        var formData = $(this).serialize();
        var selector = $(this);
        $.ajax({
            url: url,
            data: formData,
            type: 'post',
            success: function (result) {
                $.ajax({
                    url: currentUrl,
                    success: function (carTrim) {
                        $('#cartrim-table-container').html(carTrim);
                    }
                });
                ajaxSuccessMessage(result, selector);
            },
            error: function (event) {
                ajaxErrorMessage(event, selector);
            }
        });
    });
});

/**
 * 
 * Servicetype js 
 * 
 **/
$(document).ready(function () {
    //Add service type functionality
    $('#form_add_service_type').on('submit', function (evt) {
        evt.preventDefault();
        var url = $(this).attr('action');
        var formData = $(this).serialize();
        var selector = $(this);
        $.ajax({
            url: url,
            data: formData,
            type: 'post',
            success: function (result) {
                $.ajax({
                    url: currentUrl,
                    success: function (serviceType) {
                        $('#service-type-table-container').html(serviceType);
                    }
                });
                ajaxSuccessMessage(result, selector);
            },
            error: function (event) {
                ajaxErrorMessage(event, selector);
            },
        });
    });

    // Update service type functionality
    $(document).on('click', 'button.update_service_type', function () {
        var url = $(this).data('url');
        $('#form_update_service_type').attr('action', url);
        $.ajax({
            url: url,
            type: 'get',
            success: function (result) {
                if (result.status == 'success') {
                    $('#update_service_type').val(result.result[0]['service_type']);
                }
            }
        });
    });

    $(document).on('submit', 'form#form_update_service_type', function (evt) {
        evt.preventDefault();
        var url = $(this).attr('action');
        var formData = $(this).serialize();
        var selector = $(this);
        $.ajax({
            url: url,
            data: formData,
            type: 'post',
            success: function (result) {
                $.ajax({
                    url: currentUrl,
                    success: function (serviceType) {
                        $('#service-type-table-container').html(serviceType);
                    }
                });
                ajaxSuccessMessage(result, selector);
            },
            error: function (event) {
                ajaxErrorMessage(event, selector);
            }
        });
    });

    // Delete service type functionality
    $(document).on('click', 'button.delete_service_type', function () {
        var url = $(this).data('url');
        $('#form_delete_service_type').attr('action', url);
    });

    $(document).on('submit', '#form_delete_service_type', function (evt) {
        evt.preventDefault();
        var url = $(this).attr('action');
        var formData = $(this).serialize();
        var selector = $(this);
        $.ajax({
            url: url,
            data: formData,
            type: 'post',
            success: function (result) {
                $.ajax({
                    url: currentUrl,
                    success: function (serviceType) {
                        $('#service-type-table-container').html(serviceType);
                    }
                });
                ajaxSuccessMessage(result, selector);
            },
            error: function (event) {
                ajaxErrorMessage(event, selector);
            }
        });
    });
});

/**
 * 
 * Services js
 * 
 **/

function prepareEditorData() {
    $('textarea.editor').each(function () {
        var id = $(this).attr('id'),
                form = this.form;
        CKEDITOR.instances[id].on('beforeCommandExec', function (event) {
            if (event.data.name === 'save') {
                event.cancel();
                $(form).submit();
            }
        });
    });
}

$(document).ready(function () {

    $('#select_add_category').select2();
    $('#select_update_category').select2();

    //Add service functionality
    $('#form_add_service').on('submit', function (evt) {
        evt.preventDefault();
        //var desc = CKEDITOR.instances['description'].getData();
        var url = $(this).attr('action');
        var formData = $(this).serialize();
        var selector = $(this);
        $.ajax({
            url: url,
            data: formData,
            type: 'POST',
            cache: false,
            //processData: false,
            //contentType: false,
            success: function (result) {
                $.ajax({
                    url: currentUrl,
                    success: function (services) {
                        $('#service-table-container').html(services);
                    }
                });
                ajaxSuccessMessage(result, selector);
            },
            error: function (event) {
                ajaxErrorMessage(event, selector);
            },
        });
    });

    // Update service functionality
    $(document).on('click', 'button.update_service', function () {
        var url = $(this).attr('url');
        $('#form_update_service').attr('action', url);
        $.ajax({
            url: url,
            type: 'get',
            success: function (result) {
                if (result.status == 'success') {
                    var result = result.result;
                    if (result[0]['category_id'] === 2) {
                        if (result[0]['recommend_service_id'] !== '' || result[0]['recommend_service_id'] !== null) {
                            var data = result[0]['recommend_service_id'];
                            //Make an array
                            var data_array = data.split(",");
                            // Set the value
                            $('#update_service_modal .recommend_service_id').removeClass('hidden');
                            $("#update_service_modal select#recommend_service_id").val(data_array).change().prop("selected", true);
                        } else {
                            $('#update_service_modal .recommend_service_id').addClass('hidden');
                            $('#update_service_modal select#recommend_service_id').prop('selectedIndex', 0);
                        }
                    } else {
                        $('#update_service_modal .recommend_service_id').addClass('hidden');
                        $('#update_service_modal select#recommend_service_id').prop('selectedIndex', 0);
                    }
                    $('#select_update_category').select2().val(result[0]['category_id']).change().prop("selected", true);
                    $('#service_title').val(result[0]['title']);
                    $('#service_desc').val(unescape(result[0]['description']));
                    $("#update_service_modal select#recommend_service_id").multiselect("refresh");
                }
            }
        });
    });

    $(document).on('submit', 'form#form_update_service', function (evt) {
        evt.preventDefault();
        var url = $(this).attr('action');
        var formData = $(this).serialize();
        var selector = $(this);
        $.ajax({
            url: url,
            data: formData,
            type: 'POST',
            cache: false,
            //processData: false,
            //contentType: false,
            success: function (result) {
                $.ajax({
                    url: currentUrl,
                    success: function (services) {
                        $('#service-table-container').html(services);
                    }
                });
                ajaxSuccessMessage(result, selector);
            },
            error: function (event) {
                ajaxErrorMessage(event, selector);
            },
        });
    });

    // Delete service functionality
    $(document).on('click', 'button.delete_service', function () {
        var url = $(this).attr('url');
        $('#form_delete_service').attr('action', url);
    });

    $(document).on('submit', 'form#form_delete_service', function (evt) {
        evt.preventDefault();
        var url = $(this).attr('action');
        var formData = $(this).serialize();
        var selector = $(this);
        $.ajax({
            url: url,
            data: formData,
            type: 'post',
            success: function (result) {
                $.ajax({
                    url: currentUrl,
                    success: function (services) {
                        $('#service-table-container').html(services);
                    }
                });
                ajaxSuccessMessage(result, selector);
            },
            error: function (event) {
                ajaxErrorMessage(event, selector);
            }
        });
    });
});

/**
 * 
 * Sub services js
 * 
 **/
$(document).ready(function () {

    $('#select_add_service').select2();
    $('#select_update_service').select2();

    //Add sub-service type functionality
    $('#form_add_sub_service').on('submit', function (evt) {
        evt.preventDefault();
        var url = $(this).attr('action');
        var formData = $(this).serialize();
        var selector = $(this);
        $.ajax({
            url: url,
            data: formData,
            type: 'post',
            cache: false,
            //processData: false,
            //contentType: false,
            success: function (result) {
                $.ajax({
                    url: currentUrl,
                    success: function (subServices) {
                        $('#sub-services-table-container').html(subServices);
                    }
                });
                ajaxSuccessMessage(result, selector);
            },
            error: function (event) {
                ajaxErrorMessage(event, selector);
            },
        });
    });

    // Update aub-service functionality
    $(document).on('click', 'button.update_sub_service', function () {
        var url = $(this).attr('url');
        $('#form_update_sub_service').attr('action', url);
        $.ajax({
            url: url,
            type: 'get',
            success: function (data) {
                if (data.status == 'success') {
                    var result = data.result;
                    $('#select_update_service').select2().val(result[0]['service_id']).change();
                    $('#title_sub_service').val(result[0]['title']);
                    $('#display_text_sub_service').val(result[0]['display_text']);
                    $('#des_sub_service').val(unescape(result[0]['description']));
                    $('#order_sub_service').val(result[0]['order']);
                    $('#selection_type_sub_service').val(result[0]['selection_type']);
                    if (result[0]['optional'] === 1) {
                        $('#form_update_sub_service input[name="optional"]').attr('checked', true);
                    } else {
                        $('#form_update_sub_service input[name="optional"]').attr('checked', false);
                    }
                }
            }
        });
    });

    $('#form_update_sub_service').on('submit', function (evt) {
        evt.preventDefault();
        var url = $(this).attr('action');
        var formData = $(this).serialize();
        var selector = $(this);
        $.ajax({
            url: url,
            data: formData,
            type: 'post',
            cache: false,
            //processData: false,
            //contentType: false,
            success: function (result) {
                $.ajax({
                    url: currentUrl,
                    success: function (subServices) {
                        $('#sub-services-table-container').html(subServices);
                    }
                });
                ajaxSuccessMessage(result, selector);
            },
            error: function (event) {
                ajaxErrorMessage(event, selector);
            },
        });
    });

    // Delete sub-service type functionality
    $(document).on('click', 'button.delete_sub_service', function () {
        var url = $(this).attr('url');
        $('#form_delete_sub_service').attr('action', url);
    });

    $('#form_delete_sub_service').on('submit', function (evt) {
        evt.preventDefault();
        var url = $(this).attr('action');
        var formData = $(this).serialize();
        var selector = $(this);
        $.ajax({
            url: url,
            data: formData,
            type: 'post',
            success: function (result) {
                $.ajax({
                    url: currentUrl,
                    success: function (subServices) {
                        $('#sub-services-table-container').html(subServices);
                    }
                });
                ajaxSuccessMessage(result, selector);
            },
            error: function (event) {
                ajaxErrorMessage(event, selector);
            }
        });
    });
});

/**
 * 
 * Sub services options js
 * 
 **/
$(document).ready(function () {

    $('#select_add_subservice_opt').select2();
    $('#select_update_subservice_opt').select2();
    $('#add_sub_service_opt_modal #select_next_subservice').select2();
    $('#update_sub_service_opt_modal select#select_next_subservice').select2();

    //Add sub services options functionality
    $('#form_add_sub_service_opt').on('submit', function (evt) {
        evt.preventDefault();
        var url = $(this).attr('action');
        var formData = $(this).serialize();
        var selector = $(this);
        $.ajax({
            url: url,
            data: formData,
            type: 'POST',
            cache: false,
            //processData: false,
            //contentType: false,
            success: function (result) {
                $.ajax({
                    url: currentUrl,
                    success: function (subServicesOpt) {
                        $('#sub-services-opt-table-container').html(subServicesOpt);
                    }
                });
                ajaxSuccessMessage(result, selector);
            },
            error: function (event) {
                ajaxErrorMessage(event, selector);
            },
        });
    });

    // Update service type functionality
    $(document).on('click', 'button.update_sub_service_opt', function () {
        var url = $(this).attr('url');
        $('#form_update_sub_service_opt').attr('action', url);
        $.ajax({
            url: url,
            type: 'get',
            success: function (data) {
                if (data.status == 'success') {
                    var result = data.result;
                    $('#select_update_subservice_opt').select2().val(result[0]['sub_service_id']).change().prop("selected", true);
                    $('#sub_service_opt_name').val(result[0]['option_name']);
                    $('#sub_service_opt_desc').val(unescape(result[0]['option_description']));
                    $('#sub_service_opt_order').val(result[0]['option_order']);
                    $('#select_update_next_subservice').val(result[0]['sub_service_id_ref']).change().prop("selected", true);

                    $('#update_sub_service_opt_modal .option_image').addClass('hidden');
                    if (result[0]['option_type'] == '2') {
                        $("#update_sub_service_opt_modal select#option_type").val(result[0]['option_type']).change().prop("selected", true);
                        $('#update_sub_service_opt_modal .option_image').removeClass('hidden');
                    } else {
                        $("#update_sub_service_opt_modal select#option_type").val(result[0]['option_type']).change().prop("selected", true);
                        $('#update_sub_service_opt_modal .option_image').addClass('hidden');
                    }
                    if (result[0]['recommend_service_id'] !== '' || result[0]['recommend_service_id'] !== null) {
                        var data = result[0]['recommend_service_id'];
                        //Make an array
                        var data_array = data.split(",");
                        // Set the value
                        $("#update_sub_service_opt_modal select#recommend_service_id").val(data_array).change().prop("selected", true);
                    } else {
                        $('#update_sub_service_opt_modal select#recommend_service_id').prop('selectedIndex', 0);
                    }
                    $("#update_sub_service_opt_modal select#recommend_service_id").multiselect("refresh");
                }
            }
        });
    });

    $('#form_update_sub_service_opt').on('submit', function (evt) {
        evt.preventDefault();
        var url = $(this).attr('action');
        var formData = $(this).serialize();
        var selector = $(this);
        $.ajax({
            url: url,
            data: formData,
            type: 'post',
            cache: false,
            //processData: false,
            //contentType: false,
            success: function (result) {
                $.ajax({
                    url: currentUrl,
                    success: function (subServicesOpt) {
                        $('#sub-services-opt-table-container').html(subServicesOpt);
                    }
                });
                ajaxSuccessMessage(result, selector);
            },
            error: function (event) {
                ajaxErrorMessage(event, selector);
            }
        });
    });

    // Delete service type functionality
    $(document).on('click', 'button.delete_sub_service_opt', function () {
        var url = $(this).attr('url');
        $('#form_delete_sub_service_opt').attr('action', url);
    });

    $('#form_delete_sub_service_opt').on('submit', function (evt) {
        evt.preventDefault();
        var url = $(this).attr('action');
        var formData = $(this).serialize();
        var selector = $(this);
        $.ajax({
            url: url,
            data: formData,
            type: 'post',
            success: function (result) {
                $.ajax({
                    url: currentUrl,
                    success: function (subServicesOpt) {
                        $('#sub-services-opt-table-container').html(subServicesOpt);
                    }
                });
                ajaxSuccessMessage(result, selector);
            },
            error: function (event) {
                ajaxErrorMessage(event, selector);
            }
        });
    });
});

/**
 * 
 * Categories js 
 * 
 */
$(document).ready(function () {

    $('#select_add_service_type').select2();
    $('#select_update_service_type').select2();

    //Add category functionality
    $('#form_add_category').on('submit', function (evt) {
        evt.preventDefault();
        var url = $(this).attr('action');
        var formData = $(this).serialize();
        var selector = $(this);
        $.ajax({
            url: url,
            data: formData,
            type: 'post',
            success: function (result) {
                $.ajax({
                    url: currentUrl,
                    success: function (category) {
                        $('#category-table-container').html(category);
                    }
                });
                ajaxSuccessMessage(result, selector);
            },
            error: function (event) {
                ajaxErrorMessage(event, selector);
            }
        });
    });

    // Update category functionality
    $(document).on('click', 'button.update_category', function () {
        var url = $(this).attr('url');
        $('#form_update_category').attr('action', url);
        $.ajax({
            url: url,
            type: 'get',
            success: function (data) {
                if (data.status == 'success') {
                    var result = data.result;
                    $('#category').val(result[0]['category_name']);
                    $('#select_update_service_type').select2().val(result[0]['service_type_id']).change();
                }
            }
        });
    });

    $('#form_update_category').on('submit', function (evt) {
        evt.preventDefault();
        var url = $(this).attr('action');
        var formData = $(this).serialize();
        var selector = $(this);
        $.ajax({
            url: url,
            data: formData,
            type: 'post',
            success: function (result) {
                $.ajax({
                    url: currentUrl,
                    success: function (category) {
                        $('#category-table-container').html(category);
                    }
                });
                ajaxSuccessMessage(result, selector);
            },
            error: function (event) {
                ajaxErrorMessage(event, selector);
            },
        });
    });

    // Delete category functionality
    $(document).on('click', 'button.delete_category', function () {
        var url = $(this).attr('url');
        $('#form_delete_category').attr('action', url);
    });

    $('#form_delete_category').on('submit', function (evt) {
        evt.preventDefault();
        var url = $(this).attr('action');
        var formData = $(this).serialize();
        var selector = $(this);
        $.ajax({
            url: url,
            data: formData,
            type: 'post',
            success: function (result) {
                $.ajax({
                    url: currentUrl,
                    success: function (category) {
                        $('#category-table-container').html(category);
                    }
                });
                ajaxSuccessMessage(result, selector);
            },
            error: function (event) {
                ajaxErrorMessage(event, selector);
            }
        });
    });
});

/**
 * 
 * User profile js
 * 
 */
$(document).ready(function () {
    $('#edit_profile').on('click', function () {
        $('#user_profile_div').css('display', 'none');
        $("#change_password_form").css('display', 'none');
        $('#edit_profile_form').css('display', 'block');
    });

    $('#change_password').on('click', function () {
        $('#user_profile_div').css('display', 'none');
        $('#edit_profile_form').css('display', 'none');
        $("#change_password_form").css('display', 'block');
    });

    // Admin Edit profile form
    var mobile = $(this).find('input[name="mobile"]');
    var oldMobile = mobile.val();
    $('#edit_profile_form,#user_profile_form').on('submit', function (evt) {
        evt.preventDefault();
        var url = $(this).attr('action');
        var formData = $(this).serialize();
        var selector = $(this);
        $.ajax({
            url: url,
            data: formData,
            type: 'post',
            success: function (result) {
                $("span.help-block").html();
                var mobileVal = mobile.val();
                if (mobileVal !== oldMobile) {
                    var url = $('.welcome_path').attr('data-welcome_path');
                    window.location.replace(url);
                }
                ajaxSuccessMessage(result, selector);
            },
            error: function (event) {
                ajaxErrorMessage(event, selector);
            }
        });
    });
    // Admin Change password form
    $('#change_password_form,#user_change_password_form').on('submit', function (evt) {
        evt.preventDefault();
        var url = $(this).attr('action');
        var formData = $(this).serialize();
        var selector = $(this);
        $.ajax({
            url: url,
            data: formData,
            type: 'post',
            success: function (result) {
                if (result.status == "success") {
                    if ($("form").hasClass("user-form")) {
                        $("#user_change_password_form")[0].reset();
                    } else {
                        $("#change_password_form")[0].reset();
                    }
                    ajaxSuccessMessage(result, selector)
                } else {
                    $("span#old_password").html(result.password).addClass("help-block");
                    $("div.old_password").addClass("has-error");
                }
            },
            error: function (event) {
                ajaxErrorMessage(event, selector);
            }
        });
    });

    // Allow only number validation for mobile no. 
    $("input.phone-no").keypress(function (e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
        }
    });
});

/**
 * 
 * User management functionality
 * 
 */

// Delete User functionality
$(document).on('click', 'button.delete_user', function () {
    var url = $(this).data('url');
    $('#form_delete_user').attr('action', url);
});

$("#form_delete_user").on("submit", function (evt) {
    evt.preventDefault();
    var url = $(this).attr('action');
    var formData = $(this).serialize();
    var selector = $(this);
    $.ajax({
        url: url,
        data: formData,
        type: 'post',
        success: function (result) {
            $.ajax({
                url: currentUrl,
                success: function (user) {
                    $('#user-table-container').html(user);
                }
            });
            ajaxSuccessMessage(result, selector);
        },
        error: function (event) {
            ajaxErrorMessage(event, selector);
        }
    });
});

// Update user functionality
$(document).on('click', 'button.update_user', function () {
    var url = $(this).data('url');
    $('#form_update_user').attr('action', url);
    $.ajax({
        url: url,
        type: 'get',
        success: function (data) {
            if (data.status == 'success') {
                var result = data.result;
                $('#user_email').val(result.email);
                $('#user_name').val(result.name);
                $('#user_phone').val(result.mobile);
            }
        }
    });
});

$(document).on('submit', '#form_update_user', function (evt) {
    evt.preventDefault();
    var url = $(this).attr('action');
    console.log(url);
    //var formData = $(this).serialize();
    var selector = $(this);
    $.ajax({
        url: url, // Url to which the request is send
        type: "POST", // Type of request to be send, called as method
        data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
        contentType: false, // The content type used when sending data to the server.
        cache: false, // To unable request pages to be cached
        processData: false, // To send DOMDocument or non processed data file it is set to false
        success: function (result) {
            $.ajax({
                url: currentUrl,
                success: function (user) {
                    $('#user-table-container').html(user);
                }
            });
            ajaxSuccessMessage(result, selector);
        },
        error: function (event) {
            ajaxErrorMessage(event, selector);
        },
    });
});

// User address functionality
$(document).on('click', 'button.delete_address', function () {
    $('form#delete_user_address_form').attr('action', $(this).data('url'));
});

// Delete user address functionality
$(document).on("submit", '#delete_user_address_form', function (evt) {
    evt.preventDefault();
    var url = $(this).attr('action');
    var formData = $(this).serialize();
    var selector = $(this);
    $.ajax({
        url: url,
        data: formData,
        type: 'post',
        success: function (result) {
            $.ajax({
                url: currentUrl,
                data: {"address": true},
                success: function (userAdd) {
                    $("#user-address-container").html(userAdd);
                },
            });
            ajaxSuccessMessage(result, selector);
        },
        error: function (event) {
            ajaxErrorMessage(event, selector);
        },
    });
});

// User add address form
$(document).on("submit", '#user_add_address_form', function (evt) {
    evt.preventDefault();
    var url = $(this).attr('action');
    var formData = $(this).serialize();
    var selector = $(this);
    $.ajax({
        url: url,
        data: formData,
        type: 'post',
        success: function (result) {
            $.ajax({
                url: currentUrl,
                data: {"address": true},
                success: function (userAdd) {
                    $("#user-address-container").html(userAdd);
                },
            });
            ajaxSuccessMessage(result, selector);
        },
        error: function (event) {
            ajaxErrorMessage(event, selector);
        },
    });
});

$(document).on("click", "button.update_address", function () {
    var url = $(this).data("url");
    $("#user_update_address_form").attr("action", url);
    $.ajax({
        url: url,
        method: 'get',
        success: function (data) {
            if (data.status == "success") {
                var result = data.result.address;
                $("#address_1").val(result[0]['add_1']);
                $("#address_2").val(result[0]['add_2']);
                $("#address_zipcode").val(result[0]['zipcode']);
                $("#address_area").val(result[0]['area']);
                $("#address_country").val(result[0]['country']);
            }
        },
    });
});

// User update address form
$(document).on("submit", "#user_update_address_form", function (evt) {
    evt.preventDefault();
    var url = $(this).attr('action');
    var formData = $(this).serialize();
    var selector = $(this);
    $.ajax({
        url: url,
        data: formData,
        type: 'post',
        success: function (result) {
            $.ajax({
                url: currentUrl,
                data: {"address": true},
                success: function (userAdd) {
                    $("#user-address-container").html(userAdd);
                },
            });
            ajaxSuccessMessage(result, selector);
        },
        error: function (event) {
            ajaxErrorMessage(event, selector);
        },
    });
});

/*
 * 
 * User car functionality.( Add-Show user car, services and car-health)
 * 
 */

// Disabled dropdown
$(document).find($('#select_user_car_year')).attr("disabled", true);
$(document).find($('#select_user_car_model')).attr("disabled", true);
$(document).find($('#select_user_cartrim')).attr("disabled", true);

// Get car year
$(document).on("change", "#select_user_car", function () {
    var url = $(this).data("url");
    $('#select_user_car_year').html("").append("<option value=''>Select Year</option>");
    $('#select_user_car_year').attr("disabled", false);
    $.ajax({
        url: url + '/' + $(this).val(),
        type: 'get',
        success: function (data) {
            if (data.status == 'success') {
                var result = data.result;
                for (var i = 0; i <= result.length - 1; i++) {
                    $("#select_user_car_year").append("<option value=" + result[i]['id'] + ">" + result[i]['year'] + "</option>");
                }
            }
        }
    });
});

// Get carmodel
$(document).on("change", "#select_user_car_year", function () {
    var url = $(this).data("url");
    $('#select_user_car_model').html("").append("<option value=''>Select Model</option>");
    $('#select_user_car_model').attr("disabled", false);
    $.ajax({
        url: url + '/' + $(this).val(),
        type: 'get',
        success: function (data) {
            if (data.status == 'success') {
                var result = data.result;
                for (var i = 0; i <= result.length - 1; i++) {
                    $("#select_user_car_model").append("<option value=" + result[i]['id'] + ">" + result[i]['modal_name'] + "</option>");
                }
            }
        }
    });
});

// Get cartrim
$(document).on("change", "#select_user_car_model", function () {
    var url = $(this).data("url");
    $('#select_user_cartrim').html("").append("<option value=''>Select Car Trim</option>");
    $('#select_user_cartrim').attr("disabled", false);
    $.ajax({
        url: url + '/' + $(this).val(),
        type: 'get',
        success: function (data) {
            if (data.status == 'success') {
                var result = data.result;
                for (var i = 0; i <= result.length - 1; i++) {
                    $("#select_user_cartrim").append("<option value=" + result[i]['id'] + ">" + result[i]['car_trim_name'] + "</option>");
                }
            }
        }
    });
});

// User car functionality
$(document).on("submit", "form#form_add_user_car", function (evt) {
    evt.preventDefault();
    var url = $(this).attr('action');
    var formData = $(this).serialize();
    var selector = $(this);
    $.ajax({
        url: url,
        data: formData,
        type: 'post',
        success: function (result) {
            $.ajax({
                url: currentUrl,
                success: function (carList) {
                    $("#user-car-container").html(carList);
                },
            });
            ajaxSuccessMessage(result, selector);
        },
        error: function (event) {
            ajaxErrorMessage(event, selector);
        },
    });
});

$(document).on("submit", "form#form_add_user_car_details", function (evt) {
    evt.preventDefault();
    var url = $(this).attr('action');
    var formData = $(this).serialize();
    var selector = $(this);
    $.ajax({
        url: url,
        data: formData,
        type: 'post',
        success: function (result) {
            $.ajax({
                url: currentUrl,
                success: function (carList) {
                    $("#user-car-container").html(carList);
                },
            });
            ajaxSuccessMessage(result, selector);
        },
        error: function (event) {
            ajaxErrorMessage(event, selector);
        },
    });
});

$('#delete_user_car_modal').on('shown.bs.modal', function (e) {
    $('.removeQuotes,.removeCar').removeAttr('checked');
});

$('.removeQuotes,.removeCar').click(function () {
    if ($('.removeQuotes').is(":checked") && $('.removeCar').is(":checked"))
    {
        $('.car_delete_yes').removeAttr('disabled');
    } else
        $('.car_delete_yes').attr('disabled', 'disabled');
});
$(document).on('click', 'a.delete_user_car', function () {
    $("#form_delete_user_car").attr("action", $(this).attr("url"));
});
// Form delete user car functionality
$(document).on("submit", "#form_delete_user_car", function (evt) {
    if ($('.removeQuotes').is(":checked") && $('.removeCar').is(":checked"))
    {
        evt.preventDefault();
        var url = $(this).attr('action');
        var formData = $(this).serialize();
        var selector = $(this);
        $.ajax({
            url: url,
            data: formData,
            type: 'post',
            success: function (result) {
                $.ajax({
                    url: currentUrl,
                    success: function (carList) {
                        $("#user-car-container").html(carList);
                    },
                });
                ajaxSuccessMessage(result, selector);
            },
            error: function (event) {
                ajaxErrorMessage(event, selector);
            },
        });
    } else
        return false;
});

// Get user car health
$(document).on("click", 'a.view_usercar_health', function () {
    var url = $(this).data("url");
    $.ajax({
        url: url,
        type: "get",
        success: function (result) {
            $("#user-car-health-container").html(result);
        },
    });
});

// Get user car Details
$(document).on("click", 'a.user_car_extra_details', function () {
    var url = $(this).data("url");
    $.ajax({
        url: url,
        type: "get",
        success: function (result) {
            $("#user-car-extra-details-container").html(result);
        },
    });
});

// Get user car services
$(document).on("click", "a.view_usercar_service", function () {
    var url = $(this).data("url");
    $.ajax({
        url: url,
        type: "get",
        success: function (result) {
            $("#user-car-service-container").html(result);
        },
    });
});

// User rating code
$(function () {
    $(".rateYo").rateYo({
        starWidth: "25px",
        fullStar: true,
        spacing: "5px",
    });
});

// User car rating by mechanic
$(document).on('click', 'a.view_car_rating', function () {
    $("#user_car_health_form").attr('action', $(this).data("url"));
});

$(document).on("submit", "#user_car_health_form", function (evt) {
    evt.preventDefault();
    var url = $(this).attr('action');

    var dash = $("#dash").rateYo();
    var tyres = $("#tyres").rateYo();
    var fluids = $("#fluids").rateYo();
    var brakes = $("#brakes").rateYo();
    var engine = $("#engine").rateYo();
    var lights = $("#lights").rateYo();
    var frontSus = $("#frontSus").rateYo();
    var rearSus = $("#rearSus").rateYo();
    var other = $("#other").rateYo();

    $('input[name=dash]').val(dash.rateYo("rating"));
    $('input[name=tyres]').val(tyres.rateYo("rating"));
    $('input[name=fluids]').val(fluids.rateYo("rating"));
    $('input[name=brakes]').val(brakes.rateYo("rating"));
    $('input[name=engine]').val(engine.rateYo("rating"));
    $('input[name=lights]').val(lights.rateYo("rating"));
    $('input[name=front-Suspension]').val(frontSus.rateYo("rating"));
    $('input[name=rear-Suspension]').val(rearSus.rateYo("rating"));
    $('input[name=other]').val(other.rateYo("rating"));

    var formData = $(this).serialize();
    var selector = $(this);
    $.ajax({
        url: url,
        data: formData,
        type: 'POST',
        success: function (result) {
            $('.rateYo').rateYo("rating", 0);
            ajaxSuccessMessage(result, selector);
        },
        error: function (event) {
            ajaxErrorMessage(event, selector);
        }
    });
});

// Common function for ajax success
function ajaxSuccessMessage(result, selector) {
    $(document).find('.status-toggle').bootstrapToggle();
    $(selector).find('button[type=submit]').attr('disabled', false);
    $("[data-dismiss=modal]").trigger({type: "click"});
    if (result.status == "success") {
        toastr.success(result.message, result.status, {timeOut: 2500, progressBar: true, debug: true});
    } else {
        toastr.error(result.message, result.status, {timeOut: 2500, progressBar: true, debug: true});
    }
    return false;
}

// Common function for ajax failure 
function ajaxErrorMessage(event, selector) {
    $('img.spinner').hide();
    if (event.responseJSON.status && event.responseJSON.status === 'failed') {
        toastr.error(event.responseJSON.message, 'Failed', {timeOut: 2500, progressBar: true});
    }
    $(selector).find('button[type=submit]').attr('disabled', false);
    $.each(event.responseJSON, function (key, val) {
        if (key == 'error_msg') {
            alert(val);
            return;
        }
        selector.find('#' + key).html(val).addClass('help-block');
        selector.find('div.' + key).addClass('has-error');
    });
    return false;
}

// Show spinner (loader) on form submit
$(document).on('submit', 'body', function () {
    $('img.spinner').show();
});

// Hide spinner (loader) on ajax complete
$(document).ajaxComplete(function () {
    $('img.spinner').hide();
});

// Remove error message on success and modal close
$('.modal').on('hidden.bs.modal', function (e) {
    $(this).find("input[type=text],textarea").val('');
    $(this).find("div.has-error").removeClass('has-error');
    $(this).find("span.help-block").html("");
    $(this).find(".select2-hidden-accessible").val('').change();
    $(this).find("select option:first-child").attr("selected", true);
    $('.rateYo').rateYo("rating", 0);
});

// Remove error message on keypress
$(document).on("input", "input,textarea", function () {
    var inputValue = $(this).val();
    if (inputValue != "") {
        $(this).siblings("span:first").html("");
        $(this).closest('div.has-error').removeClass("has-error");
    } else {
        $(this).siblings("span").addClass('help-block');
        $(this).parent('div').addClass("has-error");
    }
});

// Remove error message on dropdown changes.
$(document).on("change", "select", function () {
    if ($(this).val() != "") {
        $(this).siblings("span.help-block").html("");
        $(this).closest('div.has-error').removeClass('has-error');
    }
});

$(document).on('click', '#btn_search_booking', function (e) {
    $('.nav-tabs .active>a').click();
});

$(document).on('click', '.booking .pagination >li>a', function (e) {
    e.preventDefault();
    url = $(this).attr('href');
    array = url.split("/")
    array[0] = window.location.protocol;
    var ser_booking = $("#search_booking").val();
    var loadurl = array.join('/') + "&search=" + (!ser_booking ? '' : ser_booking);
    var targ = $('.nav-tabs > li.active > a').attr('data-target');
    $.get(loadurl, function (data) {
        $(targ).html(data);
    });
    $('.nav-tabs > li.active').tab('show')
    return false;
});

$(document).on('click', '.search_form', function (e) {
    e.preventDefault();
    $('.nav-tabs .active>a').click();
});

$("#searchclear").click(function () {
    $("#search_booking").val('');
    $('.nav-tabs .active>a').click();
});

$(document).ready(function () {
    $('[data-toggle="ajaxload"]').click(function (e) {
        $('nav.tabs select option[data-target="' + $(this).attr('data-target') + '"]').attr('selected', true);
        $('img.spinner').show();
        e.preventDefault();
        var ser_booking = $("#search_booking").val();
        var $this = $(this),
                loadurl = $this.attr('href') + "?search=" + (!ser_booking ? '' : ser_booking),
                targ = $this.attr('data-target');
        $.get(loadurl, function (data) {
            $(targ).html(data);
            setTimeout(function () {
                $('[data-toggle="popover"]').popover();
            }, 500);
        });

        $this.tab('show');
        return false;
    });

    $(document).on('click', '#confirm-booking', function (e) {
        e.preventDefault();
        var bookingId = $("#booking-id").val();
        var status = 1;
        var url = '/user/bookings/update/' + bookingId + '/' + status;
        var selector = $(this);
        $.ajax({
            url: url,
            type: 'GET',
            success: function (result) {
                ajaxSuccessMessage(result, selector);
            },
            error: function (event) {
                ajaxErrorMessage(event, selector);
            }
        });
    });

    $(document).on('input', '#parts_cost', function (evt) {
        var self = $(this);
        self.val(self.val().replace(/[^0-9\.]/g, ''));
        if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57))
        {
            evt.preventDefault();
        }

        var parts_cost = self.val();
        var labour_cost = $('#labour_cost').val();
        var x = +parts_cost + +labour_cost;
        //$('.total_price_place').text(x + '.00');
        $('.total_price_place').text(x.toFixed(2));
    });

    $(document).on('input', '#labour_cost', function (evt) {
        var self = $(this);
        self.val(self.val().replace(/[^0-9\.]/g, ''));
        if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57))
        {
            evt.preventDefault();
        }

        var labour_cost = self.val();
        var parts_cost = $('#parts_cost').val();
        var x = +labour_cost + +parts_cost;
        //$('.total_price_place').text(x + '.00');
        $('.total_price_place').text(x.toFixed(2));
    });

    $(document).on('click', '#update-quote', function (e) {
        e.preventDefault();
        var bookingId = $("#booking-id").val();
        var labour_cost = $('#labour_cost').val();
        var parts_cost = $('#parts_cost').val();

        /*
         if (labour_cost == '' && parts_cost == '') {
         return;
         }
         */

        var quesyString = "?labour_cost=" + labour_cost + "&parts_cost=" + parts_cost;
        var price = $('.total_price_place').text()
        var url = '/admin/bookings/update/quote/' + bookingId + '/' + price + quesyString;
        var selector = $('.table-booking');
        $.ajax({
            url: url,
            type: 'GET',
            success: function (result) {
                if (result && result.status && result.status == 'success') {
                    $.ajax({
                        url: '/admin/bookings/update/' + bookingId + '/3    ',
                        success: function (result1) {
                        },
                    });
                    $('.tab-pane').load($('.nav-tabs li.active a:first[data-toggle="ajaxload"]').attr('href'));
                    ajaxSuccessMessage(result, selector);
                } else {

                }
            },
            error: function (event) {
                ajaxErrorMessage(event, selector);
            }
        });
    });
});

// Disable submit button when ajax request is in process 
$(document).on('click', 'button[type=submit]', function (e) {
    e.preventDefault();
    $(this).attr('disabled', true);
    $(this).closest('form').submit();
});

function isExist() {
    var login = 'login';
    try {
        localStorage.setItem(login, login);
        localStorage.removeItem(login);
        return true;
    } catch (e) {
        return false;
    }
}

// listen to storage event
window.addEventListener('storage', function (event) {
    // do what you want on logout-event
    if (event.key == 'logout-event') {
        setTimeout(function () {
            location = self.location['href'];
        }, 700);
    }
}, false);

$(document).ready(function () {
    if (isExist()) {
        $('.logout').on('click', function () {
            // change logout-event and therefore send an event
            localStorage.setItem('logout-event', 'logout' + Math.random());
            return true;
        });
    }
});



// Tab to DropDown JS Start
$(function () {

    // Create the dropdown base
    $("<select class='form-control' />").appendTo("nav.tabs");

    // Populate dropdown with menu items
    $("nav.tabs a").each(function () {
        var el = $(this);
        $("<option />", {
            "href": el.attr("href"),
            "text": el.text(),
            "data-toggle": el.attr("data-toggle"),
            "data-target": el.attr("data-target"),
        }).appendTo("nav.tabs select");
    });

    // To make dropdown actually work
    $("nav.tabs select").change(function () {
        $('.tabs li[data-name="' + $(this).val().replace(/\ /g, '').toLowerCase() + '"] a').click();
    });

});
//Tab to DropDown JS End

$(document).on("click", '.booking-service-details .service-description-booking-detail-link', function (evt) {
    if ($(this).text() == 'Show Description') {
        $(this).text('Hide Description');
    } else if ($(this).text() == 'Hide Description') {
        $(this).text('Show Description');
    }
    $(this).siblings('.booking-service-details .service-description-booking-detail').toggleClass('show-desc');
});

$(document).ready(function () {
    $("#addUserForm").validate({
        rules: {
            name: "required",
            email: {
                required: true,
                email: true
            },
            mobile: {
                required: true,
                number: true
            },
            password: "required",
            mobile_country_code: "required",
            default_location: "required"
        },
        messages: {
            name: "Please enter name",
            email: {
                required: "Please enter email",
                email: "Please enter valid email"
            },
            mobile: {
                required: "Please enter mobile number",
                number: "Please enter valid mobile number"
            },
            password: "Please enter password",
            mobile_country_code: "Please select country code",
            default_location: "Please select default location",
        },
        submitHandler: function (form) {
            form.submit();
        }
    });
});

$(document).ready(function () {
    // Fetch User's Cars
    $('#requestAQuoteAdmin input.flexdatalist').on('select:flexdatalist', function (event, set, options) {
        $('#requestAQuoteAdmin #user_cars').html('');
        $.ajax({
            url: '/admin/bookings/get-user-cars/' + set.id,
            type: 'GET',
            success: function (result) {
                $('#search_username-error').css('display', 'none');
                $('#request-a-quote').prop('disabled', false);
                $('#requestAQuoteAdmin #user_cars').html(result);
            }
        });
    });

    // Select Default Location
    $('#requestAQuoteAdmin #default_location').on('change', function () {
        if ($(this).val().length > 0) {
            $('#default_location-error').css('display', 'none');
            $('#request-a-quote').prop('disabled', false);
        }
    });

    // Select User's Car
    $('#requestAQuoteAdmin #user_cars').on('change', function () {
        if ($(this).val().length > 0) {
            $('#user_cars-error').css('display', 'none');
            $('#request-a-quote').prop('disabled', false);
        }
    });

    // Fetch Categories
    $('#requestAQuoteAdmin #service_types').on('change', function () {
        $('#requestAQuoteAdmin .custom-service-section').addClass('hide-section');
        $('#requestAQuoteAdmin .select-services-section').addClass('hide-section');
        $('#requestAQuoteAdmin .search-service-section').addClass('hide-section');
        $('#service-required-message').css('display', 'none');
        $('#request-a-quote').prop('disabled', false);
        $('#requestAQuoteAdmin #category').html('');
        $('#requestAQuoteAdmin #services-section').html('');
        $('#requestAQuoteAdmin #sub-services-section').html('');
        var service_type_id = $(this).val();
        if (service_type_id == 'popular') {
            $('#requestAQuoteAdmin .select-services-section').removeClass('hide-section');
            $('.category-dropdown').css('display', 'none');
        } else if (service_type_id == 'custom') {
            $('#requestAQuoteAdmin .select-services-section').addClass('hide-section');
            $('.category-dropdown').css('display', 'none');
        } else if (service_type_id == 'search') {
            $('#requestAQuoteAdmin .select-services-section').addClass('hide-section');
            $('.category-dropdown').css('display', 'none');
        } else {
            $('.category-dropdown').css('display', 'block');
        }
        $.ajax({
            url: '/admin/bookings/get-categories/' + service_type_id,
            type: 'GET',
            success: function (result) {
                if (service_type_id == 'popular') {
                    $('#requestAQuoteAdmin .services-section').removeClass('hide-section');
                    $('#requestAQuoteAdmin #services-section').removeClass('hide-section').html(result);
                } else if (service_type_id == 'custom') {
                    $('#requestAQuoteAdmin .custom-service-section').removeClass('hide-section');
                    $('#requestAQuoteAdmin #custom-service-section').html(result);
                } else if (service_type_id == 'search') {
                    $('#requestAQuoteAdmin .search-service-section').removeClass('hide-section');
                    $('#requestAQuoteAdmin #search-service-section').html(result);
                } else {
                    $('#requestAQuoteAdmin #category').html(result);
                }
            }
        });
    });

    // Fetch Services
    $('#requestAQuoteAdmin #category').change(function () {
        $('#service-required-message').css('display', 'none');
        $('#request-a-quote').prop('disabled', false);
        $('#requestAQuoteAdmin #services-section').html('');
        $('#requestAQuoteAdmin #sub-services-section').html('');
        var service_type_id = $(this).val();
        $.ajax({
            url: '/admin/bookings/get-services/' + service_type_id,
            type: 'GET',
            success: function (result) {
                $('#requestAQuoteAdmin .select-services-section').removeClass('hide-section');
                $('#requestAQuoteAdmin .services-section').removeClass('hide-section');
                $('#requestAQuoteAdmin #services-section').removeClass('hide-section').html(result);
            }
        });
    });

    // Fetch Sub-Services and thier options
    $(document).on('click', '#requestAQuoteAdmin ul.services-lists li a', function () {
        $('#requestAQuoteAdmin #sub-services-section').html('');
        $('#requestAQuoteAdmin ul.services-lists li a').removeClass('active');
        $(this).addClass('active');
        var service_id = $(this).data('id');
        $.ajax({
            url: '/admin/bookings/get-sub-services/' + service_id,
            type: 'GET',
            success: function (result) {
                $('#requestAQuoteAdmin .services-section').removeClass('hide-section');
                $('#requestAQuoteAdmin #sub-services-section').removeClass('hide-section').html(result);
            }
        });
    });

    // Add Service(s)
    $(document).on('click', '#requestAQuoteAdmin button#add-service-admin', function () {
        var $btn = $(this).button('loading');
        var _token = $('input[name="_token"]').val();
        var service_id = 0;
        var optional_counter = 0;
        var service_title = '';
        // For Client
        var service_id_array_client = new Array();
        var service_json_client = '';
        var sub_service_id_array_client = new Array();

        // For Server
        var service_id_array_server = new Array();
        var service_json_server = '';
        var sub_service_id_array_server = new Array();

        if ($('input[name="service_id"]')) {
            service_id = $('input[name="service_id"]').val();
            service_title = $('input[name="service_title"]').val();
        }

        if ($('input[name="sub_service_id[]"]')) {
            $('input[name="sub_service_id[]"]').each(function () {
                // For Client
                var sub_service_options_array_client = new Array();
                var temp_sub_service_id_array_client = new Array();
                // For Server
                var sub_service_options_array_server = new Array();
                var temp_sub_service_id_array_server = new Array();

                var display_text = $('#display_text' + $(this).val()).val();
                var selection_type = $('#selection_type' + $(this).val()).val();
                var optional = $('#optional' + $(this).val()).val();
                if (selection_type == 'S') {
                    $('input[name="sub_service_options' + $(this).val() + '[]"]').each(function () {
                        var temp_sub_service_options_array_client = new Array();
                        var temp_sub_service_options_array_server = new Array();
                        if ($(this).prop("checked") == true) {
                            // For Client
                            temp_sub_service_options_array_client.push({
                                id: $(this).val(),
                                option_name: $(this).data('option_name')
                            });
                            sub_service_options_array_client.push(temp_sub_service_options_array_client);

                            // For Server                            
                            temp_sub_service_options_array_server.push({
                                id: $(this).val()
                            });
                            sub_service_options_array_server.push(temp_sub_service_options_array_server);
                        }
                    });
                    if (optional == '0') {
                        if (sub_service_options_array_server && sub_service_options_array_server.length > 0) {
                        } else {
                            optional_counter++;
                            $('#sub-service-mandotary-message' + $(this).val()).addClass('active').text('Please select option');
                            $btn.button('reset');
                            return false;
                        }
                    }
                } else if (selection_type == 'M') {
                    $('input[name="sub_service_options' + $(this).val() + '[]"]').each(function () {
                        var temp_sub_service_options_array_client = new Array();
                        var temp_sub_service_options_array_server = new Array();
                        if ($(this).prop("checked") == true) {
                            // For Client
                            temp_sub_service_options_array_client.push({
                                id: $(this).val(),
                                option_name: $(this).data('option_name')
                            });
                            sub_service_options_array_client.push(temp_sub_service_options_array_client);

                            // For Server
                            temp_sub_service_options_array_server.push({
                                id: $(this).val()
                            });
                            sub_service_options_array_server.push(temp_sub_service_options_array_server);
                        }
                    });
                    if (optional == '0') {
                        if (sub_service_options_array_server && sub_service_options_array_server.length > 0) {
                        } else {
                            optional_counter++;
                            $('#sub-service-mandotary-message' + $(this).val()).addClass('active').text('Please select option');
                            $btn.button('reset');
                            return false;
                        }
                    }
                }

                // For Client
                if (sub_service_options_array_client && sub_service_options_array_client.length > 0) {
                    temp_sub_service_id_array_client.push({
                        id: $(this).val(),
                        display_text: display_text,
                        sub_service_options: sub_service_options_array_client
                    });
                }
                sub_service_id_array_client.push(temp_sub_service_id_array_client);

                // For Server
                if (sub_service_options_array_server && sub_service_options_array_server.length > 0) {
                    temp_sub_service_id_array_server.push({
                        id: $(this).val(),
                        sub_service_options: sub_service_options_array_server
                    });
                }
                sub_service_id_array_server.push(temp_sub_service_id_array_server);

            });
        }

        if (optional_counter && optional_counter > 0) {
            return false;
        }

        // For Client
        if (sub_service_id_array_client && sub_service_id_array_client.length > 0) {
            service_id_array_client.push({
                id: service_id,
                service_title: service_title,
                sub_services: sub_service_id_array_client
            });
        } else {
            service_id_array_client.push({
                id: service_id,
                service_title: service_title,
            });
        }

        // For Server
        if (sub_service_id_array_server && sub_service_id_array_server.length > 0) {
            service_id_array_server.push({
                id: service_id,
                sub_services: sub_service_id_array_server
            });
        } else {
            service_id_array_server.push({
                id: service_id
            });
        }
        service_json_client = JSON.stringify(service_id_array_client);
        service_json_server = JSON.stringify(service_id_array_server);

        console.log(service_json_server);

        var custom_service_description = '';
        custom_service_description = $('#custom_service_description').val()
        if ($('#custom-service-section').html() !== '' && custom_service_description === '') {
            $btn.button('reset');
            $('#custom_service_description').focus();
            $('#custom_service_description_message').removeClass('hide-section').text('Please enter custom service description');
            return false;
        } else {

        }
        //console.log("Server: " + service_json_server);
        $.ajax({
            url: '/admin/bookings/add-services',
            data: {
                service_id: service_id,
                service_json_client: service_json_client,
                service_json_server: service_json_server,
                custom_service_description: custom_service_description,
                "_token": _token
            },
            type: 'POST',
            success: function (result) {
                if (custom_service_description !== '') {
                    $('#custom_service_description').val('');
                    $('#requestAQuoteAdmin .custom-service-section').addClass('hide-section');
                    $('#requestAQuoteAdmin #custom-service-section').html('');
                }
                $('#service-required-message').css('display', 'none');
                $('#request-a-quote').prop('disabled', false);
                $btn.button('reset');
                $('#requestAQuoteAdmin .selected-services-section').removeClass('hide-section');
                $('#requestAQuoteAdmin #sub-services-section').html('');
                var html = $('#requestAQuoteAdmin #selected-services-section').html();
                $('#requestAQuoteAdmin #selected-services-section').html(html + '' + result);
            }
        });
    });

    // Search Service(s)
    $(document).on('keyup', '#requestAQuoteAdmin #search_service', function () {
        var search_service = $(this).val();
        var _token = $('input[name="_token"]').val();
        if (search_service && search_service !== '') {
            $.ajax({
                url: '/admin/bookings/search-service',
                data: {
                    search_service: search_service,
                    "_token": _token
                },
                type: 'POST',
                success: function (result) {
                    $('#requestAQuoteAdmin .select-services-section').removeClass('hide-section');
                    $('#requestAQuoteAdmin .services-section').removeClass('hide-section');
                    $('#requestAQuoteAdmin #services-section').removeClass('hide-section').html(result);
                }
            });
        }
    });

    // Delete Service(s)
    $(document).on('click', '#requestAQuoteAdmin a.delete-service', function () {
        var $btn = $(this).button('loading');
        var service_id = $(this).data('id');
        $.ajax({
            url: '/admin/bookings/delete-service/' + service_id,
            type: 'GET',
            success: function (result) {
                $btn.button('reset');
                $('#requestAQuoteAdmin #selected-services-section').removeClass('hide-section').html(result);
            }
        });
    });

    // Submit Request A Quote and Check Validations
    $("#requestAQuoteAdmin").validate({
        rules: {
            user_id: "required",
            default_location: "required",
            user_cars: "required"
        },
        messages: {
            user_id: "Please select user",
            default_location: "Please select default location",
            user_cars: "Please select user's car"
        },
        submitHandler: function (form) {
            var services_cookie_client = $('#selected-services-section').html();
            if (services_cookie_client === '') {
                $('#service-required-message').text('Please select at least one service');
                return false;
            } else {
                form.submit();
            }
        }
    });
});


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

$(document).on("click", "#search_users_form #btn_search_users", function (evt) {
    evt.preventDefault();
    var url = $('#search_users_form').attr('action');
    var search_users = $('#search_users_form #search_users').val();
    if (search_users && search_users.length > 0) {
        var selector = $(this);
        $.ajax({
            url: url + '/' + search_users,
            type: 'get',
            success: function (result) {
                $('#user-table-container table').html(result);
            },
            error: function (event) {

            },
        });
    }
});