<?php
$dsn = 'mysql:host=mysql;dbname=test;charset=utf8';
$user = 'root';
$password = 'root';
$options = array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET CHARACTER SET 'utf8'");
error_reporting(E_ALL & ~E_NOTICE);

  if($_GET['action'] == "signUp") {
    try {
      $dbh = new PDO($dsn, $user, $password);
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      print_r("接続失敗: ".$e->getMessage()."\n");
      exit();
    }
    $username = $_POST['username'];
    $query = "SELECT * FROM users WHERE user_name=:username";
    $stmt = $dbh->prepare($query);
    $stmt->bindValue(":username", $username);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if($result) {
      print_r("同じ名前のユーザ名が存在する");
    } else {
      print_r("同じ名前のユーザ名が存在しない");
    }

  } else if($_GET['action'] == 'login') {
    $error ="";
    print_r($_POST);
    if (!$_POST['username']) {
      $error = "ユーザ名が入力されていません。";
    } else if(!$_POST['password']) {
      $error = "パスワードが入力されていません.";
    } else {
      print_r("successful");
    }
  }
?>