<?php

	
	class Details
	{
		
		public static function getName($stationId, $conn)
		{
			$getstationName = mysqli_query($conn,"SELECT name FROM station WHERE IDs = '$stationId'");		//get Station Name from Id
			while($data = mysqli_fetch_array($getstationName)){
			$db_stationName = $data['name'];
			$stationName = strtoupper($db_stationName);
			
			echo $stationName;
			}
		}
		public static function getHour($station, $conn)
		{
			$getReplaysPerHour = mysqli_query($conn, "SELECT replaysPerHour FROM dailyStats WHERE stationId = '$station' ORDER BY timestamp DESC LIMIT 1");
			while($data = mysqli_fetch_array($getReplaysPerHour)){			//get Stats from last insert
				$db_avgReplaysPerHour = $data['replaysPerHour'];
				
				echo $db_avgReplaysPerHour;
			}
		}
		public static function getDay($station, $conn)
		{
			$getReplaysPerDay = mysqli_query($conn, "SELECT replaysPerDay FROM weeklyStats WHERE stationId = '$station' ORDER BY timestamp DESC LIMIT 1");
			if(mysqli_num_rows($getReplaysPerDay) >= 1 ){					
				while($data = mysqli_fetch_array($getReplaysPerDay)){		//get Stats from last insert
					$db_avgReplaysPerDay = $data['replaysPerDay'];
				}
			}else{															//if no data is available from last insert
				$db_avgReplaysPerDay = "keine Daten vorhanden";
			}
			
			echo $db_avgReplaysPerDay;
		}
		public static function getWeek($station, $conn)
		{
			$getReplaysPerWeek = mysqli_query($conn, "SELECT replaysPerWeek FROM monthlyStats WHERE stationId = '$station' ORDER BY timestamp DESC LIMIT 1");
			if(mysqli_num_rows($getReplaysPerWeek) >= 1){
				while($data = mysqli_fetch_array($getReplaysPerWeek)){		//get Stats from last insert
					$db_avgReplaysPerWeek = $data['replaysPerWeek'];
				}
			}else{															//if no data is available  from last insert
				$db_avgReplaysPerWeek = "keine Daten vorhanden";
			}
			
			echo $db_avgReplaysPerWeek;
		}
		public static function getMonth($station, $conn)
		{
			$getReplaysPerMonth = mysqli_query($conn, "SELECT replaysPerMonth FROM yearlyStats WHERE stationId = '$station' ORDER BY timestamp DESC LIMIT 1");
			if(mysqli_num_rows($getReplaysPerMonth) >= 1){		
				while($data = mysqli_fetch_array($getReplaysPerMonth)){			//get Stats from last insert
					$db_avgReplaysPerMonth = $data['replaysPerMonth'];
				}
			}else{
				$db_avgReplaysPerMonth = "keine Daten vorhanden";
			}
			
			echo $db_avgReplaysPerMonth;
		}
		public static function mostPlayedSongWeek($station, $conn, $select){
			$get_mostPlayedSong = myslqi_query($conn,"SELECT s.artist, s.name, wS.count FROM weeklyStats wS JOIN song s ON wS.mostPlayedSong = s.id WHERE wS.stationId = '$station' ORDER BY timestamp DESC LIMIT 1");
			while ($data = mysqli_fetch_array($get_mostPlayedSong)){
				$db_artist = $data['artist'];
				$db_song = $data['name'];
				$db_count = $data['count'];
			}
			if($select == 'artist'){
				echo $db_artist;
			}
			if($select == 'song'){
				echo $db_song;
			}
			if($select == 'count'){
				echo $db_count;
			}
		}
	}
	
?>
