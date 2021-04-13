$(function(){
    'use strict';

    // Hide placeholder on form focus
    $('[placeholder]').focus(function(){
       $(this).attr('data-text', $(this).attr('placeholder'));
       $(this).attr('placeholder','');
    }).blur(function(){
        $(this).attr('placeholder',$(this).attr('data-text'));
    });

    // **** Problem
    // Add Asterisk on required field
    $('input').each(function(){
        if($(this).attr('required') === 'required'){
            $(this).after("<span class='Asterisk'>*</span>");
        }
    });

    var passField = $('.password');
    $('.show-pass').hover(function(){
        passField.attr('type','text');
    },function(){
        passField.attr('type','password');
    });

    // Confirmation Message on button
    $('.confirm').click(function(){
        return confirm('Are you sure');
    });



});



