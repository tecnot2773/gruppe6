 <?php

	$servername = "localhost";														//server name
	$username = "stationssql";														//login name
	$password = "veve113ppe";														//login password

	// Create connection
	$conn = new mysqli($servername, $username, $password);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);							//error log
	}
	$conn->select_db("stations");													//selet Database
	
	$strQuery = "SET character_set_results = 'utf8', 
	  character_set_client = 'utf8', 
	  character_set_connection = 'utf8', 
	  character_set_database = 'utf8', 
	  character_set_server = 'utf8'";
	$conn->query($strQuery);  
	
	include_once "check_ffn.php";
	include_once "check_bremenvier.php";
	include_once "check_ndr2.php";
	include_once "check_njoy.php";
	include_once "check_bremennext.php";
	include_once "check_1live.php";
	include_once "check_wdr2.php";
	include_once "check_bremeneins.php";
	include_once "check_ndr1.php";
	
	$currentMonth = date("Y-m");			
	$currentDay = date("Y-m-d");			
	$currentHour = date("Y-m-d H");			
	$currentSeconds = date("Y-m-d H:i:s");	
	
	$max = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM station"));																							//check how many stations we have
	for($i = 1; $i <= $max; $i++){
		$dailystatsRows = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM dailyStats WHERE stationId = '$station' and timestamp LIKE '$currentDay%'"));			//Check if dailystats exitst for current day
		if($dailystatsRows == 0){																																	//if not
			mysqli_query($conn, "INSERT INTO dailyStats (stationId, timestamp, replaysPerHour, replaysPerDay, mostReplaysDuring, score) VALUES ('$station', '$currentSeconds', '0', '0', '0', '0')");	//Insert new daiylstats with current timestamp
		}		
		$hourlystatsRows = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM hourlyStats WHERE stationId = '$station' and timestamp LIKE '$currentHour%'"));		//Check if hourlystats exitst for current hour
		echo $hourlystatsRows ." durchlauf" .  $i . "<br>";
		if($hourlystatsRows == 0){																																	//if not
			mysqli_query($conn, "INSERT INTO hourlyStats (stationId, timestamp, replaysPerHour, score) VALUES ('$station', '$currentSeconds', '0', '0')");			//Insert new hourlystats with current timestamp
		}	
	}
?> 