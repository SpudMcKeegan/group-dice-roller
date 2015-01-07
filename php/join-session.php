<?php
	//vars
	$sessionName = $_GET['sessionName'];
	$password = $_GET['password'];
	$username = $_GET['username'];
	
	require_once("php/db-connect.php");
	require_once("sanitize.php");
	
	$userCheck = "SELECT Name FROM Users WHERE Name = '" . $username . "' AND sessionName = '" . $sessionName . "'";
	$userResults = mysql_query($userCheck);
	
	//echo "$userCheck<br />";
	//echo "$userResults<br />";
	
	while($row = mysql_fetch_assoc($userResults)){		
		//var_dump($row);
		$userNameRepeat = $row['Name'];
	}
	
	//echo "<br />$row";
	//echo "<br />$userNameRepeat";
	
	if(isset($userNameRepeat)){
		header("Location: ../index.php?usernameError=userExists&sessionName=" . substr($sessionName, 0, strpos($sessionName, "_roller")));
	}else{
		$sessionGet = "SELECT sessionName, password FROM `fauxgeek_roller`.`sessions` WHERE sessionName = '" . sanitize($sessionName) . "' AND password = '" . sanitize($password) . "';";
		$session_id = mysql_query($sessionGet) or die(mysql_error());
			
		while($row = mysql_fetch_assoc($session_id)){$result = $row;}
		
		if(@$result){
			$userInsert = "INSERT INTO `fauxgeek_roller`.`Users` (`id`, `Name`, `sessionName`, `Admin`) VALUES (NULL, '" . sanitize($username)  . "', '" . sanitize($sessionName) . "', 0);";
			
			mysql_query($userInsert) or die(mysql_error());
			
			session_start();
			unset($_SESSION['username']);
			unset($_SESSION['sessionName']);
			unset($_SESSION['admin']);
			$_SESSION['username'] = $username;
			$_SESSION['sessionName'] = $sessionName;
			$_SESSION['admin'] = 0;
			
			//redirect to app
			header("Location: ../roll-app.php");
		}else{
			//redirect to homepage
			header("Location: ../index.html");
		}
	}
?>