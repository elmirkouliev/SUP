<?php

require_once('connect.inc.php');

function require_multi($files) {
	
	$files = func_get_args();
	foreach($files as $file)
		require_once($file);

}

function loggedin(){
	
	if($_COOKIE['uid'] != ''){
		
		$query = mysql_query("SELECT id,firstname,surname FROM users WHERE id = '".$_COOKIE['uid']."'");
		
		$cur_user = new User(mysql_result($query,0,id),mysql_result($query,0,firstname),mysql_result($query,0,surname));
		
		$_SESSION['current_user'] = serialize($cur_user);
		
		$_SESSION['uid'] = mysql_result($query,0,id);
		
		return true;
		
	}
	
	else if(isset($_SESSION['uid'])){
		return true;
	}

	else 
		return false;
}
	
	
function escape_data($data) {

	if (function_exists('mysql_real_escape_string')) {
		global $dbc; // Need the connection.
		$data = mysql_real_escape_string(trim($data), $dbc);
		$data = strip_tags($data);
		
	} 
	else {
		$data = mysql_escape_string (trim($data));
		$data = strip_tags($data);
	}

	// Return the escaped value.
	return $data;

}

function createFBObject() {
	
	require_once('api/facebook/facebook.php');
	
	//Facebook Object Config
	$config = array();
	$config['appId'] = FB_APPID;
	$config['secret'] = FB_SECRET;
	
	return new Facebook($config);
	
}

function createTWObject(){
	
	require_once('api/twitter/twitteroauth.php');
	
	if($user =  unserialize($_SESSION['user'])){
		
		$network_data = $user->getNetworkData('twitter');
		
		if(!empty($network_data['token']) && !empty($network_data['token_secret']))
		
			return new Twitter(TW_CONSUMER_KEY,TW_CONSUMER_SECRET,$network_data['token'],$network_data['token_secret']);
	}

	else
	
		return new Twitter(TW_CONSUMER_KEY,TW_CONSUMER_SECRET);
}

/*function getFbData($id){
		
	$facebook = createFBObject();
	
	$access_token = mysql_result(mysql_query('SELECT access_token FROM user_networks WHERE network_id = "facebook" AND user_id = "'.$id.'"'),0,'access_token');
	
	$params = array('access_token'=>$access_token);
	
	if(($user_data = $facebook->api('/me?fields=link','GET',$params)) === false)
		return false;
	else
		return $user_data;
}*/

function time_elapsed_string($ptime) {

	$etime = time() - $ptime;
	
	if ($etime < 31) {
		return 'just now';
	}
	
	$a = array( 12 * 30 * 24 * 60 * 60  =>  'year',
				30 * 24 * 60 * 60       =>  'month',
				24 * 60 * 60            =>  'day',
				60 * 60                 =>  'hour',
				60                      =>  'minute',
				1                       =>  'second'
				);
	
	foreach ($a as $secs => $str) {
		$d = $etime / $secs;
		if ($d >= 1) {
			$r = round($d);
			return $r . ' ' . $str . ($r > 1 ? 's ago' : ' ago');
		}
	}
}


?>