<?php

	$currentMonth = date("Y-m");																												//get current Year, Month
	$currentDay = date("Y-m-d");																												//get current Year, Month, Day
	$currentHour = date("Y-m-d H");																												//get current Year, Month, Day, Hour
	$currentSeconds = date("Y-m-d H:i:s");																										//get current Year, Month, Day, Hour, Minute, Sekonds
	//Insert Song in DB if not in DB
	$query_getSongId = "SELECT id FROM song WHERE name = '$songname' AND artist = '$artistname'";												
	$result_getSongId = mysqli_query($conn, $query_getSongId);
	$rows_getSongid = mysqli_num_rows($result_getSongId);
	if ($rows_getSongid == 0){
		$query_insertSong = "INSERT INTO song (name, artist) VALUES ('$songname', '$artistname')";
		mysqli_query($conn, $query_insertSong);
		$get_songId = mysqli_query($conn, $query_getSongId);
		while($data = mysqli_fetch_array($get_songId)){
			$db_songId = $data['id'];																											//get db_songId
		}
	}
	else{
		while($data = mysqli_fetch_array($result_getSongId)){
			$db_songId = $data['id'];																											//get db_songId if song was already in DB
		}
	}
	$timestamp = date("Y-m-d H:i:s", $time);																									//make timestamp with parameter
	if (empty($timestamp)){																														//if no parameter is handover use current time
		$timestamp = date("Y-m-d H:i:s");
	}
	//Hourly Stats
	$query_checkPlaysHour = "SELECT songId FROM plays WHERE stationId = '$station' AND timestamp LIKE '$currentHour%' AND songId = '$db_songId'";		//Check if Current song was played during current hour
	$result_checkPlaysHour = mysqli_query($conn, $query_checkPlaysHour);
	$playsHourRows = mysqli_num_rows($result_checkPlaysHour);																							//Get Rows																	
	
	$hourlyStatsExists = mysqli_query($conn, "SELECT * FROM hourlyStats WHERE stationId = '$station' and timestamp LIKE '$currentHour%'");				//Check if hourlystats exitst for current hour
	$hourlystatsRows = mysqli_num_rows($hourlyStatsExists);
	if($hourlystatsRows == 0){																															//if not
		mysqli_query($conn, "INSERT INTO hourlyStats (stationId, timestamp, replaysPerHour, score) VALUES ('$station', '$currentSeconds', '0', '0')");	//Insert new hourlystats with current timestamp
	}

	if($playsHourRows >= 1){																															//if current song was played this hour
		mysqli_query($conn, "UPDATE hourlyStats SET replaysPerHour = replaysPerHour +1 WHERE stationId = '$station'");									//replaysPerHour+1
	}
	//Daily Stats
	$query_checkPlaysDay = "SELECT songId FROM plays WHERE stationId = '$station' AND timestamp LIKE '$currentDay%' AND songId = '$db_songId'";		//Check if Current song was played during current Day
	$result_checkPlaysDay = mysqli_query($conn, $query_checkPlaysDay);
	$playsDayRows = mysqli_num_rows($result_checkPlaysDay);																								//Get Rows
	//Insert current play
	$query_insertPlays = "INSERT INTO plays (stationId, songId, timestamp) VALUES ('$station', '$db_songId', '$timestamp')";							//Insert current song into Plays
	mysqli_query($conn, $query_insertPlays);

	$dailystatsExists = mysqli_query($conn, "SELECT * FROM dailyStats WHERE stationId = '$station' and timestamp LIKE '$currentDay%'");					//Check if dailystats exitst for current day
	$dailystatsRows = mysqli_num_rows($dailystatsExists);
	if($dailystatsRows == 0){																															//if not
		mysqli_query($conn, "INSERT INTO dailyStats (stationId, timestamp, replaysPerHour, replaysPerDay, mostReplaysDuring, score) VALUES ('$station', '$currentSeconds', '0', '0', '0', '0')");	//Insert new daiylstats with current timestamp
	}
	
	
	if($playsDayRows >= 1){																																//if current song was played during current Day
		$calc_replays = 0;
		$query_getHourlyStats = "SELECT replaysPerHour FROM hourlyStats WHERE stationId = '$station' AND timestamp LIKE '$currentDay%'";					//get replaysperhour from hourlystats
		$result_getHourlyStats = mysqli_query($conn, $query_getHourlyStats);
		$rows_getHourlyStats = mysqli_num_rows($result_getHourlyStats);
		while($data = mysqli_fetch_array($result_getHourlyStats)){
			$db_replaysPerHour = $data['replaysPerHour'];																								//fetch replays from every hour
			$calc_replays = $calc_replays + $db_replaysPerHour;																							//add
		}
		$calc_replays = ($calc_replays / $rows_getHourlyStats);																							//calculate average
		$calc_replays = round($calc_replays, 2);
		$query_updatehourlyStats = "UPDATE dailyStats SET replaysPerDay = replaysPerDay + 1, replaysPerHour = $calc_replays WHERE stationId = '$station'";
		echo $calc_replays;
		echo $rows_getHourlyStats;
		mysqli_query($conn, $query_updatehourlyStats);
	}

	$query_getPlaysDAY = "	SELECT `songId`,
							COUNT(`songId`) AS `value_occurrence` 
							FROM `plays`
							WHERE `stationId`= '$station' AND timestamp LIKE '$currentDay%'
							GROUP BY `songId`
							ORDER BY `value_occurrence` DESC
							LIMIT    1";																												//get most played song this day
	$getmostPlaysDAY = mysqli_query($conn, $query_getPlaysDAY);
	while($data = mysqli_fetch_array($getmostPlaysDAY)){
		$mostPlaysDAY = $data['songId'];
	}
	mysqli_query($conn,"UPDATE dailyStats SET mostPlayedSong = '$mostPlaysDAY' WHERE stationId = '$station'");											//update dailystats with most played song

	$runs = "24";																																		//get time where most replays where inserted
	$save_mostPlaysDuring = 0;
	WHILE($runs > 0){
		$runs = $runs - 1;
		if($runs >= 10){																											//if runs >= 10
		$day = $currentDay . " " . $runs;																							//make whitespace between date and time
		}
		else{																														//if runs < 10
			$day = $currentDay . " 0" . $runs;																						//make 0 and whitespace between date and time
		}
		$query_mostPlaysDuring = "	SELECT COUNT(`songId`)
									FROM `plays`
									WHERE `stationId` = '$station' AND timestamp LIKE '$day%'";										//count replays on $runs hour
		$getMostPlaysDuring = mysqli_query($conn, $query_mostPlaysDuring);
		while($data = mysqli_fetch_array($getMostPlaysDuring)){
			$mostPlaysDuring = $data['COUNT(`songId`)'];																			//fetch count
		}
		if($mostPlaysDuring > $save_mostPlaysDuring){																				//if this hour has more replays than the hours before
			$save_mostPlaysDuring = $mostPlaysDuring;																				//overwrite
			$saveTime = $runs;																										//save time
		}

	}
	mysqli_query($conn, "UPDATE dailyStats SET mostReplaysDuring = '$saveTime' WHERE stationId = '$station'");						//update dailystats with mostReplaysDuring
?>