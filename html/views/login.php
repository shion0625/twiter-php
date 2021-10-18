<?php
require_once __DIR__ . '/../function.php';

  //ログイン状態の場合ログイン後のページにリダイレクト
  fun_require_unlogined_session();
  if($_SERVER['REQUEST_METHOD'] != 'POST') {
    $message = "";
  }
  else {
    //メールアドレスまたはパスワードが送信されて来なかった場合
    $is_pass = true;
    $email =$_POST['email'];
    $password=$_POST['password'];
    if(empty($email)) {
      $message_email = "メールアドレスを入力してください。";
      $is_pass = false;
    }
    if(empty($password)) {
      $message_pw = "パスワードを入力してください。";
      $is_pass = false;
    }
    //メールアドレスとパスワードが送信されて来た場合
    if($is_pass) {
      //post送信されてきたメールアドレスがデータベースにあるか検索
      try {
        $login_query = "SELECT * FROM users WHERE email=:email";
        $stmt = $dbh->prepare($login_query);
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
      $_SESSION['messageAlert'] = fun_h('ログインに失敗しました。');
      header('Location: /?page=login');
      exit();
    }
    //正しいとき
    else {
      session_regenerate_id(TRUE); //セッションidを再発行
      $_SESSION['userID'] = $result['email_encode']; //セッションにログイン情報を登録
      $_SESSION['messageAlert'] = fun_h('ログインに成功しました。');
      header('Location: /');//ログイン後のページにリダイレクト
      exit();
    }
  }
}
$message = fun_h($message);
$message_email = fun_h($message_email);
$message_pw = fun_h($message_pw);

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

<div class="login-all-contents">
  <h2>ログイン</h2>
  <div class="login-box">
    <div class="sns-contents">
      <h3>SNSアカウントでログイン</h3>
    </div>
    <div class="login-contents">
      <div class="message"><?php echo $message;?></div>
      <form action=?page=login method=POST>
        <div class="message"><?php echo $message_email;?></div>
        <input id="input_email" class="login-form-input-email" name="email" type="text" placeholder="メールアドレスを入力して下さい">
        <div id="pwBox">
          <div class="message"><?php echo $message_pw;?></div>
          <input id="input_password" class="login-form-input-pw" name="password" type="password" placeholder="パスワードを入力して下さい"><i id="eye-icon"class="fas fa-eye"></i>
        </div>

        <button class="login-btn">ログイン</button>
      </form>
    </div>
  </div>
</div>

