<?php
require_once __DIR__ . '/../function.php';
$regexp_em = '/^[A-Za-z0-9]{1}[A-Za-z0-9_.-]*@{1}[A-Za-z0-9_.-]{1,}\.[A-Za-z0-9]{1,}$/';
$regexp_pw = '/^(?=.*[A-Z])(?=.*[.?\/-])[a-zA-Z0-9.?\/-]{8,24}$/';
fun_require_unlogined_session();

if($_SERVER['REQUEST_METHOD'] != 'POST') {
  $message = "";
}
else {
  $is_pass = true;
  $username = $_POST['username'];
  $password = $_POST['password'];
  $email = $_POST['email'];
  if(empty($username)) {
    $message_user = "ユーザ名を入力してください。";
    $is_pass = false;
  }
  if (empty($email)) {
    $message_email = "メールアドレスを入力してください。";
    $is_pass = false;
  } else if(!preg_match($regexp_em, $email)) {
    $message_email = "メールアドレスを正しく入力してください。";
    $is_pass = false;
  }
  if(empty($password)) {
    $message_pw = "パスワードを入力してください。";
    $is_pass = false;
  } else if(!preg_match($regexp_pw, $password)) {
    $message_pw = "パスワードを正しく入力してください。";
    $is_pass = false;
  }
  if($is_pass) {
    try {
      $query = "SELECT * FROM users WHERE email=:email";
      $stmt = $dbh->prepare($query);
      $stmt->bindValue(":email", $email);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }catch (PDOException $e) {
      exit('データベースエラー');
    }
    if($result) {
      //検索して同じメールアドレスが使用されていた！
      $message_alert = "そのメールアドレスは使用されています。";
      $_SESSION['messageAlert'] = fun_h($message_alert);
      header("Location: /?page=signUp");
      exit();
    } else {
      //データベースにユーザの登録を行う!
      try{
        $query = "INSERT INTO users (user_name, password, email, email_encode) VALUES (:username, :password, :email, :email_encode)";
        $stmt = $dbh->prepare($query);
        $stmt->bindValue(":username", $username);
        $stmt->bindValue(":password", password_hash($password,PASSWORD_DEFAULT));
        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":email_encode", password_hash($email,PASSWORD_DEFAULT));
        $flag = $stmt->execute();
      }catch (PDOException $e) {
        exit('データベースエラー');
      }
      if($flag) {
        $message_alert = "ユーザの登録に成功しました。";
        $_SESSION['messageAlert'] = fun_h($message_alert);
        header('Location: /?page=login');
        exit();
      } else {
        $message_alert = "ユーザの登録に失敗しました。もう一度お願いします。";
        $_SESSION['messageAlert'] = fun_h($message_alert);
        header("Location: /?page=signUp");
        exit();
      }
    }
  }
}
$message = fun_h($message);
$message_user = fun_h($message_user);
$message_email = fun_h($message_email);
$message_pw = fun_h($message_pw);
?>

<script>
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

</script>

<div class="signUp-all-contents">
  <div class="sns-contents">
    <h2>SNSアカウントで会員登録</h2>
  </div>
  <div class="signup-contents">
    <h2>会員登録</h2>
    <div class="signup-main">
      <form action="?page=signUp" method="post">
        <div><?php echo $message;?></div>
        <div class="box-setting">
          <p class="require-pos"><label for="input_username">ユーザ名:</label><span class="require">必須</span></p>
          <p class="errMsg"><?php echo $message_user;?></p>
          <input type="text" id="input_username" name="username"placeholder="ユーザー名を入力してください" spellcheck="true">
        </div>
        <div class="box-setting">
          <p class="require-pos"><label for="input_email">メールアドレス:</label><span class="require">必須</span></p>
          <div class="errMsg"><?php echo $message_email?></div>
          <input type="email" id="input_email" name="email" placeholder="メールアドレスを入力してください">
        </div>
        <div class="box-setting">
          <p class="require-pos"><label for="inputPassword">パスワード</label><span class="require">必須</span></p>
          <div class="errMsg"><?php echo $message_pw;?></div>
          <div class="password-box">
            <input type="password" id="inputPassword" name="password" placeholder="パスワードを入力して下さい">
            <i id="eye-icon"class="fas fa-eye"></i>
          </div>
          <p>条件:大文字、小文字、数字、記号のすべてを最低一文字は使用して下さい</p>
          <p>パスワードは8文字以上24文字以下で入力してください。使用可能な記号は(. / ? -)です</p>
        </div>
        <button id="signup-btn">会員登録</button>
      </form>
    </div>
  </div>
</div>