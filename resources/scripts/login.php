<?php

require_once('../core.inc.php');
require_multi('../connect.inc.php','../classes/user/user.php');

if(!empty($_POST['username']) && !empty($_POST['password'])){
	
	$hash_row = mysql_fetch_assoc(mysql_query('SELECT id FROM users WHERE username = "'.$_POST['username'].'"'));
	$hash_row['id'];
		
	$username = escape_data($_POST['username']);
	$pass = escape_data($_POST['password']);
			
	//Password Hash
	$pass = sha1($pass.md5($hash_row['id']));	
		
	$query = mysql_query("SELECT id,firstname,surname FROM users WHERE username = '".$username."' AND password = '".$pass."' ");
	
	if(mysql_num_rows($query) == 1){//Creds correct
		
		session_start();
	
		$user = new User(mysql_result($query,0,id),mysql_result($query,0,firstname),mysql_result($query,0,surname));
			
		$_SESSION['user'] = serialize($user);
				
		$_SESSION['uid'] = mysql_result($query,0,id);
			
		if(isset($_POST['loginCookie'])){
	
			setcookie("uid",mysql_result($query,0,id), COOKE_TIME,'/');
		
		}
		
		header('Location: /');	
		
	}
	
	else //Creds not recongnized
	
		header('Location: /login');
	
}
	
else //Fields not filled in

	header('Location: /');


?>