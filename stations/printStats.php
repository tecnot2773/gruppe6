<?php
	include_once "db.php";
	for($i = 1; $i <= 9; $i++){
		$station = $i;
		$time = date("Y-m-d H:i:s",strtotime("-10 minutes",strtotime(date("Y-m-d H:i:s"))));
		$result_getLastPlayTime = mysqli_query($conn, "SELECT * FROM plays WHERE stationId = '$station' AND timestamp > '$time%' ORDER BY timestamp DESC LIMIT 1");
		while($data = mysqli_fetch_array($result_getLastPlayTime)){
					$db_lastTimestamp = $data['timestamp'];
		}
		if(mysqli_num_rows($result_getLastPlayTime)==1){
			$result_getStationName = mysqli_query($conn, "SELECT name FROM station WHERE id = '$station'");
			while($data = mysqli_fetch_array($result_getStationName)){
				$stationName = $data['name'];
			}			
			echo $stationName . " hat um " . $db_lastTimestamp  . " das letzte mal die Playlist aktualisiert." . "<br>";
		}
		else{
			echo $stationName . " hat in den letzten 10 Minuten nicht die Playlist aktualisiert." . "<br>";
		}
	}
?>