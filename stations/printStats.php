<?php
	include_once "db.php";
	
	$currentMonth = date("Y-m");			
	$currentDay = date("Y-m-d");			
	$currentHour = date("Y-m-d H");			
	$currentSeconds = date("Y-m-d H:i:s");	
	$firstAndLastOfMonth = mysqli_query($conn,"
	SELECT
	DATE_SUB(
		LAST_DAY(
			DATE_ADD(NOW(), INTERVAL 0 MONTH)
		), 
		INTERVAL DAY(
			LAST_DAY(
				DATE_ADD(NOW(), INTERVAL 0 MONTH)
			)
		)-1 DAY
	) AS firstOfThisMonth,
	
	LAST_DAY(
		DATE_ADD(NOW(), INTERVAL 0 MONTH)
	)AS lastOfThisMonth");
	while($data = mysqli_fetch_array($firstAndLastOfMonth)){
		$firstOfMonth = $data['firstOfThisMonth'];
		$lastOfMonth = $data['lastOfThisMonth'];
	}
	$max = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM station"));					//check how many stations we have
	for($i = 1; $i <= $max; $i++){							
		$station = $i;
		$getstationName = mysqli_query($conn,"SELECT name FROM station WHERE id = '$station'");
		while($data = mysqli_fetch_array($getstationName)){
			$db_stationName = $data['name'];
			$stationName = strtoupper($db_stationName);
		}
		$getReplaysPerHour = mysqli_query($conn, "SELECT replaysPerHour FROM dailyStats WHERE stationId = '$station' AND timestamp LIKE '$currentDay%'");
		//print_r(mysqli_fetch_array($getReplaysPerHour)); //DEBUG
		while($data = mysqli_fetch_array($getReplaysPerHour)){
			$db_avgReplaysPerHour = $data['replaysPerHour'];
		}
		$getReplaysPerDay = mysqli_query($conn, "SELECT replaysPerDay FROM weeklyStats WHERE stationId = '$station' AND YEARWEEK(`timestamp`, 1) = YEARWEEK(CURDATE(), 1)");
		while($data = mysqli_fetch_array($getReplaysPerDay)){
			$db_avgReplaysPerDay = $data['replaysPerDay'];
		}
		$getReplaysPerWeek = mysqli_query($conn, "SELECT replaysPerWeek FROM monthlyStats WHERE stationId = '$station' AND timestamp BETWEEN '$firstOfMonth' AND '$lastOfMonth'");
		while($data = mysqli_fetch_array($getReplaysPerWeek)){
			$db_avgReplaysPerWeek = $data['replaysPerWeek'];
		}
		$getReplaysPerMonth = mysqli_query($conn, "SELECT replaysPerMonth FROM monthlyStats WHERE stationId = '$station' AND timestamp BETWEEN '$firstOfMonth' AND '$lastOfMonth'");
		while($data = mysqli_fetch_array($getReplaysPerMonth)){
			$db_replaysPerMonth = $data['replaysPerMonth'];
		}
		
		
		
		
		
		
		
		
		echo"<tr>";
                  echo"<td>" . $stationName . "</td>";
                  echo"<td>" . $db_avgReplaysPerHour . "</td>";
                  echo"<td>" . $db_avgReplaysPerDay . "</td>";
                  echo"<td>" . $db_avgReplaysPerWeek . "</td>";
                  echo"<td>" . $db_replaysPerMonth . "</td>";
			echo"</tr>";
	}
?>