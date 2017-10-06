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



	$yearEnd = date('Y-m-d', strtotime('Dec 31'));
	$yearStart = date('Y-m-d', strtotime('Jan 01'));
	$currentSeconds = date("Y-m-d H:i:s");
	echo $yearEnd . "<br>" . $yearStart;
	$max = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM station"));					//check how many stations we have
	for($i = 1; $i <= $max; $i++){
				$station = $i;
				if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM yearlyStats WHERE stationId = '$station' and timestamp BETWEEN '$yearStart' AND '$yearEnd'")) == 0){
			mysqli_query($conn, "INSERT INTO yearlyStats (stationId, timestamp, replaysPerMonth) VALUES ('$station', '$currentSeconds', '0')");
		}

		$avgReplaysPerYear = 0;
		
		$query_replaysPerDay = "SELECT replaysPerDay FROM dailyStats WHERE stationId = '$station' AND timestamp BETWEEN '$yearStart' AND '$yearEnd'";
		$result_replaysPerDay = mysqli_query($conn, $query_replaysPerDay);
		while($data = mysqli_fetch_array($result_replaysPerDay)){
			$db_replaysPerDay = $data['replaysPerDay'];
			$avgReplaysPerYear = $avgReplaysPerYear + $db_replaysPerDay;
		}
		$days = mysqli_num_rows($result_replaysPerDay);
		$avgReplaysPerYear = $avgReplaysPerYear / $days;
		$avgReplaysPerYear = round($avgReplaysPerYear, 2);
		mysqli_query($conn, "UPDATE yearlyStats SET replaysPerMonth = '$avgReplaysPerYear' WHERE stationId = '$station' AND timestamp BETWEEN '$yearStart' AND '$yearEnd'");
	}
?>