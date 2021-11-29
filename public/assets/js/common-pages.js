"use strict";
$(document).ready(function() {
    // $('.theme-loader').addClass('loaded');
    //$('html').addClass('scrollBarControl');
    $('.theme-loader').animate({
        'opacity': '1',
    }, 400);
    setTimeout(function() {
        $('.theme-loader').remove();
        //$('html').removeClass('scrollBarControl');
    }, 400);
    // $('.pcoded').addClass('loaded');
});
