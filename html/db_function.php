<?php

function connect_db()
{
    // .envを使用する
    // $dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
    // $dotenv->load();
    $dsn = getenv('DB_DSN');
    $user = getenv('DB_USER');
    $password = getenv('DB_PASSWORD');
    try {
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        print_r("connect_db 接続失敗: ".$e->getMessage()."\n");
        // print_r($e);
        exit();
    }
    return $dbh;
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
