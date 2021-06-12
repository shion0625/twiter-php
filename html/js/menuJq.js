'use stript';
$(() => {
  // ハンバーガーメニュークリックイベント
  $('.hamburger-menu').on('click',() =>{
    if($('.nav-sp').hasClass('slide')){
      // ナビゲーション非表示
      $('.nav-sp').removeClass('slide');
      // ハンバーガーメニューを元に戻す
      $('.hamburger-menu').removeClass('open');
      console.log('remove');
    }else{
      // ナビゲーションを表示
      $('.nav-sp').addClass('slide');
      // ハンバーガーメニューを✖印に変更
      $('.hamburger-menu').addClass('open');
      console.log('add');
    }
  });
});

$(() => {
  let param = $(location).attr('search');
  const locate = param.split('page=')[1];
  if(locate == 'login') {
    $('.fa-door-open').hide();
    $('.fa-door-closed').show();
  } else {
    $('.fa-door-open').show();
    $('.fa-door-closed').hide();
  }
})