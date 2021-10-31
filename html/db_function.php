<?php
function db_login($dbh, $email) {
  try {
    $login_query = "SELECT * FROM users WHERE email=:email";
    $stmt = $dbh->prepare($login_query);
    $stmt->bindValue(":email", $email);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
  }
  catch (PDOException $e) {
    exit('データベースエラー db_login');
  }
  return $result;
}

function db_signup_check($dbh, $email) {
  try {
    $signup_query = "SELECT * FROM users WHERE email=:email";
    $stmt = $dbh->prepare($signup_query );
    $stmt->bindValue(":email", $email);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
  }catch (PDOException $e) {
    exit('データベースエラー db_signup_check');
  }
  return $result;
}

function db_signup_insert($dbh, $username, $password, $email) {
  try{
    $query = "INSERT INTO users (user_name, password, email, email_encode) VALUES (:username, :password, :email, :email_encode)";
    $stmt = $dbh->prepare($query);
    $stmt->bindValue(":username", $username);
    $stmt->bindValue(":password", password_hash($password,PASSWORD_DEFAULT));
    $stmt->bindValue(":email", $email);
    $stmt->bindValue(":email_encode", password_hash($email,PASSWORD_DEFAULT));
    $flag = $stmt->execute();
  }catch (PDOException $e) {
    $e->getMessage() . PHP_EOL;//エラーが出たときの処理
    exit('データベースエラー db_signup_insert');
  }
  return $flag;
}

function db_user_details($dbh) {
  try {
    $details_query = "SELECT * FROM users WHERE email_encode=:email_encode";
    $stmt = $dbh->prepare($details_query);
    $stmt->bindValue(":email_encode", $_SESSION['userID']);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
  }
  catch (PDOException $e) {
    exit('データベースエラー db_user_details');
  }
  return $result;
}

function db_insert_tweet($dbh, $user_id, $date_time, $tweet_content) {
  try{
    $query = "INSERT INTO tweet (user_id, date_time, tweet_content) VALUES (:user_id, :date_time, :tweet_content)";
    $stmt = $dbh->prepare($query);
    $stmt->bindValue(":user_id", $user_id);
    $stmt->bindValue(":date_time", $date_time);
    $stmt->bindValue(":tweet_content", $tweet_content);
    $flag = $stmt->execute();
  }catch (PDOException $e) {
    exit('データベースエラー db_insert_tweet');
  }
  return $flag;
}

function db_get_tweets($dbh) {
  try {
    $tweets_query = "SELECT u.user_name, t.* FROM users u, tweet t WHERE u.email_encode = t.user_id ORDER BY t.date_time DESC";
    $stmt = $dbh->prepare($tweets_query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  catch (PDOException $e) {
    echo $e;
    exit('データベースエラー db_get_tweets');
  }
  return $result;
}
?>