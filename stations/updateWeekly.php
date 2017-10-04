<?php

	include_once "db.php";
	$monday = date( 'Y-m-d', strtotime( 'monday this week' ) );
	$sunday = date( 'Y-m-d', strtotime( 'sunday this week' ) );
	$max = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM station"));					//check how many stations we have
	for($i = 1; $i <= $max; $i++){
		$replaysPerDay = 0;
		$station = $i;
		$query_replaysPerDay = "SELECT replaysPerDay FROM dailyStats WHERE stationId = '$station' AND YEARWEEK(`timestamp`, 1) = YEARWEEK(CURDATE(), 1)";
		$result_replaysPerDay = mysqli_query($conn, $query_replaysPerDay);
		while($data = mysqli_fetch_array($result_replaysPerDay)){
			$db_replaysPerDay = $data['replaysPerDay'];
			$replaysPerWeek = $replaysPerDay + $db_replaysPerDay;
		}
		mysqli_query($conn, "UPDATE weeklyStats SET replaysPerWeek = '$replaysPerWeek' WHERE stationId = '$station' AND timestamp BETWEEN '$monday' AND '$sunday'")
	}
?>