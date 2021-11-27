'use strict';
$(document).on('click','#js-follow-btn',(e)=>{
  e.stopPropagation();
  let current_user_id = $('#js-current-user-id').val();
  let profile_user_id = $('#js-profile-user-id').val();
  let formData = new FormData();
  formData.append('current_user_id', current_user_id);
  formData.append('profile_user_id', profile_user_id);
  $.ajax({
      type: 'POST',
      url: 'views/ajax_follow_process.php',
      dataType: 'json',
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
  }).done(function(data){
      if(data.success) {
          $('.display-follow-button').text('フォロー');
      } else {
          $(".display-follow-button").text('フォロー中');
      }
      $('#js-follow').text(data.follow);
      $("#js-follower").text(data.follower);
      console.log(data);
  }).fail(function(data){
      console.log(data.responseText);
      console.log('fail');
  });
});

function alert_animation() {
  $('#msgAlert').fadeIn(2000);
  setInterval(() => {
      $('#msgAlert').fadeOut(2000);
  }, 7000);
};

//パスワードの可視化と不可視化
$(()=> {
  $('#eye-icon').on('click',() => {
      const input = $('#inputPassword');
      if (input.attr('type') == 'password') {
          input.attr('type','text');
      } else {
          input.attr('type','password');
      }
      $('#eye-icon').toggleClass('fa-eye');
      $('#eye-icon').toggleClass('fa-eye-slash');
  });
});