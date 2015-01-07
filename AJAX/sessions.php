<?php
	//vars
	require_once('../php/db-connect.php');
	$sessionsList = array();
	$joinSession = $_GET['selectedSession'] . "_roller";
	
	$sessions = "SELECT sessionName FROM sessions WHERE active = 1 ORDER BY sessionName;";
	$results = mysql_query($sessions);
	
	while(@$result = mysql_fetch_assoc($results)){
		array_push($sessionsList, $result);
	}
?>
<option value="none">Select a Session:</option>
<?php foreach($sessionsList as $session): ?>
	<option <?php if(@$joinSession == $session['sessionName']):?>selected<?php endif ?> value="<?php echo $session['sessionName'] ?>"><?php echo substr($session['sessionName'], 0, strpos($session['sessionName'], "_roller")); ?></option>
<?php endforeach ?>
<?php if(empty($sessionsList)): ?>
	<option value="none">NO SESSIONS AVAILABLE</option>
<?php endif ?>