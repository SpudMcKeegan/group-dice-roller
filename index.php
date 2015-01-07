<?php
	session_start();
	
	if(@$_SESSION){header("Location: roll-app.php");}	
?>
<?php if(@$_GET['usernameError']=="userExists"): ?>
	<script>alert('The username you\'ve entered has been entered already, please try a different username');</script>
	<?php $joinSession = $_GET['sessionName']; ?>
<?php elseif(@$_GET['sessionError']=="sessionExists"): ?>
	<script>alert('The session name is already taken. Either join the session using the join form or select a different session name.');</script>
	<?php $joinUser = $_GET['username']; ?>
<?php endif ?>
<html>
	<head>
		<style>
			.container{width: 405px; margin: 0px auto;}
			.required{color:#F00; display: none; text-align: center;}
			table tr td{
				width: 150px;
			}
			input{width: 200px;}
			select{width: 200px;}
			.last td{
				border: none;
			}
		</style>
		
		<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
		<script>
			$(document).ready(function(){
				liveSessions();
				//setInterval(function(){liveSessions(), 5000});
				
				$('#join-session').click(function(e){
					var flag = true;
					if($('#username-join').val() == ""){e.preventDefault(); flag = false; $('#username-join-req').show();}
					if($('#session-name-join').val() == "none"){e.preventDefault(); flag = false; $('#session-name-join-req').show();}
					if($('#password-join').val() == ""){e.preventDefault(); flag = false; $('#password-join-req').show();}
				});
				
				$('#new-session').click(function(e){
					var flag = true;
					if($('#username-new').val() == ""){e.preventDefault(); flag = false; $('#username-new-req').show();}
					if($('#session-name-new').val() == ""){e.preventDefault(); flag = false; $('#session-name-new-req').show();}
					if($('#password-new').val() == ""){e.preventDefault(); flag = false; $('#password-new-req').show();}
				});
				
				$('table tr:last').each(function(){
					$(this).addClass('last');
				});
			});
		
			function liveSessions(){
				var ajaxRequest;
				ajaxRequest = new XMLHttpRequest();
				
				ajaxRequest.onreadystatechange = function(){
					if(ajaxRequest.readyState == 4){
						$('#session-name-join').html(ajaxRequest.responseText);
					}
				}
				
				var queryString = "?selectedSession=<?php echo @$joinSession ?>";
				
				ajaxRequest.open("GET", "AJAX/sessions.php" + queryString, true);
				ajaxRequest.send(null);
			}
		</script>
	</head>
	
	<body>
		<div class="container">
			<h1>Create a Session:</h1>
			<form action="php/create-session.php" method="get">
				<table>
					<tr>
						<td>Username:</td>
						<td><input type="text" name="username" value="<?php echo @$createUser ?>" maxlength="12" id="username-new" /></td>
					</tr>
					<tr>
						<td colspan="2"><span class="required" id="username-new-req">Username Required</span></td>
					</tr>
					<tr>
						<td>Name your session:</td>
						<td><input type="text" name="sessionName" value="" maxlength="12" id="session-name-new" /></td>
					</tr>
					<tr>
						<td colspan="2"><span class="required" id="session-name-new-req">Session Name Required</span></td>
					</tr>
					<tr>
						<td>Password:</td>
						<td><input type="text" name="password" value="" maxlength="12" id="password-new" /></td>
					</tr>
					<tr>
						<td colspan="2"><span class="required" id="password-new-req">Password Required</span></td>
					</tr>
					<tr>
						<td></td>
						<td><input type="submit" value="Create Session" id="new-session" /></td>
					</tr>
				</table>
			</form>
			
			<h1>Join a Session:</h1>
			<form action="php/join-session.php" method="get">
				<table>
					<tr>
						<td>Username:</td>
						<td><input type="text" name="username" value="" maxlength="12" id="username-join" /></td>
					</tr>
					<tr>
						<td colspan="2"><span class="required" id="username-join-req">Username Required</span></td>
					</tr>
					<tr>
						<td>Session Name:</td>
						<td>
							<select name="sessionName" id="session-name-join">
								
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<span class="required" id="session-name-join-req">Session Name Required</span>
						</td>
					</tr>
					<tr>
						<td>Password:</td>
						<td><input type="text" name="password" value="" maxlength="12" id="password-join" /></td>
					</tr>
					<tr>
						<td colspan="2"><span class="required" id="password-join-req">Password Required</span></td>
					</tr>
					<tr>
						<td></td>
						<td><input type="submit" value="Join Session" id="join-session" /></td>
					</tr>
				</table>
			</form>
		</div>
	</body>
</html>
