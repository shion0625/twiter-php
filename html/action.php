<?php
require_once __DIR__ . '/function.php';
session_start();


////////////ユーザの登録///////////////////////////////////////////////
if(!isset($_GET['action'])) {
  header('Location: /../views/login.php');
}else if($_GET['action'] == 'logout') {
    // $regexpEm = '/^[A-Za-z0-9]{1}[A-Za-z0-9_.-]*@{1}[A-Za-z0-9_.-]{1,}\.[A-Za-z0-9]{1,}$/';
    // $regexpPw = '/^(?=.*[A-Z])(?=.*[.?\/-])[a-zA-Z0-9.?\/-]{8,24}$/';
  session_unset();
  session_destroy();
  header('Location: /views/logout.php');
  exit();
  }
?>