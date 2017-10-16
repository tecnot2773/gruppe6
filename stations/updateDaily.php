<?php
	include_once "db.php";
	$currentDay = date("Y-m-d");																												//get current Year, Month, Day
	$currentSeconds = date("Y-m-d H:i:s");
	
	$max = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM station"));					//check how many stations we have
	for($i = 1; $i <= $max; $i++){
		$station = $i;
		if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM dailyStats WHERE stationId = '$station' and timestamp LIKE '$currentDay%'")) == 0){					//Check if dailystats exitst for current day																														//if not
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
	
		$query_getReplaysDay = "SELECT `songId`, COUNT(`songId`) AS `value_occurrence` FROM `plays` WHERE `stationId`= '$station' AND timestamp LIKE '$currentDay%' GROUP BY `songId` HAVING `value_occurrence` > 1";
		$result_getReplaysDay = mysqli_query($conn, $query_getReplaysDay);
		while($data = mysqli_fetch_array($result_getReplaysDay)){
			$replays = $data['value_occurrence'];
			$replaysPerDay = $replaysPerDay + ($replays - 1);
		}
		
		$query_updatehourlyStats = "UPDATE dailyStats SET replaysPerDay = $replaysPerDay, replaysPerHour = $calc_replays WHERE stationId = '$station' AND timestamp LIKE '$currentDay%'";
		mysqli_query($conn, $query_updatehourlyStats);


		$query_getPlaysDAY = "	SELECT `songId`, COUNT(`songId`) AS `value_occurrence` FROM `plays` WHERE `stationId`= '$station' AND timestamp LIKE '$currentDay%' GROUP BY `songId` ORDER BY `value_occurrence` DESC LIMIT 1";																												//get most played song this day
		$getmostPlaysDAY = mysqli_query($conn, $query_getPlaysDAY);
		while($data = mysqli_fetch_array($getmostPlaysDAY)){
			$mostPlaysDAY = $data['songId'];
			$db_mostPlayedCount = $data['value_occurrence'];
		}
		mysqli_query($conn,"UPDATE dailyStats SET mostPlayedSong = '$mostPlaysDAY', count = '$db_mostPlayedCount' WHERE stationId = '$station' AND timestamp LIKE '$currentDay%'");											//update dailystats with most played song

		$runs = "-1";																																		//get time where most replays where inserted
		$save_mostPlaysDuring = 0;
		$calc_mostPlaysDuring = 0;
		$start = 0;
		$saveTime = "";
		$mostPlaysDuring = 0;
		WHILE($runs < 24){
			$runs++;
			$start = $runs;
			$runs = $runs + 3;
			if($runs >= 10){																											//if runs >= 10
				$end = $currentDay . " " . $runs;																						//make whitespace between date and time
				$start = $currentDay . " " . $start;
			}
			else{																														//if runs < 10
				$end = $currentDay . " 0" . $runs;																						//make 0 and whitespace between date and time
				$start = $currentDay . " " . $start;
			}
			$query_mostPlaysDuring = "	SELECT `songId`, COUNT(`songId`) AS `value_occurrence` FROM `plays` WHERE `stationId`= '$station' AND timestamp BETWEEN '$start%' AND '$end%' GROUP BY `songId` HAVING `value_occurrence` > 1";			//count replays on $runs hour
			echo $query_mostPlaysDuring . "<br>";
			$getMostPlaysDuring = mysqli_query($conn, $query_mostPlaysDuring);
			while($data = mysqli_fetch_array($getMostPlaysDuring)){
				$mostPlaysDuring = $data['value_occurrence'];																			//fetch count
				$mostPlaysDuring = $calc_mostPlaysDuring + $mostPlaysDuring;
			}
			if($mostPlaysDuring != 0){
				if($mostPlaysDuring > $save_mostPlaysDuring){																				//if this hour has more replays than the hours before
					$save_mostPlaysDuring = $mostPlaysDuring;																				//overwrite
					$saveTime = $runs + 1;																								//save time
				}
			}

		}
		mysqli_query($conn, "UPDATE dailyStats SET mostReplaysDuring = '$saveTime' WHERE stationId = '$station' AND timestamp LIKE '$currentDay%'");						//update dailystats with mostReplaysDuring
	}
?>