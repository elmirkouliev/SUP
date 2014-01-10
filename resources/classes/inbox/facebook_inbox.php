<?php

require_once('inbox.php');

require_once('../user/user.php');

class facebook_inbox extends inbox{
		
	private $facebook;
	
	public function __construct($_facebook,$_user){

		parent::__construct('facebook',$_user);
		
		$this->facebook = $_facebook;
	
	}
	
	public function getThreadList(){
					
		$data = array();
		
		$params = array('access_token'=>$this->user->getAccessToken('facebook'));
		
		$messages = $this->facebook->api('/me?fields=inbox.fields(to.fields(name,id,picture),comments.limit(1))','GET',$params);

		$fb_id = $messages['id'];
		
		$messages = $messages['inbox']['data'];
		
		for($i = 0 ; $i < sizeof($messages); $i ++){
			
			$uid = '';
			$name = '';
			$picture = NULL;
		
			if(sizeof($messages[$i]['to']['data']) > 2){
				
				for($d = 0; $d < 4 ; $d++){
				
					if($fb_id != $messages[$i]['to']['data'][$d]['id'])
					
						$picture[] = $messages[$i]['to']['data'][$d]['picture']['data']['url'];
						$name .= $messages[$i]['to']['data'][$d]['name'].', ';
				
				}
				
				$c = sizeof($messages[$i]['to']['data']) - $d;
				
				if($c > 0 ) $name .= ' and '.$c.' others';
				
			}
			
			else{
			
				if($fb_id != $messages[$i]['to']['data'][0]['id']){
				
					$uid = $messages[$i]['to']['data'][0]['id'];
					$name = $messages[$i]['to']['data'][0]['name'];
					$picture = $messages[$i]['to']['data'][0]['picture']['data']['url'];
				}
				
				else{
					
					$uid = $messages[$i]['to']['data'][1]['id'];
					$name =  $messages[$i]['to']['data'][1]['name'];
					$picture =  $messages[$i]['to']['data'][1]['picture']['data']['url'];
				
				}
				
			}
			
			$message = $messages[$i]['comments']['data'][0]['message'];
			
			$time = $messages[$i]['comments']['data'][0]['created_time'];
			
			if (date('Y-m-d') == date('Y-m-d', strtotime($time))) {
				$time =  date('g:i',strtotime($time));
			}
			else
				$time = date('M-j',strtotime($time));
				
			
			$id = $messages[$i]['id'];
				
			
			$data[] = array("name"=>$name,"picture"=>$picture,"uid"=>$uid,"message"=>$message,"time"=>$time,"id"=>$id);	
			
				
		}
		
		return $data;
	
	}
	
	public function getComments($id,$receiver){
		
		$data = array();
		
		$params = array('access_token'=>$this->user->getAccessToken('facebook'));
		
		$messages = $this->facebook->api('/'.$id.'?fields=to,comments.fields(message,from)','GET',$params);
		
		$user_info = $this->facebook->api('/me?fields=picture','GET',$params);
		
		$user_id = $user_info['id'];
		
		$user_img = $user_info['picture']['data']['url'];
		
		$receiver_info = $this->facebook->api('/'.$receiver.'?fields=picture','GET',$params);
			
		$receiver_img = $receiver_info['picture']['data']['url'];
		
		$messages = $messages['comments']['data'];
		
		for($i = 0 ; $i < sizeof($messages); $i++){
			
			$name = $messages[$i]['from']['name'];
			$uid = $messages[$i]['from']['id'];
			$message = $messages[$i]['message'];
			$time = $messages[$i]['created_time'];
			
			if($user_id != $uid)
			
				$img = $receiver_img;
				
			else
			
				$img = $user_img;
			
			if (date('Y-m-d') == date('Y-m-d', strtotime($time))) {
				$time =  date('g:i',strtotime($time));
			}
			else
				$time = date('M-j',strtotime($time));
			
			
			$data[] = array("name"=>$name,'image'=>$img,"uid"=>$uid,"message"=>$message,"time"=>$time,);	
			
		}
		
		return $data;
		
	}
	
}

?>