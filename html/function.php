<?php
$dsn = 'mysql:host=mysql;dbname=test;charset=utf8';
$user = 'root';
$password = 'root';
try {
  $db = new PDO($dsn, $user, $password);
  echo "接続成功\n";
} catch (PDOException $e) {
  echo "接続失敗: ".$e->getMessage()."\n";
  exit();
}