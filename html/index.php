<?php
/**
*各ページへのルータまたすべてのページで使用するファイルも読み込んでいる
*
*/
ob_start();
session_start();
require './vendor/autoload.php';

/** .envファイルを読み込みます。 */
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();

require_once(__DIR__ . '/function.php');

include(__DIR__ . '/views/header.php');
if ($_GET['page'] == 'login') {
    include(__DIR__ . '/views/login.php');
} elseif ($_GET['page'] == 'signUp') {
    include(__DIR__ . '/views/signUp.php');
} elseif ($_GET['page'] == 'menu') {
    include(__DIR__ . '/views/menu.php');
} elseif ($_GET['page'] == 'logout') {
    include(__DIR__ . '/views/logout.php');
} elseif ($_GET['page'] == 'yourTweets') {
    include("views/your_tweets.php");
} elseif ($_GET['page'] == 'image') {
    include("views/image.php");
} elseif ($_GET['page'] == 'profiles') {
    include("views/profile.php");
} elseif ($_GET['page'] == 'delete') {
    include(__DIR__ . '/views/delete.php');
} else {
    include(__DIR__ .'/views/home.php');
}
include("views/footer.php");
