/*global $, document, window, setTimeout, navigator, console, location*/
$(document).ready(function () {

    'use strict';

    // Detect browser for css purpose
    if (navigator.userAgent.toLowerCase().indexOf('firefox') > -1) {
        $('.form form label').addClass('fontSwitch');
    }

    // Label effect
    $('input').focus(function () {
        $(this).siblings('label').addClass('active');
        $(this).siblings('span.form-bar').addClass('active');
        $(this).parent().addClass('active')
    });

    // Form validation
    $('input').blur(function () {
        // label effect
        if ($(this).val().length > 0) {
            $(this).siblings('label').addClass('active');
            $(this).siblings('span.form-bar').addClass('active');
            $(this).parent().addClass('active')
        } else {
            $(this).siblings('label').removeClass('active');
            $(this).siblings('span.form-bar').removeClass('active');
            $(this).parent().removeClass('active')
        }
    });

    $('input[type=email]').focus(function() {
        $(this).attr('placeholder', 'xxxxxxxxx@unmas.ac.id');
    });

    $('input[type=email]').blur(function(){
        if ($(this).val().length > 0) {
            $(this).attr('placeholder', 'xxxxxxxxx@unmas.ac.id');
        } else {
            $(this).attr('placeholder', '');
        }
    });


    // form switch
    $('a.switch').click(function (e) {
        $(this).toggleClass('active');
        e.preventDefault();

        if ($('a.switch').hasClass('active')) {
            $(this).parents('.form-peice').addClass('switched').removeClass('anim-light').siblings('.form-peice').removeClass('switched').addClass('anim-light');
        } else {
            $(this).parents('.form-peice').removeClass('switched').addClass('anim-light').siblings('.form-peice').addClass('switched').removeClass('anim-light');
        }
    });


    // Reload page
    $('a.profile').on('click', function () {
        location.reload(true);
    });

    $("body").on('click', '.toggle-password', function () {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $("#loginPassword");
        if (input.attr("type") === "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });

    // $("body").on

});