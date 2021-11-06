<?php

require_once __DIR__ . '/function.php';
session_start();


////////////ユーザの登録///////////////////////////////////////////////
if (!isset($_GET['action'])) {
    header('Location: /../views/login.php');
} elseif ($_GET['action'] == 'delete') {
    exit();
}
