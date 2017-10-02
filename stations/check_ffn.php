<?php

	$station = 1;
	$db_currentSongId = 0;
	$db_lastSongId = 0;
	
	$http_content = file_get_contents("https://www.ffn.de/musik/playlist/");
	preg_match('/<p class="title">(.+?)(?=<)/', $http_content, $songs);
	preg_match('/<h6 class="artist">(.+?)(?=<)/', $http_content, $artists);
	
	$artistname = mysqli_real_escape_string($conn,strtolower(strip_tags($artists[1])));
	$songname = mysqli_real_escape_string($conn,strtolower(strip_tags($songs[1])));
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
		include "plays.php";
		echo "done ffn $songname";
		echo "<br>";
	}
	else{
		echo "Kein neuer Song bei ffn";
		echo "<br>";
	}
?>