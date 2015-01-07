<?php 
	require_once('php/db-connect.php');
	session_start();
	
	if(empty($_SESSION)){header("Location: index.php");}
	$column = array("2","3","4","6","8","10","12","20","100");
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Dice Roller App?</title>
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<link href="css/dice-roller.css" type="text/css" rel="stylesheet" />
	<script src="js/dice-roller.js"></script>
</head>

<body>
	<div id="wrapper">	
		<!--div id="timeLeft"></div-->
		Name:<span id="name"> <?php echo $_SESSION['username']; ?></span><br />
		<?php if($_SESSION['admin'] == 1): ?>
			<button id="stop">Stop Session</button> 
			<button id="restart_session">Restart Session</button> 
			<button id="clear_session">Clear Session</button> 
			<button id="end_session">End Session</button>
		<?php else: ?>
			<button id="logout">Log Out</button>
		<?php endif ?>
		
		<div class="clear"></div>
		<div id="roll-area">
			<?php foreach($column as $c):?>
				<div class="columnWrapper">
					<input type="button" name="roll <?php echo $c ?>" value="<?php echo $c ?>" />
					<div class="column" id="column<?php echo $c ?>">
						<div class="data"></div>
					</div>
				</div>
			<?php endforeach ?>
			<div id="users" class="columnWrapper">
				<h2>Active Users:</h2>
				<div id="active">
				
				</div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<div style="display: none" id="checkSession"></div>
	<div style="display: block" id="newRolls"></div>
</body>
</html>