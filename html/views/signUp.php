<?php
require_once __DIR__ . '/../function.php';
$regexpEm = '/^[A-Za-z0-9]{1}[A-Za-z0-9_.-]*@{1}[A-Za-z0-9_.-]{1,}\.[A-Za-z0-9]{1,}$/';
$regexpPw = '/^(?=.*[A-Z])(?=.*[.?\/-])[a-zA-Z0-9.?\/-]{8,24}$/';
require_unlogined_session();
print_r($_SERVER['REQUEST_METHOD']);

if($_SERVER['REQUEST_METHOD'] != 'POST') {
  echo 's';
  $message = "";
}
else {
  echo 1;
  $is_pass = true;
  $username = $_POST['username'];
  $password = $_POST['password'];
  $email = $_POST['email'];
  if(empty($username)) {
    echo 2;
    $messageUser = "ユーザ名を入力してください。";
    $is_pass = false;
  }
  if (empty($email)) {
    echo 3;
    $messageEmail = "メールアドレスを入力してください。";
    $is_pass = false;
  } else if(!preg_match($regexpEm, $email)) {
    echo 4;
    $messageEmail = "メールアドレスを正しく入力してください。";
    $is_pass = false;
  }
  if(empty($password)) {
    echo 5;
    $messagePw = "パスワードを入力してください。";
    $is_pass = false;
  } else if(!preg_match($regexpPw, $password)) {
    echo 6;
    $messagePw = "パスワードを正しく入力してください。";
    $is_pass = false;
  }
  if($is_pass) {
    echo 7;
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
      echo 8;
      //検索して同じメールアドレスが使用されていた！
      $messageAlert = "そのメールアドレスは使用されています。";
      $_SESSION['messageAlert'] = h($messageAlert);
      header("Location: /?page=signUp");
      exit();
    } else {
      echo 9;
      //データベースにユーザの登録を行う!
      try{
        $query = "INSERT INTO users (user_name, password, email) VALUES (:username, :password, :email)";
        $stmt = $dbh->prepare($query);
        $stmt->bindValue(":username", $username);
        $stmt->bindValue(":password", password_hash($password,PASSWORD_DEFAULT));
        $stmt->bindValue(":email", $email);
        $flag = $stmt->execute();
      }catch (PDOException $e) {
        echo "$e";
        exit('データベースエラー');
      }
      if($flag) {
        echo 'a';
        $messageAlert = "ユーザの登録に成功しました。";
        $_SESSION['messageAlert'] = h($messageAlert);
        header('Location: /?page=login');
        exit();
      } else {
        echo 'b';
        $messageAlert = "ユーザの登録に失敗しました。もう一度お願いします。";
        $_SESSION['messageAlert'] = h($messageAlert);
        header("Location: /?page=signUp");
        exit();
      }
    }
  }
}
echo 'c';
$message = h($message);
$messageUser = h($messageUser);
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

<div id="signUp_all_contents">
  <div id="sns_contents">
    <h2>SNSアカウントで会員登録</h2>
  </div>
  <div id="signUp_contents">
    <h2>会員登録</h2>
    <div id="signUp_main">
      <form action="?page=signUp" method="post">
        <div><?php echo $message;?></div>
        <div id="username_box" class="box_setting">
          <p class="require_pos"><label for="input_username">ユーザ名:</label><span class="require">必須</span></p>
          <p class="errMsg"><?php echo $messageUser;?></p>
          <input type="text" id="input_username" name="username"placeholder="ユーザー名を入力してください" spellcheck="true">
        </div>
        <div id="email_box" class="box_setting">
          <p class="require_pos"><label for="input_email">メールアドレス:</label><span class="require">必須</span></p>
          <div class="errMsg"><?php echo $messageEmail?></div>
          <input type="email" id="input_email" name="email" placeholder="メールアドレスを入力してください">
        </div>
        <div class="box_setting">
          <p class="require_pos"><label for="input_password">パスワード</label><span class="require">必須</span></p>
          <div class="errMsg"><?php echo $messagePw;?></div>
          <div id="password_box">
            <input type="password" id="input_password" name="password" placeholder="パスワードを入力して下さい">
            <i id="eye-icon"class="fas fa-eye"></i>
          </div>
          <p>条件:大文字、小文字、数字、記号のすべてを最低一文字は使用して下さい</p>
          <p>パスワードは8文字以上24文字以下で入力してください。使用可能な記号は(. / ? -)です</p>
        </div>
        <button id="signUpBtn">会員登録</button>
      </form>
    </div>
  </div>
</div>