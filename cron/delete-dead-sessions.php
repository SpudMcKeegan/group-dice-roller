<?php
	require_once('../db-connect.php');

	$deadSessions = "DELETE FROM sessions WHERE active = 0";
	
	mysql_query($deadSessions);
?>