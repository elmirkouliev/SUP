<?php

global $user,$twitter;

class fb_inbox extends inbox{ 

	public function __construct(){
				
	}
	
	public function getInboxData(){
		
		
		/*$timeline = $twitter->get('https://api.twitter.com/1.1/account/verify_credentials.json');
		
		print_r($timeline);*/
		
		
		/*foreach($timeline as $message){
			echo $message['sender_screen_name'];
			echo $message['text'].'<br>';
		}
		*/
		
	}
	
	public function getThread(){
		return $this->network;
	}
	

	
	
}
?>