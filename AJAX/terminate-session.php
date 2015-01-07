<?php
	//DB Connection Creds and globals vars
	require_once('../php/db-connect.php');
	
	session_start();
	
	$query = "SELECT active FROM sessions WHERE sessionName = '" . $_SESSION['sessionName'] . "'";
	$results = mysql_query($query);
	
	while($row = mysql_fetch_array($results)){
		$active = $row['active'];
	}
	
	if($active == "0"){
		session_destroy();
		unset($_SESSION['sessionName']);
		unset($_SESSION['username']);
		unset($_SESSION['admin']);
		echo "delete";
	}
?>