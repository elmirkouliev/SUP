<?php

ob_start();

session_start();

require_once('resources/core.inc.php');
require_once('resources/connect.inc.php');

//Classes
require_multi('resources/api/facebook/facebook.php','resources/api/twitter/twitteroauth.php','resources/classes/user/user.php');

if(loggedin()){
	
	$user =  unserialize($_SESSION['user']);
	
	$user->loginProcess();
	
	$facebook = createFBObject();

	$twitter =  createTWObject();

	//Scripts
	require_multi('resources/scripts/social_check.php');
		
	//Formal
	require_once('resources/structure/head.inc.php');
	require_once('resources/structure/nav.inc.php');
	
		//Unique
		require_once('home/home.php');
	
	require_once('resources/structure/footer.inc.php');

}

else {
	
	//Formal
	require_once('resources/structure/head.inc.php');
	
		//Unique
		require('login/login_main.php');
	
	require_once('resources/structure/footer.inc.php');

}


?>