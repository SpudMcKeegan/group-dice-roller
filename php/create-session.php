<?php
	require_once("db-connect.php");
	include("sanitize.php");
	
	//vars
	$sessionName = $_GET['sessionName'];
	$sessionName .= "_roller";
	$password = $_GET['password'];
	$username = $_GET['username'];
	
	$sessionCheck = "SELECT sessionName FROM sessions WHERE sessionName = '" . sanitize($sessionName) . "'";
	$sessionResults = mysql_query($sessionCheck);
	
	//If session is repeated, set $sessionNameRepeat to that name.
	while($row = mysql_fetch_assoc($sessionResults)){		
		$sessionNameRepeat = $row['sessionName'];
	}
	
	if(isset($sessionNameRepeat)){
		header("Location: ../index.php?sessionError=sessionExists&username=" . $username);
	}else{
		echo "else";
		$createTable =	"CREATE TABLE `fauxgeek_roller`.`" . sanitize($sessionName) . "` (
						`id` int( 11 ) NOT NULL AUTO_INCREMENT ,
						`name` varchar( 11 ) NOT NULL ,
						`time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
						`roll` int( 11 ) NOT NULL ,
						`dice` varchar( 4 ) NOT NULL ,
						PRIMARY KEY ( `id` )
						) ENGINE = MYISAM DEFAULT CHARSET = latin1;";
						
		$userInsert = "INSERT INTO `fauxgeek_roller`.`Users` (`id`, `Name`, `sessionName`, `Admin`) VALUES (NULL, '" . sanitize($username)  . "', '" . sanitize($sessionName) . "', 1);";
		$sessionInsert = "INSERT INTO `fauxgeek_roller`.`sessions` (`id`, `sessionName`, `Password`, `Time`, `active`) VALUES (NULL, '" . sanitize($sessionName)  . "', '" . sanitize($password) . "', 60000, 1);";
		
		//Connection to DB
		try{
			echo "in try";	
			mysql_query($createTable);
			mysql_query($sessionInsert);
			mysql_query($userInsert);
			
			//Create Session - Remove querystrings.
			session_start();
			$_SESSION['username'] = $username;
			$_SESSION['sessionName'] = $sessionName;
			$_SESSION['admin'] = 1;
			
			//redirect to app
			header("Location: ../roll-app.php");
		}catch(Exception $e){
			header("Location: ../index.php");
		}
	}
?>