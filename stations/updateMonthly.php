<?php

	include_once "db.php";
	$currentMonth = date("Y-m");
	$max = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM station"));					//check how many stations we have
	for($i = 1; $i <= $max; $i++){
		$station = $i;
		$replaysPerMonth = 0;
		$query_replaysPerDay = "SELECT replaysPerDay FROM dailyStats WHERE stationId = '$station' AND timestamp LIKE '$currentMonth%'";
		$result_replaysPerDay = mysqli_query($conn, $query_replaysPerDay);
		while($data = mysqli_fetch_array($result_replaysPerDay)){
			$db_replaysPerDay = $data['replaysPerDay'];
			$replaysPerMonth = $replaysPerMonth + $db_replaysPerDay;
		}
		mysqli_query($conn, "UPDATE monthlyStats SET replaysPerMonth = '$replaysPerMonth' WHERE stationId = '$station' AND timestamp LIKE '$currentMonth%'");
		//ReplaysPerDay Average
		$days = mysqli_num_rows($result_replaysPerDay);
		$avgReplaysPerDay = $replaysPerMonth / $days;
		$avgReplaysPerDay = round($avgReplaysPerDay, 2);
		$avgReplaysPerDay = number_format($avgReplaysPerDay, 2);
		echo $avgReplaysPerDay. "<br>";
		mysqli_query($conn, "UPDATE monthlyStats SET replaysPerDay = '$avgReplaysPerDay' WHERE stationId = '$station' AND timestamp LIKE '$currentMonth%'");
		
		$result_getMostPlayedSong = (mysqli_query($conn, "SELECT `songId`, COUNT(`songId`) AS `value_occurrence` FROM `plays` WHERE `stationId`= '$station' AND timestamp LIKE '$currentMonth%' GROUP BY `songId` ORDER BY `value_occurrence` DESC LIMIT 1"));
		while($data = mysqli_fetch_array($result_getMostPlayedSong)){
			$db_mostPlayed = $data['songId'];
			$db_mostPlayedCount = $data['value_occurrence'];
		}
		mysqli_query($conn, "UPDATE monthlyStats SET mostPlayedSong = '$db_mostPlayed', count = '$db_mostPlayedCount' WHERE stationId = '$station' AND timestamp LIKE '$currentMonth%'");	
	}
	
?>