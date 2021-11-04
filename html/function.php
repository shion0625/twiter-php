<?php

session_start();
$dsn = getenv('DB_DSN');
$user = getenv('DB_USER');
$password = getenv('DB_PASSWORD');
// $dsn = 'mysql:host=mysql;dbname=test;charset=utf8';
// $user = 'root';
// $password = 'root';
$options = array(
  PDO::MYSQL_ATTR_INIT_COMMAND=>"SET CHARACTER SET 'utf8'",
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true
);
error_reporting(E_ALL & ~E_NOTICE);
try {
  $dbh = new PDO($dsn, $user, $password);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  print_r("接続失敗: ".$e->getMessage()."\n");
  exit();
}
/**
 * htmlspecialcharsのラッパー関数
 *
 * @param string $str
 * @return string
 */
function fun_h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

//すでにログインしている場合（ログインページの場合）
function fun_require_unlogined_session() {
  if (isset($_SESSION['userID'])) {
    session_regenerate_id(TRUE);
    header("Location: /");
    // echo "すでにログインしています。";
  exit();
  }
}
//まだログインしているかの判別
// function fun_require_logined_session() {
  // session_regenerate_id(TRUE);
//   if (!isset($_SESSION['userID'])) {
//     header('Location: /?page=login');
//     exit;
//   }
// }

function delete_session() {
  session_unset();
  session_destroy();
  return;
}
/**
 * CSRFトークンの生成
 *
 * @return string トークン
 */
function fun_generate_token()
{
    // セッションIDからハッシュを生成
    return hash('sha256', session_id());
}

/**
 * CSRFトークンの検証
 *
 * @param string $token
 * @return bool 検証結果
 */
function fun_validate_token($token)
{
    // 送信されてきた$tokenがこちらで生成したハッシュと一致するか検証
    return $token === fun_generate_token();
}
?>
