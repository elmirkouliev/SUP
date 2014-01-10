<?php
	
	require_once('../resources/core.inc.php');
	require_once('../resources/connect.inc.php');

	require_multi('../resources/api/facebook/src/facebook.php','../resources/api/linkedin/linkedin.php');
	require_once('../resources/classes/user/user.php');
	
	$facebook = createFBObject();
	$linkedIn = createLIObject('');
	
	require_once('../resources/structure/head.inc.php');

?>
<div id="panel_wrap">

	<p>Your credentials were not recognized !</p>
 	
     <form action="/resources/scripts/login.php" method="post" id="panel_form"  >
        
        <input type="text" name="username" placeholder="Email" /><br />
        <input type="password" name="password" placeholder="Password" /><br />
        <input type="submit" value="Login" />
        <!--<br /><input type="checkbox" name="loginCookie" value="Remember Me" />Remember Me-->
        
    
    </form>
    
</div>

<?php
	
	require_once('../resources/structure/footer.inc.php');

?>