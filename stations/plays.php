<?php
	/*include_once 'db.php';

	$songname = $_GET["songname"];
	$time = $_GET["time"];
	$station = $_GET["station"];
	*/
	$currentMonth = date("Y-m");
	$currentDay = date("Y-m-d");
	$currentHour = date("Y-m-d H");
	$currentSeconds = date("Y-m-d H:i:s");

	$query_getSongId = "SELECT id FROM song WHERE name = '$songname' AND artist = '$artistname'";
	$result_getSongId = mysqli_query($conn, $query_getSongId);
	$rows_getSongid = mysqli_num_rows($result_getSongId);
	if ($rows_getSongid == 0){
		$query_insertSong = "INSERT INTO song (name, artist) VALUES ('$songname', '$artistname')";
		mysqli_query($conn, $query_insertSong);
		$get_songId = mysqli_query($conn, $query_getSongId);
		while($data = mysqli_fetch_array($get_songId)){
			$db_songId = $data['id'];
		}
	}
	else{
		while($data = mysqli_fetch_array($result_getSongId)){
			$db_songId = $data['id'];
		}
	}
	$timestamp = date("Y-m-d H:i:s", $time);
	if (empty($timestamp)){
		$timestamp = date("Y-m-d H:i:s");
	}

	$query_insertPlays = "INSERT INTO plays (stationId, songId, timestamp) VALUES ('$station', '$db_songId', '$timestamp')";
	mysqli_query($conn, $query_insertPlays);

	$query_checkPlaysHour = "SELECT songId FROM plays WHERE stationId = '$station' AND timestamp LIKE '%$currentHour%'";
	$result_checkPlaysHour = mysqli_query($conn, $query_checkPlaysHour);
	$playsHourRows = mysqli_num_rows($result_checkPlaysHour);

	$query_checkPlaysDay = "SELECT songId FROM plays WHERE stationId = '$station' AND timestamp LIKE '%$currentDay%'";
	$result_checkPlaysDay = mysqli_query($conn, $query_checkPlaysDay);
	$playsDayRows = mysqli_num_rows($result_checkPlaysDay);

	$dailystatsExists = mysqli_query($conn, "SELECT * FROM dailyStats WHERE stationId = '$station' and timestamp LIKE '$currentDay%'");
	$dailystatsRows = mysqli_num_rows($dailystatsExists);
	if($dailystatsRows == 0){
		mysqli_query($conn, "INSERT INTO dailyStats (stationId, timestamp, replaysPerHour, replaysPerDay, mostReplaysDuring, score) VALUES ('$station', '$currentSeconds', '0', '0', '0', '0')");
	}

	if($playsHourRows >= 1){
		mysqli_query($conn, "UPDATE dailyStats SET replaysPerDay = replaysPerDay + 1, replaysPerHour = replaysPerHour +1 WHERE stationId = '$station'");
	}
	elseif($playsDayRows >= 1){
		mysqli_query($conn, "UPDATE dailyStats SET replaysPerDay = replaysPerDay + 1 WHERE stationId = '$station'");
	}

	$query_getPlaysDAY = "	SELECT `songId`,
							COUNT(`songId`) AS `value_occurrence` 
							FROM `plays`
							WHERE `stationId`= '$station' AND timestamp LIKE '$currentDay%'
							GROUP BY `songId`
							ORDER BY `value_occurrence` DESC
							LIMIT    1";
	$getmostPlaysDAY = mysqli_query($conn, $query_getPlaysDAY);
	while($data = mysqli_fetch_array($getmostPlaysDAY)){
		$mostPlaysDAY = $data['songId'];
	}
	mysqli_query($conn,"UPDATE dailyStats SET mostPlayedSong = '$mostPlaysDAY' WHERE stationId = '$station'");

	$runs = "24";
	$save_mostPlaysDuring = 0;
	WHILE($runs > 0){
		$runs = $runs - 1;
		if($runs >= 10){
		$day = $currentDay . " " . $runs;
		}
		else{
			$day = $currentDay . " 0" . $runs;
		}
		$query_mostPlaysDuring = "	SELECT COUNT(`songId`)
									FROM `plays`
									WHERE `stationId` = '$station' AND timestamp LIKE '$day%'";
		$getMostPlaysDuring = mysqli_query($conn, $query_mostPlaysDuring);
		while($data = mysqli_fetch_array($getMostPlaysDuring)){
			$mostPlaysDuring = $data['COUNT(`songId`)'];
		}
		if($mostPlaysDuring > $save_mostPlaysDuring){
			$save_mostPlaysDuring = $mostPlaysDuring;
			$saveTime = $runs;
		}

	}
	mysqli_query($conn, "UPDATE dailyStats SET mostReplaysDuring = '$saveTime' WHERE stationId = '$station'");
?>