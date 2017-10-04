<?php

	include_once "db.php";
	$max = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM station"));					//check how many stations we have
	for($i = 1; $i <= $max; $i++){
		//ReplaysPerWeek
		$replaysPerWeek = 0;
		$station = $i;
		$query_replaysPerDay = "SELECT replaysPerDay FROM dailyStats WHERE stationId = '$station' AND YEARWEEK(`timestamp`, 1) = YEARWEEK(CURDATE(), 1)";
		$result_replaysPerDay = mysqli_query($conn, $query_replaysPerDay);
		while($data = mysqli_fetch_array($result_replaysPerDay)){
			$db_replaysPerDay = $data['replaysPerDay'];
			$replaysPerWeek = $replaysPerWeek + $db_replaysPerDay;
		}
		mysqli_query($conn, "UPDATE weeklyStats SET replaysPerWeek = '$replaysPerWeek' WHERE stationId = '$station' AND YEARWEEK(`timestamp`, 1) = YEARWEEK(CURDATE(), 1)");
		//ReplaysPerDay Average
		$days = mysqli_num_rows($result_replaysPerDay);
		$avgReplaysPerDay = $replaysPerWeek / $days;
		$avgReplaysPerDayround = round($avgReplaysPerDay, 2);
		echo $avgReplaysPerDay. "<br>";
		mysqli_query($conn, "UPDATE weeklyStats SET replaysPerDay = '$avgReplaysPerDay' WHERE stationId = '$station' AND YEARWEEK(`timestamp`, 1) = YEARWEEK(CURDATE(), 1)");
		
		$result_getMostPlayedSong = (mysqli_query($conn, "SELECT `songId`, COUNT(`songId`) AS `value_occurrence` FROM `plays` WHERE `stationId`= '$station' AND YEARWEEK(`timestamp`, 1) = YEARWEEK(CURDATE(), 1) GROUP BY `songId` ORDER BY `value_occurrence` DESC LIMIT 1"));
		while($data = mysqli_fetch_array($result_getMostPlayedSong)){
			$db_mostPlayed = $data['songId'];
		}
		mysqli_query($conn, "UPDATE weeklyStats SET mostPlayedSong = '$db_mostPlayed' WHERE stationId = '$station' AND YEARWEEK(`timestamp`, 1) = YEARWEEK(CURDATE(), 1)");
	}
?>