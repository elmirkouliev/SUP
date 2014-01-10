<?php

	echo 'Login';

?>

<div id="login_wrap">
 	
    <form action="resources/scripts/login.php" method="post" id="login_form"  >
        
        <input type="text" name="username" style="width:150px;" placeholder="Email" />
        <input type="password" name="password" placeholder="Password" />
        <input type="submit" value="Login" />
        
        <br />
        
        <div id="remember_me">
        
            <input type="checkbox" value="None"  name="loginCookie" />
               
            <span>Keep me logged in</span>
        
        </div>
        
    </form>
    
</div>