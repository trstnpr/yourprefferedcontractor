// START Navbar Transitions
$(function () {
    $(document).scroll(function () {
        var $nav = $('.main-menu');
        var $navtop = $('.navbar-extra-top');

        $nav.toggleClass(
            'scrolled',
            $(this).scrollTop() > $nav.height()
        );
        if ($(this).scrollTop() > $nav.height()) {
            $navtop.slideUp();
        } else {
            $navtop.slideDown();
        }
    });
});
// END Navbar Transitions

// START Read Image File
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('.preview').attr('src', e.target.result);
            $('.remove-preview').show();
        };

        reader.readAsDataURL(input.files[0]);
    }
}
$('.remove-preview').click(function(e) {
    e.preventDefault();
    $(this).hide();
    $('.preview').attr('src', '');
    $('.biz_photo').val('');
});
// END Read Image File

// START Attribute for background images
$('.data-img').each(function() {
	var attr = $(this).attr('data-bg');
	if (typeof attr !== typeof undefined && attr !== false) {
		$(this).css('background-image', 'url('+attr+')');
	}
});
// END Attribute for background images

// START Init Parallax.js
$('.parallax').parallax();
// END Init Parallax.js

// START DISPLAY TIME 24 hr format
function startTime() {
    var time = new Date();
    var h = time.getHours();
    var m = time.getMinutes();
    var s = time.getSeconds();
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById('time').innerHTML = h + ":" + m + ":" + s;
    var t = setTimeout(startTime, 500);
}
function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
}
// END DISPLAY TIME 24 hr format

var today = new Date();
var month = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
var day = ["Sun", "Mon", "Tue", "Wed", "Thu", "Sat"];

function getTimeZone() {
    var offset = new Date().getTimezoneOffset(),
        o = Math.abs(offset);
    return (offset < 0 ? "+" : "-") + ("00" + Math.floor(o / 60)).slice(-2) + ":" + ("00" + (o % 60)).slice(-2);
}

var date = day[today.getDay()] + " " + today.getDate() + " " + month[today.getMonth()] + " " + today.getFullYear();
$('#date').html(date);
$('#timezone').html(getTimeZone());

// Init DataTables
// $('.datatable').DataTable();

// START Weather Plugin
$.simpleWeather({
    location: $('.weather-widget').data('weather'),
    woeid: '',
    unit: 'f',
    success: function(weather) {
        html = '<h2 class="forecast"><i class="icon-'+weather.code+'"></i> '+weather.temp+'&deg;'+weather.units.temp+'</h2>';
        html += '<ul class="weather-info">';
        html += '<li class="currently">'+weather.currently+'</li>';
        html += '<li class="location">'+weather.city+', '+weather.region+'</li>';
        html += '<li class="wind">'+weather.wind.direction+' '+weather.wind.speed+' '+weather.units.speed+'</li>'
        html += '</ul>';

        $('.weather-widget').html(html);
    },
    error: function(error) {
        $('.weather-widget').html('<p>'+error+'</p>');
    }
});
// END Weather Plugin

// START FuzzySearch
var fuzzyhound = new FuzzySearch();
var formAction = $('.search-directory').attr('action') + '?location=';
$('.keyword').typeahead({
        minLength: 2,
        highlight: false
    },
    {
        name: 'movies',
        source: fuzzyhound,
        templates: {
            suggestion: function(result){return '<div class="suggestions">'+fuzzyhound.highlight(result)+'</div>'}
    }
});

$.ajaxSetup({cache: true});

var sourceJSON = $('.keyword').data('suggest');
function setsource(url, keys, output) {
    $.getJSON(url).then(function (response) {
        fuzzyhound.setOptions({
            source: response,
            keys: keys,
            output_map: output
        })
    });
}
setsource(sourceJSON);
// END FuzzySearch

// START Search Form Validation
function strip_char() {
    var str = document.getElementById('keyword');
    var spchr = /[^0-9\s,a-z]/gi;
    var space = /\s\s+/g;
    var comma = /,,+/g;
    str.value = str.value.replace(spchr, '').replace(space, '').replace(comma, ', ');

}

$('#keyword').keyup(function(e) {
    e.preventDefault();
    var keyword = $.trim($('#keyword').val());
    var validator = $('.search-directory').data('validate');
    var searchform = $('.search-directory');

    $.ajax({
        url: validator + keyword,
        type: 'GET',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        error: function(data){
            if(data.readyState == 4){
                errors = JSON.parse(data.responseText);
            }
        },
        success: function(data){
            var msg = JSON.parse(data);
            if(msg.result == 'success'){
                console.log(msg);
                searchform.submit();
            } else{
                console.log(msg);
            }
        }
    });

});

$('.mjrcity').click(function () {
    var aTag = $(this).attr('href');
    $('html,body').animate({
        scrollTop: $(aTag).offset().top
    }, 600);

    return false;
});

// START Submit Business
$('.biz_state').keyup(function() {
    this.value = this.value.toUpperCase();
});
$('.biz_zip').keyup(function(e) {
    $(this).val($(this).val().replace(/[^0-9]/g, ''));
});
$('.submit-biz').on('submit', function(e) {
    e.preventDefault();
    var sbmt_biz_action = $(this).attr('action');
    $.ajax({
        url: sbmt_biz_action,
        type: 'POST',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
            $('.submit-biz-btn').html('Loading ...');
        },
        error: function(data){
            if(data.readyState == 4){
                errors = JSON.parse(data.responseText);
            }
        },
        success: function(data) {
            var msg = JSON.parse(data);
            if(msg.result == 'success'){
                alertify.success(msg.message);
                $('.submit-biz-btn').html('Submit <i class="fa fa-paper-plane">');
                $('.preview').attr('src', '');
                $('.remove-preview').hide();
                $('.submit-biz')[0].reset();
                grecaptcha.reset();
                location.reload();
            } else {
                alertify.error(msg.message);
                $('.submit-biz-btn').html('Submit <i class="fa fa-paper-plane">');
                $('.submit-biz')[0].reset();
                grecaptcha.reset();
            }
        }
    });

});
// END Submit Business

// START Contact Us
$('.form-contact').on('submit', function(e) {
    e.preventDefault();
    var contact_action = $(this).attr('action');
    $.ajax({
        url: contact_action,
        type: 'POST',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
            $('.btn-send').html('Sending ...');
        },
        error: function(data){
            if(data.readyState == 4){
                errors = JSON.parse(data.responseText);
            }
        },
        success: function(data) {
            var msg = JSON.parse(data);
            if(msg.result == 'success'){
                alertify.success(msg.message);
                $('.btn-send').html('Send <i class="fa fa-paper-plane">');
                $('.form-contact')[0].reset();
                grecaptcha.reset();
                location.reload();
            } else {
                alertify.error(msg.message);
                $('.btn-send').html('Send <i class="fa fa-paper-plane">');
                $('.form-contact')[0].reset();
                grecaptcha.reset();
            }
        }
    });

});
// END Contact Us
