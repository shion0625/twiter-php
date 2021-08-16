<?php
$dsn = 'mysql:host=mysql;dbname=test;charset=utf8';
$user = 'root';
$password = 'root';
$options = array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET CHARACTER SET 'utf8'");
error_reporting(E_ALL & ~E_NOTICE);
  // require_unlogined_session();
  print_r("1");
  try {
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $e) {
    print_r("接続失敗: ".$e->getMessage()."\n");
    exit();
  }
  //すでにログインしている場合　ログアウトする
  if (isset($_SESSION["login"])) {
    session_regenerate_id(TRUE);
    header("Location: https://www.google.com");
    echo "すでにログインしています。";
    print_r("2");
    exit();
  }
  echo $_SERVER['REQUEST_METHOD'];
  if(!$_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = "メールアドレスとパスワードを入力してください。POSTメソッドで送信してください";
    print_r("3");
  }
  else {
    //メールアドレスまたはパスワードが送信されて来なかった場合
    if(empty($_POST["email"]) || empty($_POST["password"])) {
      $message = "メールアドレスとパスワードを入力してください";
      print_r("4");
    }
    //メールアドレスとパスワードが送信されて来た場合
    else {
      print_r("5");
      //post送信されてきたメールアドレスがデータベースにあるか検索
      try {
        $loginQuery = "SELECT * FROM users WHERE password=:password AND email=:email";
        $stmt = $dbh->prepare($loginQuery);
        $stmt->bindValue(":password", $password);
        $stmt->bindValue(":email", $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        print_r($result);
      }
      catch (PDOExeption $e) {
        exit('データベースエラー');
      }
      //検索したユーザー名に対してパスワードが正しいかを検証
    //正しくないとき
    if (!password_verify($_POST['password'], $result['password'])) {
      $message="メールアドレスかパスワードが違います";
      print_r("6");
    }
    //正しいとき
    else {
      session_regenerate_id(TRUE); //セッションidを再発行
      $_SESSION["email"] = $_POST['email']; //セッションにログイン情報を登録
      header("Location: https://vivaldi.com"); //ログイン後のページにリダイレクト
      echo "ログイン完了しました";
      print_r(7);
      exit();
    }
  }
}
print_r("10");
$message = h($message);
?>

<div id="login_all_contents">
  <h2>ログイン</h2>
  <div id="login">
    <div id="sns_contents">
      <h3>SNSアカウントでログイン</h3>
    </div>
    <div id="login_contents">
      <div class="message"><?php echo $message;?></div>
      <form action=?page=login method=POST>
        <input id="input_email" class="loginForm_input_email" name="email" type="text" placeholder="メールアドレスを入力して下さい">
        <p id="errMsgPw"></p>
        <input id="input_password" class="loginForm_input_pw" name="password" type="password" placeholder="パスワードを入力して下さい">
        <button id="loginBtn">ログイン</button>
      </form>
    </div>
  </div>
</div>

