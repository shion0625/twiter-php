<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.min.css">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">

  <script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>
  <script src="../js/menuJq.js"rel="stylesheet"></script>
  <title>twitter</title>
</head>
<body>
  <header>
    <div id="header">
      <div id="header_logo">
        <h1>twitter</h1>
      </div>
      <div id="header_nav">
        <nav>
          <div class="header_item">あなたのタイムライン</div>
          <div class="header_item">あなたのツイート</div>
          <div class="header_item">あなたのプロフィール</div>
        </nav>
      </div>
      <div id="header_signUp">
        <a href="?page=signUp" class="btn btn-flat"><span>会員登録</span></a>
      </div>
      <div id="header_right">
        <div id="header_login">
          <a href="?page=login" alt="ログインボタン"><i class="fas fa-door-open"></i>
          <i class="fas fa-door-closed"></i>
          <p>ログイン</p>
        </a>
        </div>
        <div id="header_menu">
          <div id="menu_bar">
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
</body>
</html>