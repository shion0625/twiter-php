<?php
require_once __DIR__ . '/../function.php';
session_start();

  //ログイン状態の場合ログイン後のページにリダイレクト
  require_unlogined_session();
  if($_SERVER['REQUEST_METHOD'] != 'POST') {
    $message = "";
  }
  else {
    //メールアドレスまたはパスワードが送信されて来なかった場合
    $is_pass = true;
    $email =$_POST['email'];
    $password=$_POST['password'];
    if(empty($email)) {
      $messageEmail = "メールアドレスを入力してください。";
      $is_pass = false;
    }
    if(empty($password)) {
      $messagePw = "パスワードを入力してください。";
      $is_pass = false;
    }
    //メールアドレスとパスワードが送信されて来た場合
    if($is_pass) {
      //post送信されてきたメールアドレスがデータベースにあるか検索
      try {
        $loginQuery = "SELECT * FROM users WHERE email=:email";
        $stmt = $dbh->prepare($loginQuery);
        $stmt->bindValue(":email", $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
      }
      catch (PDOException $e) {
        exit('データベースエラー');
      }
      //検索したユーザー名に対してパスワードが正しいかを検証
    //正しくないとき
    if (!password_verify($password, $result['password'])) {
      $message="メールアドレスかパスワードが違います";
    }
    //正しいとき
    else {
      session_regenerate_id(TRUE); //セッションidを再発行
      $_SESSION['userID'] = $_POST['email']; //セッションにログイン情報を登録
      header('Location: /');//ログイン後のページにリダイレクト
      exit();
    }
  }
}
$message = h($message);
$messageEmail = h($messageEmail);
$messagePw = h($messagePw);
?>
<script>
//パスワードの可視化と不可視化
$(()=> {
  $('#eye-icon').on('click',() => {
    const input = $('#input_password');
    if (input.attr('type') == 'password') {
      input.attr('type','text');
    } else {
      input.attr('type','password');
    }
    $('#eye-icon').toggleClass('fa-eye');
    $('#eye-icon').toggleClass('fa-eye-slash');
  });
});
</script>

<div id="login_all_contents">
  <h2>ログイン</h2>
  <div id="login">
    <div id="sns_contents">
      <h3>SNSアカウントでログイン</h3>
    </div>
    <div id="login_contents">
      <div class="message"><?php echo $message;?></div>
      <form action=?page=login method=POST>
        <div class="message"><?php echo $messageEmail;?></div>
        <input id="input_email" class="loginForm_input_email" name="email" type="text" placeholder="メールアドレスを入力して下さい">
        <div id="pwBox">
          <div class="message"><?php echo $messagePw;?></div>
          <input id="input_password" class="loginForm_input_pw" name="password" type="password" placeholder="パスワードを入力して下さい"><i id="eye-icon"class="fas fa-eye"></i>
        </div>

        <button id="loginBtn">ログイン</button>
      </form>
    </div>
  </div>
</div>

