<?php
	include("./function.php");
	include("./views/header.php");
	if($_GET['page'] == 'login') {
		include("./views/login.php");
	} else if($_GET['page'] == 'signUp') {
		include("./views/signUp.php");
	} else if($_GET['page'] == 'menu') {
		include("./views/menu.php");
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
	// include("views/footer.php");

?>