<?php
session_start();
	include ( __DIR__ . '/function.php');
	include ( __DIR__ . '/views/header.php');
	if($_GET['page'] == 'login') {
		include ( __DIR__ . '/views/login.php');
	} else if($_GET['page'] == 'signUp') {
		include ( __DIR__ . '/views/signUp.php');
	} else if($_GET['page'] == 'menu') {
		include ( __DIR__ . '/views/menu.php');
	}
	// 	include("views/timeline.php");

	// } else if($_GET['page'] == 'yourtweets') {

	// 	include("views/yourtweets.php");

	// } else if($_GET['page'] == 'search') {

	// 	include("views/footer.php");

	// } else if($_GET['page'] == 'profiles') {

	// 	include("views/profiles.php");
	// } else {

	// 	include("views/home.php");

	// }
	include("views/footer.php");

?>