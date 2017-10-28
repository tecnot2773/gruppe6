<?php
	include_once "db.php";
	$max = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM station"));					//check how many stations we have
	for($i = 1; $i <= $max; $i++){							
		$station = $i;																		//set $station = curren $i
		$time = date("Y-m-d H:i:s",strtotime("-10 minutes",strtotime(date("Y-m-d H:i:s"))));		//get current Time minus 10 Minutes
		$result_getLastPlayTime = mysqli_query($conn, "SELECT * FROM plays WHERE stationId = '$station' AND timestamp > '$time%' ORDER BY timestamp DESC LIMIT 1");		//Select last played song within 10min
		while($data = mysqli_fetch_array($result_getLastPlayTime)){
			$db_lastTimestamp = $data['timestamp'];
		}
		$result_getStationName = mysqli_query($conn, "SELECT name FROM station WHERE id = '$station'");				//select current station name
		while($data = mysqli_fetch_array($result_getStationName)){
			$stationName = $data['name'];
		}	
		if(mysqli_num_rows($result_getLastPlayTime)==1){						//if there was a song played in the last 10min
			$lastTimestamp = date("H:i",strtotime($db_lastTimestamp));			//cut timestamp from Y-m-d H:i:s to H:i
			echo $stationName . " hat um " . $lastTimestamp  . "Uhr das letzte mal die Playlist aktualisiert." . "<br>";
		}
		elseif(mysqli_num_rows($result_getLastPlayTime)==0){					//if there was no song played in the last 10min
			echo $stationName . " hat in den letzten 10 Minuten nicht die Playlist aktualisiert." . "<br>";
		}
		unset($result_getLastPlayTime);												//unset value
	}
?>