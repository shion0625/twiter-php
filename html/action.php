<?php
$dsn = 'mysql:host=mysql;dbname=test;charset=utf8';
$user = 'root';
$password = 'root';
$options = array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET CHARACTER SET 'utf8'");
error_reporting(E_ALL & ~E_NOTICE);

//htmlspecialchars 関数
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}


////////////ユーザの登録///////////////////////////////////////////////////
  if($_GET['action'] == "signUp") {
    //database connection
    try {
      $dbh = new PDO($dsn, $user, $password);
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      print_r("接続失敗: ".$e->getMessage()."\n");
      exit();
    }
    //フロントサイドから送られてきた情報のチェック
    //一つの連想配列にして各分岐で値を追加それで分ける!

    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $regexpEm = '/^[A-Za-z0-9]{1}[A-Za-z0-9_.-]*@{1}[A-Za-z0-9_.-]{1,}\.[A-Za-z0-9]{1,}$/';
    $regexpPw = '/^(?=.*[A-Z])(?=.*[.?\/-])[a-zA-Z0-9.?\/-]{8,24}$/';
    //メールアドレスの確認とすでに使用されているメールアドレスかのテェック
    if(preg_match($regexpEm,$email)) {
      $query = "SELECT * FROM users WHERE email=:email";
      $stmt = $dbh->prepare($query);
      $stmt->bindValue(":email", $email);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      if($result) {
        //検索して同じメールアドレスが使用されていた！
        echo "すでにそのメールアドレスは使用されています。。";
      } else {
        //検索して同じメールアドレスがなかった!
        //データベースにユーザの登録を行う!
        $query = "INSERT INTO users (user_name, password, email) VALUES (:username, :password, :email)";
        $stmt = $dbh->prepare($query);
        $stmt->bindValue(":username", $username);
        $stmt->bindValue(":password", $password);
        $stmt->bindValue(":email", $email);
        $flag = $stmt->execute();
        if($flag) {
          echo "ユーザの登録に成功しました。";
        } else {
          echo "ユーザの登録に失敗しました。";
        }
      }
    } else {
      print_r('4\n');
      //適切なメールアドレスで無い
      echo "メールアドレスが間違っています。";
    }
//ログインの場合/////////////////////////////////////////////////
  } else if($_GET['action'] == 'login') {
    //database connection
    try {
      $dbh = new PDO($dsn, $user, $password);
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      print_r("接続失敗: ".$e->getMessage()."\n");
      exit();
    }
    $email = $_POST['email'];
    $password = $_POST['password'];
    // $regexpEm = '/^[A-Za-z0-9]{1}[A-Za-z0-9_.-]*@{1}[A-Za-z0-9_.-]{1,}\.[A-Za-z0-9]{1,}$/';
    // $regexpPw = '/^(?=.*[A-Z])(?=.*[.?\/-])[a-zA-Z0-9.?\/-]{8,24}$/';
    $loginQuery = "SELECT * FROM users WHERE password=:password AND email=:email";
    $stmt = $dbh->prepare($loginQuery);
    $stmt->bindValue(":password", $password);
    $stmt->bindValue(":email", $email);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if($result) {
      echo json_encode($result, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
    } else {
      echo false;
    }
  }
?>