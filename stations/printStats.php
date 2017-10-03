<?php
	include_once "db.php";
	for($i = 1; $i <= 9; $i++){
		$station = $i;
		$time = date("Y-m-d H:i:s",strtotime("-10 minutes",strtotime(date("Y-m-d H:i:s"))));
		$result_getLastPlayTime = mysqli_query($conn, "SELECT * FROM plays WHERE stationId = '1' AND timestamp > '$time%' ORDER BY timestamp DESC LIMIT 1");
		while($data = mysqli_fetch_array($result_getLastPlayTime)){
					$db_lastTimestamp = $data['timestamp'];
		}
		if(mysqli_num_rows($result_getLastPlayTime)==1){
			$stationName = mysqli_query($conn, "SELECT name FROM station WHERE id = '$station'");
			echo $stationName . "hat um " . $db_timestamp  . "das letzte mal die Playlist aktualisiert." . "<br>";
		}
	}
?>