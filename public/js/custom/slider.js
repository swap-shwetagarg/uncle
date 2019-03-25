
function initiateSlider(val, mn, mx, sldTime1, sldTime2)
{
    $('.slider-time').html('7:00 AM');
    $('.slider-time2').html('7:00 PM');
    var min = 420;
    var step = 1;
    var max = 1140;
    if (val != '0')
    {
        $('.slider-time').html(sldTime1);
        $('.slider-time2').html(sldTime2);
        min = mn;
        max = mx;
    }
    $("#slider-range").slider({
        range: true,
        min: min,
        max: max,
        step: step,
        values: [min, max],
        slide: function (e, ui) {
            var minTime = 1;
            var hours1 = Math.floor(ui.values[0] / 60);
            var minutes1 = ui.values[0] - (hours1 * 60);
            var hr1 = hours1;
            var mn1 = minutes1;
            if (hours1.length == 1)
                hours1 = '0' + hours1;
            if (minutes1.length == 1)
                minutes1 = '0' + minutes1;
            if (minutes1 == 0)
                minutes1 = '00';
            if (hours1 >= 12) {
                if (hours1 == 12) {
                    hours1 = hours1;
                    minutes1 = minutes1 + " PM";
                } else {
                    hours1 = hours1 - 12;
                    minutes1 = minutes1 + " PM";
                }
            } else {
                hours1 = hours1;
                minutes1 = minutes1 + " AM";
            }
            if (hours1 == 0) {
                hours1 = 12;
                minutes1 = minutes1;
            }

            var hours2 = Math.floor(ui.values[1] / 60);
            var minutes2 = ui.values[1] - (hours2 * 60);
            var hr2 = hours2;
            var mn2 = minutes2;
            if (hours2.length == 1)
                hours2 = '0' + hours2;
            if (minutes2.length == 1)
                minutes2 = '0' + minutes2;
            if (minutes2 == 0)
                minutes2 = '00';
            if (hours2 >= 12) {
                if (hours2 == 12) {
                    hours2 = hours2;
                    minutes2 = minutes2 + " PM";
                } else if (hours2 == 24) {
                    hours2 = 11;
                    minutes2 = "59 PM";
                } else {
                    hours2 = hours2 - 12;
                    minutes2 = minutes2 + " PM";
                }
            } else {
                hours2 = hours2;
                minutes2 = minutes2 + " AM";
            }
            if ((hr2 - hr1) > minTime || ((hr2 - hr1) == minTime && (mn2 - mn1) >= 0))
            {
                $('.slider-time').html(hours1 + ':' + minutes1);
                $('.slider-time2').html(hours2 + ':' + minutes2);
            } else
                return false;
        }
    });
}
function validClick(date)
{
    var dt = new Date();
    validDate = new Date(dt.getFullYear(), dt.getMonth(), dt.getDate());
    if (new Date(date) >= validDate && new Date(date) <= new Date(dt.setDate(dt.getDate() + 14)))
    {
        return true;
    }
    return false;
}
function validateToday(date)
{
    var dt = new Date();
    if (date.toDate().getDate() == dt.getDate() && dt.getHours() <= 18 )
    {
        var hrs = dt.getHours();
        var mnts = dt.getMinutes();
        if(dt.getHours() < 7){
            hrs = 7;
            mnts = 00;
        }
        return ((hrs * 60) + mnts + '|' + (hrs + ":" + mnts + ' ' + (hrs < 12 ? 'AM' : 'PM')));
    } 
    else if(date.toDate().getDate() == dt.getDate())
        return "1";
    else
        return "0";
}
function convertTo24Hour(time) {
    var hours = parseInt(time.substr(0, 2));
    if (time.indexOf('AM') != -1 && hours == 12) {
        time = time.replace('12', '0');
    }
    if (time.indexOf('PM') != -1 && hours < 12) {
        time = time.replace(hours, (hours + 12));
    }
    return time.replace(/(AM|PM)/, '');
}
function ConvertToAMPM(date) {
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    minutes = minutes < 10 ? '0' + minutes : minutes;
    var strTime = hours + ':' + minutes + ' ' + ampm;
    return strTime;
}