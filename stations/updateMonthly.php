<?php

	include_once "db.php";
	$currentMonth = date("Y-m");
	
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
		$replaysPerMonth = 0;
		$query_replaysPerDay = "SELECT replaysPerDay FROM dailyStats WHERE stationId = '$station' AND timestamp BETWEEN '$firstOfMonth' AND '$lastOfMonth'";
		$result_replaysPerDay = mysqli_query($conn, $query_replaysPerDay);
		while($data = mysqli_fetch_array($result_replaysPerDay)){
			$db_replaysPerDay = $data['replaysPerDay'];
			$replaysPerMonth = $replaysPerMonth + $db_replaysPerDay;
		}
		mysqli_query($conn, "UPDATE monthlyStats SET replaysPerMonth = '$replaysPerMonth' WHERE stationId = '$station' AND timestamp BETWEEN '$firstOfMonth' AND '$lastOfMonth'");
		//ReplaysPerDay Average
		$days = mysqli_num_rows($result_replaysPerDay);
		$avgReplaysPerWeek = $replaysPerMonth / $days;
		$avgReplaysPerWeek = round($avgReplaysPerWeek, 2);
		mysqli_query($conn, "UPDATE monthlyStats SET replaysPerWeek = '$avgReplaysPerWeek' WHERE stationId = '$station' AND timestamp BETWEEN '$firstOfMonth' AND '$lastOfMonth'");
		
		$result_getMostPlayedSong = (mysqli_query($conn, "SELECT `songId`, COUNT(`songId`) AS `value_occurrence` FROM `plays` WHERE `stationId`= '$station' AND timestamp BETWEEN '$firstOfMonth' AND '$lastOfMonth' GROUP BY `songId` ORDER BY `value_occurrence` DESC LIMIT 1"));
		while($data = mysqli_fetch_array($result_getMostPlayedSong)){
			$db_mostPlayed = $data['songId'];
			$db_mostPlayedCount = $data['value_occurrence'];
		}
		mysqli_query($conn, "UPDATE monthlyStats SET mostPlayedSong = '$db_mostPlayed', count = '$db_mostPlayedCount' WHERE stationId = '$station' AND timestamp BETWEEN '$firstOfMonth' AND '$lastOfMonth'");	
	}
	
?>

