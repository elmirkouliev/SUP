<?php

class inbox{ 
	
	protected $network, $user;
	 
	public function __construct($_network,$_user){
		
		$this->network = $_network;
		
		$this->user = $_user;

	}
	
	public function getNetwork(){
		return $this->network;
	}
	
	public function generateThreadItem($data){
		
		echo '<li id="'.$data['id'].'" class="'.$this->getNetwork().'">';
		
			echo '<img src="'.$data['picture'].'" />';
			
			echo '<span class="thread_item_date">'.$data['date'].'</span>';
			
			echo '<span id="'.$data['uid'].'" class="thread_item_name">'.$data['name'].'</span>';
		
			echo '<span class="thread_item_message">'.$data['message'].'</span>';
			
		echo '</li>';
	
	}
	
	public function generateThreadList($data){
		
		echo '<ul id="'.$this->getNetwork().'-thread-list" class="thread-list">';
    
		foreach($data as $thread_item){
        
            $this->generateThreadItem($thread_item);	
        
		}	
		
		echo '</ul>';
	
	}
	
	public function generateComment($data,$skip = false){
		
		echo '<li id="'.$data['id'].'" class="'.$this->getNetwork().'">';
		
			if(!($skip)){
		
				echo '<img src="'.$data['image'].'" />';
				
				echo '<span id="comment_time">'.$data['time'].'</span>';
				
				echo '<span id="comment_name">'.$data['name'].'</span>';
				
			}
		
			echo '<span id="comment_message">'.$data['message'].'</span>';
			
		echo '</li>';
	
	
	}
	
	public function generateThread($data,$id,$receiver){
				
	   echo '<ul id="'.$id.'" class="'.$this->getNetwork().'-thread thread" >';
		
			foreach($data as $comment){
				
				if($comment['name'] == $name && ((strtotime($comment['time']) - $time) < 86400))
				
					$this->generateComment($comment, true);	
				
				else
				
					$this->generateComment($comment, false);	
				
				
				$time = strtotime($comment['time']);
				$name = $comment['name'];
		
			}	
			
		echo '</ul>';
		
		echo '<form id="'.$id.'" class="chat-menu">
        
        	<hr />
            
            <textarea class="chat_message" maxlength="150" placeholder="Write your message here..."></textarea>
			            
            <input type="submit" value="Send" class="chat_send" id="'.$receiver.'"  />
        
        </form>';
	
	}
	
	
	public function mergeThreadLists($lists){
		
		//To be written...	
	
	}
	
}


?>