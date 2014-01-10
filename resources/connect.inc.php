<?php

//All of these universal definitions will be relative to your app, make sure you change them!

//DB
DEFINE ('DBUSER', 'Your DB username');
DEFINE ('DBPW', 'Your DB password');
DEFINE ('DBHOST', 'Your DB Host');
DEFINE ('DBNAME', 'sup');

//Facebook
DEFINE ('FB_APPID','FB_APPI_ID');
DEFINE ('FB_SECRET','FB_SECRET');

//Twitter
DEFINE ('TW_CONSUMER_KEY','TWITTER CONSUMER KEY');
DEFINE ('TW_CONSUMER_SECRET','TWITTER SECRET');

//Universal
DEFINE ('ROOT','http://sup.com/');//This root is needed for api requests so there is a safe redirect, set it accordingly to your app
DEFINE ('COOKIE_DOMAIN',$_SERVER['HTTP_HOST'] == 'localhost' ? null : $_SERVER['HTTP_HOST']);
DEFINE ('COOKE_TIME',time() + 60 * 60 * 24);

error_reporting(E_ERROR | E_WARNING | E_PARSE);

date_default_timezone_set("America/New_York");//Feel free to change this as well

if ($dbc = mysql_connect(DBHOST, DBUSER, DBPW)) {
	
	if (!mysql_select_db (DBNAME)) { // If it can't select the database.
	
		trigger_error("Could not select the database!<br />");

		exit();
	}
	
	mysql_query("SET timezone = 'America/New_York'");
} 

else {

	die("Could not connect to MySQL!<br /> ");
	
	exit();
	
}

?>
