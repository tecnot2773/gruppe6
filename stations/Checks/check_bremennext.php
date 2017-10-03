<?php

	$station = 6;
	$db_currentSongId = 0;
	$db_lastSongId = 0;
	
	$http_content = file_get_contents("http://www.radiobremen.de/bremennext/titelsuche/titelsuche120.html");
	preg_match('/\<span class=\"tracktime\"\>.*\<\/span\>(.*)\s*\<\/strong\>/', $http_content, $songs);
	$artistName = (explode(": ",$songs[1])[0]); //Artist
	$songName  = (explode(": ",$songs[1])[1]); //Songname

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
	
	$artistname = mysqli_real_escape_string($conn,strtolower(strip_tags($artistName)));
	$songname = mysqli_real_escape_string($conn,strtolower(strip_tags($songName)));
	if(empty($artistname) OR empty($songname)){
		die();
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
			echo "done bremenext";
			echo "<br>";
		}
		else{
			echo "Kein neuer Song bei bremennext";
			echo "<br>";
		}
	}
?>