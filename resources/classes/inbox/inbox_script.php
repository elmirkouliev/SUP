<?php

require_once('../../core.inc.php');

require_multi('facebook_inbox.php','../user/user.php','../xmpp/xmpp.php');

session_start();

$user = unserialize($_SESSION['user']);

if(loggedin()){

if($_REQUEST['id']){
	
	$network = $_REQUEST['id'];
	
	if($network == 'facebook'){
		
		$fb_inbox = new facebook_inbox(createFBOBject(),$user);
		
		/*if(!(file_exists('../../../cache/thread_list/'.$user->get_user_id().'-facebook.json'))){
				
			$data = $fb_inbox->getThreadList();  
			
			file_put_contents('../../../cache/thread_list/'.$user->get_user_id().'-facebook.json',json_encode($data));
		
		}
		
		else{
				
			$data = file_get_contents('../../../cache/thread_list/'.$user->get_user_id().'-facebook.json');
			
			$data = json_decode($data,true);
		
		}*/
		
		$data = $fb_inbox->getThreadList();  
		
		$fp = $fb_inbox->generateThreadList($data);
			
	}
}

if($_REQUEST['message_id'] && $_REQUEST['network'] && $_REQUEST['receiver_id']){
		
	$network = $_REQUEST['network'];
	
	if($network == 'facebook'){
		
		$fb_inbox = new facebook_inbox(createFBOBject(),$user);
			
		/*if(!(file_exists('../../../cache/thread/'.$_REQUEST['message_id'].'-facebook.json'))){
				
			$data = $fb_inbox->getComments($_REQUEST['message_id'],$_REQUEST['img']);
						
			file_put_contents('../../../cache/thread/'.$_REQUEST['message_id'].'-facebook.json',json_encode($data));
		
		}
		
		else{
			
			$data = file_get_contents('../../../cache/thread/'.$_REQUEST['message_id'].'-facebook.json');
			
			$data = json_decode($data,true);
			
		}*/
		
		$data = $fb_inbox->getComments($_REQUEST['message_id'],$_REQUEST['receiver_id']);
		
		$fp = $fb_inbox->generateThread($data,$_REQUEST['message_id'],$_REQUEST['receiver_id']);
		
	
	}	
}

if($_REQUEST['send_message'] == 'true' && $_REQUEST['thread_id']  && $_REQUEST['message'] && $_REQUEST['receiver_id']){
	

	send_message(chatConnect(),$_REQUEST['message'],$_REQUEST['receiver_id']);
	

}




}


?>