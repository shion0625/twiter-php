<?php
/**
 * htmlspecialcharsのラッパー関数
 *
 * @param string $str
 * @return string
 */
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function require_unlogined_session() {
session_start();
  if (isset($_SESSION['email'])) {
    header('Location: /');
    echo "すでにログインしています";
    exit;
  }
}

function require_logined_session() {
//  session_start();
  if (!isset($_SESSION['email'])) {
    header('Location: /login.php');
    exit;
  }
}
/**
 * CSRFトークンの生成
 *
 * @return string トークン
 */
function generate_token()
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
function validate_token($token)
{
    // 送信されてきた$tokenがこちらで生成したハッシュと一致するか検証
    return $token === generate_token();
}
?>
