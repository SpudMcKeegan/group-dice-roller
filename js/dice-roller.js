//Variables
var roll, die, username,
	sessionName,
	intVal, time,
	usersIntVal;
	timeLeft = 60000, 
	maxTime = 60000, 
	startTime = 0;
	oneSec = 1000,
	highestId = 0;

//Stuff to do when the document is ready
$(document).ready(function(){
	//Starts intervals
	startSession();
	usersIntVal = setInterval(function(){checkUsers();}, (oneSec * 5));
	//clockIntVal = setInterval(function(){runClock();}, oneSec);
	
	$("#restart_session").hide();	

	//Menu Button Click Commands
	$("#stop").click(function(){ 
		stopSession();
		$('#restart_session').show(); 
		$(this).hide(); 
		$('#clear_session').hide();
	});
	$("#clear_session").click(function(){ clearSession(); });
	$("#restart_session").click(function(){	
		startSession();
		$('#stop').show(); 
		$(this).hide(); 
		$('#clear_session').show(); 
	});
	$("#end_session").click(function(){ window.location = "php/delete-session.php"; });
	$("#logout").click(function(){ window.location = "php/logout.php"; });
});

//Clears the session and deletes all data from table
function clearSession(){
	var ajaxRequest;
	ajaxRequest = new XMLHttpRequest();
	
	ajaxRequest.open("GET", "AJAX/clear-session.php", true);
	ajaxRequest.send(null);
	
	$('.column').each(function(){ $(this).empty(); });
	
	highestId = 0;
}

//Starts the session. This includes all intervals and roll button clicks
function startSession(){
	checkUsers();
	intVal = setInterval(function(){
		checkSession();
		if($('#checkSession').html() == 'delete'){window.location = "../";}
		checkRolls();
	}, oneSec);
	
	$("#roll-area").on('click', '.columnWrapper input', function(){
		die = $(this).attr('value');
		roll = rollDice(die);
		addRoll(die, roll);
	});
}

//Stops the session. Removes roll button clicks AND stops the clock
function stopSession(){
	$("#roll-area").off('click', '.columnWrapper input', function(e){
		//Stop from adding rolls
	});
	//clearInterval(clockIntVal);
	clearInterval(intVal);
}

//Rolls the dice
function rollDice(d){
	var ranNum = Math.floor((Math.random()*d)+1);
	return ranNum;
}

//Runs the clock
function runClock(){
	startTime += oneSec;
	time = convertToNormalTime(timeLeft);
	$("#timeLeft").html(time);
}

//Converts time to a standard looking time
function convertToNormalTime(time){
	var minutes, seconds;
	
	minutes = Math.floor(time / maxTime);
	secondsStart = time % maxTime;
	seconds = secondsStart / oneSec;
	
	return pad(minutes) + ":" + pad(seconds);
}

//Resets Time
function resetTime(){
	timeLeft = startTime;
}

//Puts a 0 infront of any numbers that are less than 10
function pad(n) {
	return (n < 10) ? ("0" + n) : n;
}

//------------------------------------------
// 				 ajax calls
//------------------------------------------

//Adds roll to specific column
function addRoll(d, r){
	var ajaxRequest;
	ajaxRequest = new XMLHttpRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			$('#data').html(ajaxRequest.responseText);
		}
	}
	
	var queryString = "?die=" + d;
	queryString += "&roll=" + r;
	
	ajaxRequest.open("GET", "AJAX/dice-roller.php" + queryString, true);
	ajaxRequest.send(null);
}

//Checks to see if the session has ended
function checkSession(){
	var ajaxRequest;
	ajaxRequest = new XMLHttpRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			$('#checkSession').html(ajaxRequest.responseText);
		}
	}
	
	ajaxRequest.open("GET", "AJAX/terminate-session.php", true);
	ajaxRequest.send(null);
}

//Checks to see which users are logged in
function checkUsers(){
	var ajaxRequest;
	ajaxRequest = new XMLHttpRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			$('#users #active').html(ajaxRequest.responseText);
		}
	}
	
	ajaxRequest.open("GET", "AJAX/check-users.php", true);
	ajaxRequest.send(null);
}

//Function checks for newly added rolls to the database
function checkRolls(){
	//stop interval
	stopSession();
	
	var currentId = 0, newRolls;
	// - Get highest id of all rolls currently posted
	$('.roll').each(function(){
		currentId = $(this).attr('data-id');
		if(parseInt(currentId) > parseInt(highestId)){highestId = currentId;}
	});
	
	// - Use highest-id to check to see if new rolls exist
	var ajaxRequest;
	ajaxRequest = new XMLHttpRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			// - if new rolls exist{
			if(ajaxRequest.responseText != ''){
				// - Add news rolls to hidden div
				$('#newRolls').html(ajaxRequest.responseText);
				
				// - Parse through new rows adding each one individually to the correct box
				$('#newRolls .roll').each(function(){
					dice = $(this).attr('data-dice');
					$('#column' + dice).prepend(this);
				});
			}
		}
	}
	ajaxRequest.open("GET", "AJAX/check-rolls.php?id=" + highestId, true);
	ajaxRequest.send(null);	
	
	//restart interval
	startSession();
}