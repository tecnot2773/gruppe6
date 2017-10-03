<?php
	$servername = "localhost";														//server name
	$username = "stationssql";														//login name
	$password = "veve113ppe";														//login password

	// Create connection
	$conn = new mysqli($servername, $username, $password);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);							//error log
	}
	$conn->select_db("stations");													//selet Database
	
	$strQuery = "SET character_set_results = 'utf8', 
	  character_set_client = 'utf8', 
	  character_set_connection = 'utf8', 
	  character_set_database = 'utf8', 
	  character_set_server = 'utf8'";
	$conn->query($strQuery);  



	$station = 1;
	$db_currentSongId = 0;
	$db_lastSongId = 0;
	$http_content = file_get_contents("https://www.n-joy.de/musik/titelliste/index.html");

	
	$artistname = "calvin harris feat. pharrell william";
	$songname = "feels";

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
		echo "done njoy";
		echo "<br>";
	}
	else{
		echo "Kein neuer Song bei njoy";
		echo "<br>";
	}
?>