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
	//Insert current play
	$query_insertPlays = "INSERT INTO plays (stationId, songId, timestamp) VALUES ('$station', '$db_songId', '$timestamp')";							//Insert current song into Plays
	mysqli_query($conn, $query_insertPlays);
?>