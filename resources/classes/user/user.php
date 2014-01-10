<?php

class User{ 
	
	private $uid, $firstname, $surname;
	 
	public function __construct($_uid,$_firstname,$_surname){
		
		$this->uid = $_uid;
		$this->firstname = $_firstname;
		$this->surname = $_surname;
		
	}
	
	public function get_user_id(){
		return $this->uid;
	}
	
	public function get_user_name(){
		return mysql_result(mysql_query("SELECT username FROM users WHERE id = '".$this->uid."'"),0,username);
	}
	
	public function getName(){
		return $this->firstname.' '.$this->surname;
	}
	
	public function getAccessToken($network){
		
		$query = mysql_query('SELECT token FROM networks WHERE user_id = '.$this->get_user_id().' AND network_id = "'.$network.'"');
		
		return mysql_result($query,0,token);

	}
	
	public function getNetworkData($network){
			
		$query = mysql_query('SELECT * FROM networks WHERE user_id = '.$this->get_user_id().' AND network_id = "'.$network.'"');
		
		$data = mysql_fetch_assoc($query); 
		
		return $data;
		
	}
	
	public function loginProcess(){ //Social check for login flow
		
		//Loop through list of networks
		$query = mysql_query("SELECT * FROM networks WHERE user_id = '".$this->get_user_id()."'");

		if(mysql_num_rows($query) != 0 ){
	
			while($row = mysql_fetch_assoc($query)){
				
				switch($row['network_id']){
					
					case 'facebook':{
					
						$facebook = createFBObject();
					
						try{
							$params = array('access_token'=>$this->getAccessToken('facebook'));
							
							if($facebook->api('/me?fields=id','GET',$params) !== false)
								$_SESSION['facebook'] = true;
						}
						catch(Exception $e){//Invalid access token
							$_SESSION['facebook'] = false;
						}
					
					}
					break;
					
					case 'linkedin':{
						
						$linkedIn = createLIObject('resources/scripts/login.php/');
				
						if($linkedIn->accessTokenCheck($this->getAccessToken('linkedin')))
							$_SESSION['linkedin'] = true;
						else
							$_SESSION['linkedin'] = false;
					
					}
					break;
					
					case 'twitter':{
						
						$twitter = createTWObject();
					
						if($twitter->checkAccessToken())
							$_SESSION['facebook'] = true;
						else
							$_SESSION['facebook'] = false;
						
					}				
					break;		
				
				}					
			}
		}
	} //Login Process
	
}
?>