<?php
session_start();
print_r($_SESSION);
?>

<script>
function alert_animation() {
  console.log('alert');
  $('#msgAlert').fadeIn(2000);
  setInterval(() => {
    $('#msgAlert').fadeOut(2000);
      }, 7000);
};
</script>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="../assets/css/style.min.css"> -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">

    <script
    src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
    crossorigin="anonymous"></script>
    <title>twitter</title>
  </head>
  <body>
    <header>
      <div id="header">
        <?php if(!empty($_SESSION['messageAlert'])):?>
          <div class="msg-alert" id="msgAlert">
            <script type="text/javascript">
              alert_animation();
            </script>
            <?php echo $_SESSION['messageAlert'];
            $_SESSION['messageAlert'] = '';
            ?>
          </div>
        <?php endif; ?>
        <div class="header-logo">
          <h1>twitter</h1>
        </div>
        <div class="header-nav">
          <nav>
            <div class="header-item">あなたのタイムライン</div>
            <div class="header-item">あなたのツイート</div>
            <div class="header-item">あなたのプロフィール</div>
          </nav>
        </div>
        <div class="header-signup">
        <?php if(!isset($_SESSION['userID'])) :?>
          <a href="?page=signUp" class="btn btn-flat"><span>会員登録</span></a>
        <?php endif; ?>
        </div>
        <div class="header-right">
          <div class="header-login">
            <?php if(isset($_SESSION['userID'])) :?>
            <a href="?page=logout" alt="ログアウトボタン">
              <!-- <i class="fas fa-door-open"></i> -->
            <i class="fas fa-door-closed"></i>
            <p>ログアウト</p>
          </a>
          <?php else :?>
          <a href="?page=login" alt="ログインボタン"><i class="fas fa-door-open"></i>
            <!-- <i class="fas fa-door-closed"></i> -->
            <p>ログイン</p>
          </a>
          <?php endif; ?>
          </div>
          <div class="header-menu">
            <div class="menu-bar">
              <div class="hamburger-menu">
                <span class="hamburger-menu__line"></span>
              </div>
              <p>メニュー</p>
            </div>
            <nav class="nav-sp">
                <ul>
                  <li><a href="#">あなたのタイムライン</a></li>
                  <li><a href="#">あなたのツイート</a></li>
                  <li><a href="#">あなたのプロフィール</a></li>
                </ul>
              </nav>
          </div>
        </div>
      </div>
    </header>


<script>
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
</script>