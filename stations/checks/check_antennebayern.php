<?php

	$station = 13;
	$db_currentSongId = 0;
	$db_lastSongId = 0;
	$http_content = file_get_contents("https://api.antenne.de/1.0.0/antenneservices/webradio/getsummary?callback=AntenneCallbackWebradio&context=antenne-de&_=1508183532431");
	$json = json_decode($http_content, true); // decode the JSON into an associative array
	echo '<pre>' . print_r($json, true) . '</pre>';
	//echo($json['object']['now']['song']);
	die();
	$artistname = mysqli_real_escape_string($conn,strtolower($json['object']['now']['song']));
	$songname = mysqli_real_escape_string($conn,strtolower($json['object']['now']['artist']));
	
	if(empty($artistname) OR empty($songname)){
		
	}else{
		$query_getSongId = "SELECT id FROM song WHERE name = '$songname' AND artist = '$artistname'";
		$result_getSongId = mysqli_query($conn, $query_getSongId);
		if(mysqli_num_rows($result_getSongId) >= 1){ 
			while ($data = mysqli_fetch_array($result_getSongId)){
				$db_currentSongId = $data['id'];
			}
			$query_getLastSong = "SELECT songId FROM plays WHERE `stationId` = '$station' ORDER BY `timestamp` DESC LIMIT 1";
			$result_getLastSong = mysqli_query($conn, $query_getLastSong);
			while ($data = mysqli_fetch_array($result_getLastSong)){
				$db_lastSongId = $data['songId'];
			}
		}
		if($db_currentSongId != $db_lastSongId OR mysqli_num_rows($result_getSongId) == 0){
			$time = time();
			include "../plays.php";
			echo "done ffn";
			echo "<br>";
		}
		else{
			echo "Kein neuer Song bei ffn";
			echo "<br>";
		}
	}
?>