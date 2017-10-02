<?php

	$station = 7;
	$db_currentSongId = 0;
	$db_lastSongId = 0;
	
	$http_content = file_get_contents("http://www1.wdr.de/radio/1live/on-air/1live-playlist/index.html");
	preg_match('/<td class="entry">(.+?)(?=<)/', $http_content, $songs);
	preg_match('/<br><\/td>\s<td class="entry">\s(.+?)(?=\n)/', $http_content, $artists);
	
	$artistname = mysqli_real_escape_string($conn,strtolower(strip_tags($artists[1])));
	$songname = mysqli_real_escape_string($conn,strtolower(strip_tags($songs[1])));

	if(preg_match('/(?=&amp)(.+?)(?<=;)/', $artistname)){
		$pattern = '/(?=&amp)(.+?)(?<=;)/';
		$replacement = '&';
		$artistname = preg_replace($pattern, $replacement, $artistname);
	}
	if(preg_match('/(?=&amp)(.+?)(?<=;)/', $songname)){
		$pattern = '/(?=&amp)(.+?)(?<=;)/';
		$replacement = '&';
		$songname = preg_replace($pattern, $replacement, $songname);
	}
	if(preg_match('/(?=&#039)(.+?)(?<=;)/', $artistname)){
		$pattern = '/(?=&#039)(.+?)(?<=;)/';
		$replacement = "'";
		$artistname = preg_replace($pattern, $replacement, $artistname);
	}
	if(preg_match('/(?=&#039)(.+?)(?<=;)/', $songname)){
		$pattern = '/(?=&#039)(.+?)(?<=;)/';
		$replacement = "'";
		$songname = preg_replace($pattern, $replacement, $songname);
	}
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
	if($db_currentSongId != $db_lastSongId OR mysqli_num_rows($result_getSongId) == 0){
		$time = time();
		include "plays.php";
		echo "done 1live";
		echo "<br>";
	}
	else{
		echo "Kein neuer Song bei 1Live";
		echo "<br>";
	}
?>