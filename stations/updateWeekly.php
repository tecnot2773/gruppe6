<?php

	include_once "db.php";
	$max = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM station"));					//check how many stations we have
	for($i = 1; $i <= $max; $i++){
		//ReplaysPerWeek
		$replaysPerWeek = 0;
		$station = $i;
		$query_dailyStats = "SELECT id FROM dailyStats WHERE stationId = '$station' AND YEARWEEK(`timestamp`, 1) = YEARWEEK(CURDATE(), 1)";		//get entry this week
		$query_replays = "	SELECT `songId`,
							COUNT(`songId`) AS `value_occurrence` 
							FROM `plays`
							WHERE `stationId`= '$station' AND YEARWEEK(`timestamp`, 1) = YEARWEEK(CURDATE(), 1)
							GROUP BY `songId`
							HAVING `value_occurrence` > 1";																				//get replays this week
		$result_dailyStats = mysqli_query($conn, $query_dailyStats);
		$result_replays = mysqli_query($conn, $query_replays);
		while($data = mysqli_fetch_array($result_replays)){
			$db_replays = $data['value_occurrence'];
			$replaysPerWeek = $replaysPerWeek + ($db_replays - 1);
		}
		echo $replaysPerWeek . "<br>";
		mysqli_query($conn, "UPDATE weeklyStats SET replaysPerWeek = '$replaysPerWeek' WHERE stationId = '$station' AND YEARWEEK(`timestamp`, 1) = YEARWEEK(CURDATE(), 1)");
		//ReplaysPerDay Average
		$days = mysqli_num_rows($result_dailyStats);
		$avgReplaysPerDay = $replaysPerWeek / $days;
		$avgReplaysPerDay = round($avgReplaysPerDay, 2);
		$avgReplaysPerDay = number_format($avgReplaysPerDay, 2);
		echo $avgReplaysPerDay. "<br>";
		mysqli_query($conn, "UPDATE weeklyStats SET replaysPerDay = '$avgReplaysPerDay' WHERE stationId = '$station' AND YEARWEEK(`timestamp`, 1) = YEARWEEK(CURDATE(), 1)");
		
		$result_getMostPlayedSong = (mysqli_query($conn, "SELECT `songId`, COUNT(`songId`) AS `value_occurrence` FROM `plays` WHERE `stationId`= '$station' AND YEARWEEK(`timestamp`, 1) = YEARWEEK(CURDATE(), 1) GROUP BY `songId` ORDER BY `value_occurrence` DESC LIMIT 1"));
		while($data = mysqli_fetch_array($result_getMostPlayedSong)){
			$db_mostPlayed = $data['songId'];
			$db_mostPlayedCount = $data['value_occurrence'];
		}
		mysqli_query($conn, "UPDATE weeklyStats SET mostPlayedSong = '$db_mostPlayed', count = '$db_mostPlayedCount' WHERE stationId = '$station' AND YEARWEEK(`timestamp`, 1) = YEARWEEK(CURDATE(), 1)");
	}
?>