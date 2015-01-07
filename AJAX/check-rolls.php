<?php
	//DB Connection Creds and globals vars
	require_once('../php/db-connect.php');
	session_start();
	$rolls = array();

	$newRollsQuery = "SELECT * FROM " . $_SESSION['sessionName'] . " WHERE id > '" . $_GET['id'] . "'";
	
	$newRolls = mysql_query($newRollsQuery);
	
	while($row = mysql_fetch_assoc($newRolls)){
		array_push($rolls, $row);
	}
?>
<?php foreach($rolls as $roll): ?>
	<p class="roll" data-id="<?php echo $roll['id'] ?>" data-dice="<?php echo $roll['dice'] ?>"><?php echo $roll['name'] ?>: <?php echo $roll['roll'] ?><br /> <?php echo $roll['time'] ?></p>
<?php endforeach ?>