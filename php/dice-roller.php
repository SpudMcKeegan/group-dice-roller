<?php
	//DB Connection Creds and globals vars
	require_once("db-connect.php");
	session_start();
	
	if(@$_GET['die'] && @$_GET['roll']){
		addRoll(@$_GET['die'], @$_GET['roll']);
	}
	
	function addRoll($die, $roll){		
		$insert = "INSERT INTO `fauxgeek_roller`.`" . $_SESSION['sessionName'] . "` (`id`, `name`, `time`, `roll`, `dice`) VALUES (NULL, '" . @$_SESSION['username'] . "', CURRENT_TIMESTAMP, '" . $roll . "', '" . $die . "')";
		
		mysql_query($insert) or die(mysql_error());
	}
?>