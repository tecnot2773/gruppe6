<?php
	include_once "../db.php";
	$station = 10;
	$db_currentSongId = 0;
	$db_lastSongId = 0;
	
	$http_content = file_get_contents("http://www.radio21.de/titelabfrage/titelabfragesnippet.php");
	preg_match_all('/(?=>\s)..(.+?)(?= <)/', $http_content, $songs);
	preg_match_all('/(?=>\s)..(.+?)(?= <)/', $http_content, $artists);
	print_r ($songs);
	$artistname = mysqli_real_escape_string($conn,strtolower(strip_tags($artists[1][0])));
	$songname = mysqli_real_escape_string($conn,strtolower(strip_tags($songs[1][1])));
	echo "<br>" . $songname . "<br>" . $artistname;
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
		/*if($db_currentSongId != $db_lastSongId OR mysqli_num_rows($result_getSongId) == 0){
			$time = time();
			include "../plays.php";
			echo "done radio21";
			echo "<br>";
		}
		else{
			echo "Kein neuer Song bei radio21";
			echo "<br>";
		}
		*/
	}
?>