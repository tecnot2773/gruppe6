<?php
	include_once "db.php";
	$currentDay = date("Y-m-d");																												//get current Year, Month, Day
	
	$max = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM station"));					//check how many stations we have
	for($i = 1; $i <= $max; $i++){
		$station = $i;
	
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