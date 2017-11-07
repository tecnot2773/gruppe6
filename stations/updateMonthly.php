<?php

	include_once "db.php";
	$currentSeconds = date("Y-m-d H:i:s");	
	//get first and Last day of this Month
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
	$first = date("Y-m-d",strtotime("Last Monday of Last Month"));
	
	$max = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM station"));					//check how many stations we have
	for($i = 1; $i <= $max; $i++){
		$station = $i;
		if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM monthlyStats WHERE stationId = '$station' AND timestamp BETWEEN '$firstOfMonth' AND '$lastOfMonth'")) == 0){	
			mysqli_query($conn, "INSERT INTO monthlyStats (stationId, timestamp, replaysPerMonth, replaysPerWeek, score) VALUES ('$station', '$currentSeconds',  '0', '0', '0')");			//Insert now monthlyStats if no exsits for this month
		}
		$replaysPerMonth = 0;				//reset value every run
		$db_replaysPerDay = 0;				//reset value every run
		$query_replays = "	SELECT `songId`,
							COUNT(`songId`) AS `value_occurrence` 
							FROM `plays`
							WHERE `stationId`= '$station' AND timestamp BETWEEN '$firstOfMonth' AND '$lastOfMonth'
							GROUP BY `songId`
							HAVING `value_occurrence` > 1";						//select replays in this month
		$result_replays = mysqli_query($conn,$query_replays);
		while($data = mysqli_fetch_array($result_replays)){
			$db_replays = $data['value_occurrence'];						
			$replaysPerMonth = $replaysPerMonth + ($db_replays -1);				//fetch data and add (-1 because replays are listed as 2 Plays but it is only 1 is replay)
		}
		mysqli_query($conn, "UPDATE monthlyStats SET replaysPerMonth = '$replaysPerMonth' WHERE stationId = '$station' AND timestamp BETWEEN '$firstOfMonth' AND '$lastOfMonth'");
		
		$query_replaysPerDay = "SELECT replaysPerWeek FROM weeklyStats WHERE stationId = '$station' AND timestamp BETWEEN '$first' AND '$lastOfMonth'";
		$result_replaysPerDay = mysqli_query($conn, $query_replaysPerDay);
		while($data = mysqli_fetch_array($result_replaysPerDay)){
			$db_replaysPerDay = $data['replaysPerWeek'];
		}
		//ReplaysPerDay Average
		$days = mysqli_num_rows($result_replaysPerDay);
		$avgReplaysPerWeek = $db_replaysPerDay / $days;
		$avgReplaysPerWeek = round($avgReplaysPerWeek, 2);					//round to 2 decimal place
		$avgReplaysPerWeek = number_format($avgReplaysPerWeek, 2, '.', '');          //number_format(VALUE, decimal place value)
		mysqli_query($conn, "UPDATE monthlyStats SET replaysPerWeek = '$avgReplaysPerWeek' WHERE stationId = '$station' AND timestamp BETWEEN '$firstOfMonth' AND '$lastOfMonth'");
		//get Most played Song
		$result_getMostPlayedSong = (mysqli_query($conn, "SELECT `songId`, COUNT(`songId`) AS `value_occurrence` FROM `plays` WHERE `stationId`= '$station' AND timestamp BETWEEN '$firstOfMonth' AND '$lastOfMonth' GROUP BY `songId` ORDER BY `value_occurrence` DESC LIMIT 1"));
		while($data = mysqli_fetch_array($result_getMostPlayedSong)){
			$db_mostPlayed = $data['songId'];
			$db_mostPlayedCount = $data['value_occurrence'];
		}
		mysqli_query($conn, "UPDATE monthlyStats SET mostPlayedSong = '$db_mostPlayed', count = '$db_mostPlayedCount' WHERE stationId = '$station' AND timestamp BETWEEN '$firstOfMonth' AND '$lastOfMonth'");	
	}
	
?>

