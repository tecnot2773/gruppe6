<?php

	$station = 5;
	$db_currentSongId = 0;
	$db_lastSongId = 0;
	$date = date("Y-m-d");
	$hour = date("H");
	$minute = date ("i");
	$http_content = file_get_contents("http://www.radiobremen.de/bremeneins/musik/titelsuche/?wrapurl=%2Fbremeneins%2Fmusik%2Ftitelsuche%2F&selectdate=". $date. "&stunde=" . $hour . "&minute=" . $minute);

	preg_match_all('/<td style=\"vertical-align:top\;\">(.*)<\/td>\s*\<\/tr\>/', $http_content, $songs);
	preg_match_all('/<td style=\"vertical-align:top\;\">(.*)<\/td>\s*<td/', $http_content, $artists);
	
	
	for ($i = 0; $i <= 4; $i++) {
		$loopSong = strtolower(strip_tags($songs[0][$i]));
		if(strlen($loopSong) > 4)
		{
			$lastIDinArray=$i;
		}
	}
	
	$songName = (strtolower(strip_tags($songs[0][$lastIDinArray])));//SONGNAME
	$artistName = (strtolower(strip_tags($artists[0][$lastIDinArray]))); //ARTIST
	
	$artistname = mysqli_real_escape_string($conn, $artistName);
	$songname = mysqli_real_escape_string($conn, $songName);
	
	$query_getSongId = "SELECT id FROM song WHERE name = '$songname'";
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
	if($db_currentSongId !== $db_lastSongId OR mysqli_num_rows($result_getSongId) == 0){
		$time = time();
		include "plays.php";
		echo "done bremeneins";
		echo "<br>";
	}
?>