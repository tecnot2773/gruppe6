<?php
	include_once "db.php";
	$max = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM station"));					//check how many stations we have
	for($i = 1; $i <= $max; $i++){
		$station = $i;
		
		$currentMonth = date("Y-m");																												//get current Year, Month
		$currentDay = date("Y-m-d");																												//get current Year, Month, Day
		$currentHour = date("Y-m-d H");																												//get current Year, Month, Day, Hour
		$currentSeconds = date("Y-m-d H:i:s");																										//get current Year, Month, Day, Hour, Minute, Sekonds

		$replaysPerHour = 0;
		$query_getReplaysHour = "SELECT `songId`,
							COUNT(`songId`) AS `value_occurrence` 
							FROM `plays`
							WHERE `stationId`= '$station' AND timestamp LIKE '$currentHour%'
							GROUP BY `songId`
							HAVING `value_occurrence` > 1";
		$result_getReplaysHour = mysqli_query($conn, $query_getReplaysHour);
		while($data = mysqli_fetch_array($result_getReplaysHour)){
			$replays = $data['value_occurrence'];
			$replaysPerHour = $replaysPerHour + ($replays - 1);
		}
		mysqli_query($conn, "UPDATE hourlyStats SET replaysPerHour = '$replaysPerHour' WHERE stationId = '$station' AND timestamp LIKE '$currentHour%'");									//replaysPerHour+1

		$calc_replays = 0;
		$replaysPerDay = 0;
		$query_getHourlyStats = "SELECT replaysPerHour FROM hourlyStats WHERE stationId = '$station' AND timestamp LIKE '$currentDay%'";					//get replaysperhour from hourlystats
		$result_getHourlyStats = mysqli_query($conn, $query_getHourlyStats);
		$rows_getHourlyStats = mysqli_num_rows($result_getHourlyStats);
		while($data = mysqli_fetch_array($result_getHourlyStats)){
			$db_replaysPerHour = $data['replaysPerHour'];																								//fetch replays from every hour
			$calc_replays = $calc_replays + $db_replaysPerHour;																							//add
		}
		$calc_replays = ($calc_replays / $rows_getHourlyStats);																							//calculate average
		$calc_replays = round($calc_replays, 2);
		
	}
?>