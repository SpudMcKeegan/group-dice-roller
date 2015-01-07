<?php
	$dbhost = "localhost";
	$dbuser = "fauxgeek_test";
	$dbpass = "test2";
	$dbname = "fauxgeek_roller";
	
	//Connection to DB
	mysql_connect($dbhost, $dbuser, $dbpass);
	mysql_select_db($dbname) or die(mysql_error());
?>