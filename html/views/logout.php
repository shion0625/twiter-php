<?php
  session_unset();
  session_destroy();
  header("Location: /");
  exit();
?>
<div>
  <h2>ログアウトしました。</h2>
  <a href="/">トップページに戻る</a>
</div>