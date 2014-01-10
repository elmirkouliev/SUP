<?php

session_start();

$user =  unserialize($_SESSION['user']);

if(isset($_REQUEST['code']) && $_REQUEST['network'] == 'facebook'){//Facebook API Check
	
	
	$facebook = createFBObject();
						
	$token_url = ('https://graph.facebook.com/oauth/access_token?network=facebook&client_id='.FB_APPID.'&redirect_uri='.ROOT.'?network=facebook'.'&client_secret='.FB_SECRET.'&code='.$_REQUEST['code'].''); 
	
	$response = file_get_contents($token_url);
	
	parse_str($response, $params);
	
	$access_token = $params['access_token'];
	
	$user_data = $facebook->api('/me?fields=name','GET',$params);
	
	if(!empty($access_token) && !empty($user_data['id'])){
	
		if(mysql_num_rows(mysql_query("SELECT * FROM networks WHERE network_id = 'facebook' AND user_id = '".$user->get_user_id()."'")) == 0)
			
			mysql_query("INSERT INTO networks VALUES ('','".$user->get_user_id()."','facebook','".$user_data['name']."','".$user_data['id']."','".$access_token."','')");
			
		else
			mysql_query("UPDATE networks SET token = '".$access_token."',  WHERE user_id = ".$user->get_user_id()." AND network_id = 'facebook' ");
		
	}
	
	header('Location: /'); 
	
}

else if(isset($_REQUEST['code']) && empty($_REQUEST['network'])) //Check for unprepared CODE GET REQUEST
	
	header('Location: /');
	
	
if($_REQUEST['oauth_verifier']){	

	// Create TwitteroAuth object
	$connection = new Twitter(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
	
	// Request access tokens from twitter 
	$user_data = $connection->getAccessToken($_REQUEST['oauth_verifier']);
	
	$userdata = parse_url($user_data, PHP_URL_QUERY);
	
	parse_str($user_data, $user_data);
	
	if(isset($user_data['oauth_token']) && isset($user_data['oauth_token_secret']) && isset($user_data['user_id'])){
		
    	if(mysql_num_rows(mysql_query("SELECT * FROM networks WHERE network_id = 'twitter' AND user_id = '".$user->get_user_id()."'")) == 0){
			
			mysql_query("INSERT INTO networks VALUES ('','".$user->get_user_id()."','twitter','".$user_data['screen_name']."','".$user_data['user_id']."',
			'".$user_data['oauth_token']."','".$user_data['oauth_token_secret']."')");
		}
			
		else{
			
			mysql_query("UPDATE networks SET token = '".$user_data['oauth_token']."',name = '".$user_data['screen_name']."', network_user_id = '".$user_data['user_id']."'
			
			WHERE user_id = '".$user->get_user_id()."' AND network_id = 'twitter' ");
		}
	
	}
	
	unset($_SESSION['oauth_token']);
	unset($_SESSION['oauth_token_secret']);
	
	header('Location: /');
	

}

	


?>