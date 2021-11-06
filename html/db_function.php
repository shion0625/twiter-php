<?php

function connect_db()
{
    $dsn = getenv('DB_DSN');
    $user = getenv('DB_USER');
    $password = getenv('DB_PASSWORD');
    try {
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        print_r("接続失敗: ".$e->getMessage()."\n");
        exit();
    }
    return $dbh;
}

function db_login($email)
{
    $dbh = connect_db();
    try {
        $login_query = "SELECT * FROM users WHERE email=:email";
        $stmt = $dbh->prepare($login_query);
        $stmt->bindValue(":email", $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        exit('データベースエラー db_login');
    }
    return $result;
}

function db_signup_check($email)
{
    $dbh = connect_db();
    try {
        $signup_query = "SELECT * FROM users WHERE email=:email";
        $stmt = $dbh->prepare($signup_query);
        $stmt->bindValue(":email", $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        exit('データベースエラー db_signup_check');
    }
    return $result;
}

function db_signup_insert($username, $password, $email)
{
    $dbh = connect_db();
    try {
        $query = "INSERT INTO users (user_name, password, email, email_encode) VALUES (:username, :password, :email, :email_encode)";
        $stmt = $dbh->prepare($query);
        $stmt->bindValue(":username", $username);
        $stmt->bindValue(":password", password_hash($password, PASSWORD_DEFAULT));
        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":email_encode", password_hash($email, PASSWORD_DEFAULT));
        $flag = $stmt->execute();
    } catch (PDOException $e) {
        $e->getMessage() . PHP_EOL;//エラーが出たときの処理
        exit('データベースエラー db_signup_insert');
    }
    return $flag;
}

function db_user_details()
{
    $dbh = connect_db();
    try {
        $details_query = "SELECT * FROM users WHERE email_encode=:email_encode";
        $stmt = $dbh->prepare($details_query);
        $stmt->bindValue(":email_encode", $_SESSION['userID']);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        exit('データベースエラー db_user_details');
    }
    return $result;
}

function db_insert_tweet($user_id, $date_time, $tweet_content)
{
    $dbh = connect_db();
    try {
        $query = "INSERT INTO tweet (user_id, date_time, tweet_content) VALUES (:user_id, :date_time, :tweet_content)";
        $stmt = $dbh->prepare($query);
        $stmt->bindValue(":user_id", $user_id);
        $stmt->bindValue(":date_time", $date_time);
        $stmt->bindValue(":tweet_content", $tweet_content);
        $flag = $stmt->execute();
    } catch (PDOException $e) {
        echo $e;
        exit('データベースエラー db_insert_tweet');
    }
    return $flag;
}

function db_get_tweets()
{
    $dbh = connect_db();
    try {
        $query = "SELECT u.user_name, t.*, i.image_type, i.image_content FROM users AS u INNER JOIN tweet AS t ON u.email_encode = t.user_id LEFT OUTER JOIN user_image AS i ON t.user_id = i.user_id ORDER BY t.date_time DESC";
        $stmt = $dbh->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e;
        exit('データベースエラー db_get_tweets');
    }
    return $result;
}

function db_delete_tweet()
{
    $dbh = connect_db();
    try {
        $query_delete ="DELETE FROM tweet WHERE post_id=:id";
    } catch (PDOException $e) {
        echo $e;
        exit('データベースエラー db_delete_tweet');
    }
}

function db_get_tweet($post_id)
{
    $dbh = connect_db();
    try {
        $query = "SELECT u.user_name, t.* FROM tweet t INNER JOIN users u ON t.user_id = u.email_encode WHERE t.post_id=:post_id";
        $stmt = $dbh->prepare($query);
        $stmt->bindValue("post_id", $post_id);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e;
        exit('データベースエラー db_get_tweets');
    }
    return $result;
}

function db_get_your_tweets($user_id)
{
    $dbh = connect_db();
    try {
        $query = "SELECT u.user_name, t.* FROM users u INNER JOIN tweet t ON u.email_encode = t.user_id WHERE t.user_id=:user_id ORDER BY t.date_time DESC";
        $stmt = $dbh->prepare($query);
        $stmt->bindValue("user_id", $user_id);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e;
        exit('データベースエラー db_get_tweets');
    }
    return $result;
}

function db_insert_image($name, $type, $content, $size, $user_id)
{
    $dbh = connect_db();
    try {
        $query = "INSERT INTO user_image (image_name, image_type, image_content, image_size, user_id) VALUES (:image_name, :image_type, :image_content, :image_size, :user_id)";
        $stmt = $dbh->prepare($query);
        $stmt->bindValue(':image_name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':image_type', $type, PDO::PARAM_STR);
        $stmt->bindValue(':image_content', $content, PDO::PARAM_STR);
        $stmt->bindValue(':image_size', $size, PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
        $flag = $stmt->execute();
    } catch (PDOException $e) {
        echo $e;
        exit('データベースエラー db_insert_image');
    }
    return $flag;
}

function db_get_user_image($user_id)
{
    $dbh = connect_db();
    try {
        $query = "SELECT * FROM user_image WHERE user_id = :user_id LIMIT 1";
        $stmt = $dbh->prepare($query);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch();
    } catch (PDOException $e) {
        echo $e;
        exit('データベースエラー db_get_user_image');
    }
    return $result;
}
