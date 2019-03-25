
$(document).ready(function () {
    /*
    $(document).on('click', 'button.navbar-toggle,ul.nav.navbar-nav.navbar-right li a', function () {
        $('html').toggleClass('togggle');
    });
    */

    $(document).on('click', '.promotor-block a.close-promotor-link', function () {
        $.cookie("promotor_block_cookie", 1, {expires: 10});
        $('.promotor-block').addClass('block-hide');
    });

});

// Slider Half Screen
var $item = $('.carousel2 .item');
var $wHeight = $(window).height();
$item.eq(0).addClass('active');
$item.height($wHeight);
$item.addClass('full-screen');

$('.carousel2 img').each(function () {
    var $src = $(this).attr('src');
    var $color = $(this).attr('data-color');
    $(this).parent().css({
        'background-image': 'url(' + $src + ')',
        'background-color': $color
    });
    $(this).remove();
});

$(window).on('resize', function () {
    $wHeight = $(window).height();
    $item.height($wHeight);
});

function activateTab(selector) {
    $(selector).on('click.twbstab', function () {
        $(this).tab('show');
    })
            .closest('.disabled').removeClass('disabled');
}

activateTab('#myTab a:first');

$('.btn-demo').on('click', function () {
    var selector = '#myTab a[href="' + $(this).data('activate') + '"]';
    activateTab(selector);
});

var form = $("#example-form");
form.validate({
    errorPlacement: function errorPlacement(error, element) {
        element.before(error);
    },
    rules: {
        confirm: {
            equalTo: "#password"
        }
    }
});
form.children("div").steps({
    headerTag: "h3",
    bodyTag: "section",
    transitionEffect: "slideLeft",
    onInit: function (event, currentIndex) {
        resizeJquerySteps();
    },
    onStepChanging: function (event, currentIndex, newIndex) {
        resizeJquerySteps();
    },
    onStepChanged: function (event, currentIndex, priorIndex) {
        resizeJquerySteps();
    },
    onStepChanging: function (event, currentIndex, newIndex)
    {
        form.validate().settings.ignore = ":disabled,:hidden";
        return form.valid();
    },
    onFinishing: function (event, currentIndex)
    {
        form.validate().settings.ignore = ":disabled";
        return form.valid();
    },
    onFinished: function (event, currentIndex)
    {
        alert("Submitted!");
    }
});

// Resize jQuery Steps When content load
function resizeJquerySteps() {
    $('.wizard .content').animate({
        height: $('.body.current').outerHeight()
    }, 'fast');
}

//******ACCORDION TOGGLE - collapse/closed shows plus, and open shows minus

var $activePanelHeading = $('.panel-group .panel .panel-collapse.in').prev().addClass('active');  //add class="active" to panel-heading div above the "collapse in" (open) div
$activePanelHeading.find('a').prepend('<span class="fa fa-minus-circle"></span> ');  //put the minus-circle-sign inside of the "a" tag
$('.panel-group .panel-heading').not($activePanelHeading).find('a').prepend('<span class="fa fa-plus-circle"></span> ');  //if it's not active, it will put a plus-circle-sign inside of the "a" tag
$('.panel-group').on('show.bs.collapse', function (e) {  //event fires when "show" instance is called
    //$('.panel-group .panel-heading.active').removeClass('active').find('.fa').toggleClass('fa-plus-circle fa-minus-circle'); - removed so multiple can be open and have minus-circle sign
    $(e.target).prev().addClass('active').find('.fa').toggleClass('fa-plus-circle fa-minus-circle');
});
$('.panel-group').on('hide.bs.collapse', function (e) {  //event fires when "hide" method is called
    $(e.target).prev().removeClass('active').find('.fa').removeClass('fa-minus-circle').addClass('fa-plus-circle');
});

//Fa plus Minus End