/*globals require, $*/
window.$ = window.jQuery = require('jquery');
window.moment = require('moment');

$('a[href="#"]').click(e => e.preventDefault());

$.fn.goTo = function () {
    $('html, body').animate({
        scrollTop: $(this).offset().top + 'px'
    }, 'fast');
    return this;
};