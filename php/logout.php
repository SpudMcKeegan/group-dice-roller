<?php
	//Starting Vars and Settings
	session_start();
	require_once("db-connect.php");
	
	//Delete user from users table
	$deleteUser = "DELETE FROM Users WHERE Name = '". $_SESSION['username'] . "'";
	mysql_query($deleteUser);
	
	//Annihilate session
	unset($_SESSION);
	session_destroy();
	
	//redirect user to login page
	header("Location: ../");
?>