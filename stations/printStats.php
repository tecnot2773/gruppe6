<?php
	include_once "db.php";
	$max = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM station"));
	for($i = 1; $i <= $max; $i++){							
		$station = $i;
		$time = date("Y-m-d H:i:s",strtotime("-10 minutes",strtotime(date("Y-m-d H:i:s"))));
		$result_getLastPlayTime = mysqli_query($conn, "SELECT * FROM plays WHERE stationId = '$station' AND timestamp > '$time%' ORDER BY timestamp DESC LIMIT 1");
		while($data = mysqli_fetch_array($result_getLastPlayTime)){
			$db_lastTimestamp = $data['timestamp'];
		}
		$result_getStationName = mysqli_query($conn, "SELECT name FROM station WHERE id = '$station'");
		while($data = mysqli_fetch_array($result_getStationName)){
			$stationName = $data['name'];
		}	
		if(mysqli_num_rows($result_getLastPlayTime)==1){
			$lastTimestamp = date("H:i",strtotime($db_lastTimestamp));
			echo $stationName . " hat um " . $lastTimestamp  . "Uhr das letzte mal die Playlist aktualisiert." . "<br>";
		}
		elseif(mysqli_num_rows($result_getLastPlayTime)==0){
			echo $stationName . " hat in den letzten 10 Minuten nicht die Playlist aktualisiert." . "<br>";
		}
		unset($result_getLastPlayTime);
	}
?>