<?php
	
	include '../connect.inc.php';
	
	session_start();
	
	session_destroy();
	
	setcookie('uid','',time()-COOKE_TIME,'/');

	header('Location: /');

?>