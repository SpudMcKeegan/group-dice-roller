<?php 
	session_start();
	$sessionName = $_SESSION['sessionName'];
	
	require_once("db-connect.php");

	$delete = "DROP TABLE `". $sessionName . "`";
	$deleteUsers = "DELETE FROM Users WHERE sessionName = '". $sessionName . "'";
	$cancelSession = "UPDATE sessions SET active = '0' WHERE sessionName = '". $sessionName . "'";
	
	mysql_query($delete) or die(mysql_error());
	mysql_query($deleteUsers) or die(mysql_error());
	mysql_query($cancelSession) or die(mysql_error());
	
	unset($_SESSION);
	session_destroy();
	header("location:../");
?>