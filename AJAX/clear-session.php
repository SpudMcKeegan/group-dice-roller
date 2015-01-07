<?php
	session_start();
	require_once('../php/db-connect.php');
		
	$deleteTable = "TRUNCATE TABLE `" . $_SESSION['sessionName'] . "`";
	mysql_query($deleteTable);
?>