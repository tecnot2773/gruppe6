<?php
	include_once "db.php";
	for($i = 1; $i <= 9; $i++){
		$station = $i;
		
		$currentMonth = date("Y-m");																												//get current Year, Month
		$currentDay = date("Y-m-d");																												//get current Year, Month, Day
		$currentHour = date("Y-m-d H");																												//get current Year, Month, Day, Hour
		$currentSeconds = date("Y-m-d H:i:s");																										//get current Year, Month, Day, Hour, Minute, Sekonds
		
		$hourlyStatsExists = mysqli_query($conn, "SELECT * FROM hourlyStats WHERE stationId = '$station' and timestamp LIKE '$currentHour%'");				//Check if hourlystats exitst for current hour
		$hourlystatsRows = mysqli_num_rows($hourlyStatsExists);
		if($hourlystatsRows == 0){																															//if not
			mysqli_query($conn, "INSERT INTO hourlyStats (stationId, timestamp, replaysPerHour, score) VALUES ('$station', '$currentSeconds', '0', '0')");	//Insert new hourlystats with current timestamp
		}

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

		$dailystatsExists = mysqli_query($conn, "SELECT * FROM dailyStats WHERE stationId = '$station' and timestamp LIKE '$currentDay%'");					//Check if dailystats exitst for current day
		$dailystatsRows = mysqli_num_rows($dailystatsExists);
		if($dailystatsRows == 0){																															//if not
			mysqli_query($conn, "INSERT INTO dailyStats (stationId, timestamp, replaysPerHour, replaysPerDay, mostReplaysDuring, score) VALUES ('$station', '$currentSeconds', '0', '0', '0', '0')");	//Insert new daiylstats with current timestamp
		}

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
		$query_getReplaysDay = "SELECT `songId`,
							COUNT(`songId`) AS `value_occurrence` 
							FROM `plays`
							WHERE `stationId`= '$station' AND timestamp LIKE '$currentDay%'
							GROUP BY `songId`
							HAVING `value_occurrence` > 1";
		$result_getReplaysDay = mysqli_query($conn, $query_getReplaysDay);
		while($data = mysqli_fetch_array($result_getReplaysDay)){
			$replays = $data['value_occurrence'];
			$replaysPerDay = $replaysPerDay + ($replays - 1);
		}
		
		$query_updatehourlyStats = "UPDATE dailyStats SET replaysPerDay = $replaysPerDay, replaysPerHour = $calc_replays WHERE stationId = '$station' AND timestamp LIKE '$currentDay%'";
		mysqli_query($conn, $query_updatehourlyStats);


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
		mysqli_query($conn,"UPDATE dailyStats SET mostPlayedSong = '$mostPlaysDAY' WHERE stationId = '$station' AND timestamp LIKE '$currentDay%'");											//update dailystats with most played song

		$runs = "24";																																		//get time where most replays where inserted
		$save_mostPlaysDuring = 0;
		$calc_mostPlaysDuring = 0;
		$saveTime = "";
		$mostPlaysDuring = 0;
		WHILE($runs > 0){
			$runs = $runs - 1;
			if($runs >= 10){																											//if runs >= 10
			$day = $currentDay . " " . $runs;																							//make whitespace between date and time
			}
			else{																														//if runs < 10
				$day = $currentDay . " 0" . $runs;																						//make 0 and whitespace between date and time
			}
			$query_mostPlaysDuring = "	SELECT `songId`,
										COUNT(`songId`) AS `value_occurrence` 
										FROM `plays`
										WHERE `stationId`= '$station' AND timestamp LIKE '$day%'
										GROUP BY `songId`
										HAVING `value_occurrence` > 1";																	//count replays on $runs hour
			$getMostPlaysDuring = mysqli_query($conn, $query_mostPlaysDuring);
			while($data = mysqli_fetch_array($getMostPlaysDuring)){
				$mostPlaysDuring = $data['value_occurrence'];																			//fetch count
				$mostPlaysDuring = $calc_mostPlaysDuring + $mostPlaysDuring;
			}
			if($mostPlaysDuring != 0){
				if($mostPlaysDuring > $save_mostPlaysDuring){																				//if this hour has more replays than the hours before
					$save_mostPlaysDuring = $mostPlaysDuring;																				//overwrite
					$saveTime = $runs;																										//save time
				}
			}

		}
		mysqli_query($conn, "UPDATE dailyStats SET mostReplaysDuring = '$saveTime' WHERE stationId = '$station' AND timestamp LIKE '$currentDay%'");						//update dailystats with mostReplaysDuring
	}
?>