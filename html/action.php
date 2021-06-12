<?php
  if($_GET['action'] == "signUp") {
    $error = "";
    //二重チェック signUp.phpでも同じ確認をしている。
    if (!$_POST['username']) {
      $error = "ユーザ名が入力されていません。";
    } else if (!$_POST['email']) {
      $error = "メールアドレスが入力されていません.";
    } else if(!$_POST['password']) {
      $error = "パスワードが入力されていません.";
    } else {
      print_r("successful");
    }
  }
  echo $error;
?>