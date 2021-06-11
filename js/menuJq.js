'use strict'

$(function(){
  $('#menu_contents').click(function() {
    if($('.nav-sp').hasClass('open')) {
      $('.nav-sp').removeClass('open');
      $(this).removeClass('open');
    } else {
      $('.nav-sp').addClass('open');
      $(this).addClass('open');
    }
  })
})