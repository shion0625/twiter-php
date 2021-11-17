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
