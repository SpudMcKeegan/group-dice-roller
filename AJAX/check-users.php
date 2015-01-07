<?php
	require_once("../php/db-connect.php");
	session_start();
	
	$users = array();
	$select = "SELECT name,admin FROM Users WHERE sessionName = '" . $_SESSION['sessionName'] . "'";
	
	$results = mysql_query($select);
	
	while($row = mysql_fetch_assoc($results)){
		array_push($users, $row);
	}
?>
<ul>
<?php foreach($users as $user): ?>
	<li><?php echo $user['name']; ?><?php if($user['admin'] == '1'){echo " (Admin)";} ?></li>
<?php endforeach ?>
</ul>