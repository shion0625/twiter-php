<?php

$regexp_em = '/^[A-Za-z0-9]{1}[A-Za-z0-9_.-]*@{1}[A-Za-z0-9_.-]{1,}\.[A-Za-z0-9]{1,}$/';
$regexp_pw = '/^(?=.*[A-Z])(?=.*[.?\/-])[a-zA-Z0-9.?\/-]{8,24}$/';
fun_require_unlogined_session();


if(isset($_POST['submit'])) {
  $is_pass = true;
  $username = fun_h($_POST['username']);
  $password = fun_h($_POST['password']);
  $email = fun_h($_POST['email']);
  if(empty($username)) {
    $error['user'] = "ユーザ名を入力してください。";
    $is_pass = false;
  }
  if (empty($email)) {
    $error['email'] = "メールアドレスを入力してください。";
    $is_pass = false;
  } else if(!preg_match($regexp_em, $email)) {
    $error['email'] = "メールアドレスを正しく入力してください。";
    $is_pass = false;
  }
  if(empty($password)) {
    $error['password'] = "パスワードを入力してください。";
    $is_pass = false;
  } else if(!preg_match($regexp_pw, $password)) {
    $error['password'] = "パスワードを正しく入力してください。";
    $is_pass = false;
  }
  if($is_pass) {
    $result = db_signup_check($email);
    if($result) {
      //検索して同じメールアドレスが使用されていた！
      $message_alert = "そのメールアドレスは使用されています。";
      $_SESSION['messageAlert'] = fun_h($message_alert);
      header("Location: /?page=signUp");
      exit();
    } else {
      //データベースにユーザの登録を行う!
      $flag = db_signup_insert($username, $password, $email);
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
      <form action="" method=POST>
        <?php if($error['invalid']):?>
          <p class="errMsg">
            <?php echo $error['invalid'];?>
          </p>
          <?php endif;?>
        <div class="box-setting">
          <p class="require-pos">
            <label for="input_username">ユーザ名:</label>
            <span class="require">必須</span>
          </p>
          <?php if($error['user']):?>
            <p class="errMsg">
              <?php echo $error['user'];?>
            </p>
          <?php endif;?>
          <input type="text" id="input_username" name="username"placeholder="ユーザー名を入力してください" spellcheck="true" value= "<?php print($username)?>">
        </div>
        <div class="box-setting">
          <p class="require-pos">
            <label for="input_email">メールアドレス:</label>
            <span class="require">必須</span>
          </p>
          <?php if($error['email']): ?>
            <p class="errMsg">
              <?php echo $error['email'];?>
            </p>
          <?php endif;?>
          <input type="email" id="input_email" name="email" placeholder="メールアドレスを入力してください">
        </div>
        <div class="box-setting">
          <p class="require-pos">
            <label for="inputPassword">パスワード</label>
            <span class="require">必須</span>
          </p>
          <?php if($error['password']):?>
            <p class="errMsg">
              <?php echo $error['password'];?>
            </p>
          <?php endif;?>
          <div class="password-box">
            <input type="password" id="inputPassword" name="password" placeholder="パスワードを入力して下さい">
            <i id="eye-icon"class="fas fa-eye"></i>
          </div>
          <p>条件:大文字、小文字、数字、記号のすべてを最低一文字は使用して下さい</p>
          <p>パスワードは8文字以上24文字以下で入力してください。使用可能な記号は(. / ? -)です</p>
        </div>
        <button name="submit" id="signup-btn" type>会員登録</button>
      </form>
    </div>
  </div>
</div>