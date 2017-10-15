<?php
	include_once "db.php";

	$station = "1";
	$type = "stationName";
	if($type == stationName){
		$getstationName = mysqli_query($conn,"SELECT name FROM station WHERE IDs = '$station'");
		while($data = mysqli_fetch_array($getstationName)){
			$db_stationName = $data['name'];
			$stationName = strtoupper($db_stationName);
		}
		echo $stationName . "\r\n" . "<br>";
	}
	$type = "avgStats";
	if($type == avgStats){
		$getReplaysPerHour = mysqli_query($conn, "SELECT replaysPerHour FROM dailyStats WHERE stationId = '$station' ORDER BY timestamp DESC LIMIT 1");
		while($data = mysqli_fetch_array($getReplaysPerHour)){			//get Stats from last insert
			$db_avgReplaysPerHour = $data['replaysPerHour'];
		}
		
		$getReplaysPerDay = mysqli_query($conn, "SELECT replaysPerDay FROM weeklyStats WHERE stationId = '$station' ORDER BY timestamp DESC LIMIT 1");
		if(mysqli_num_rows($getReplaysPerDay) >= 1 ){					
			while($data = mysqli_fetch_array($getReplaysPerDay)){		//get Stats from last insert
				$db_avgReplaysPerDay = $data['replaysPerDay'];
			}
		}else{															//if no data is available from last insert
			$db_avgReplaysPerDay = "keine Daten vorhanden";
		}
		$getReplaysPerWeek = mysqli_query($conn, "SELECT replaysPerWeek FROM monthlyStats WHERE stationId = '$station' ORDER BY timestamp DESC LIMIT 1");
		if(mysqli_num_rows($getReplaysPerWeek) >= 1){
			while($data = mysqli_fetch_array($getReplaysPerWeek)){		//get Stats from last insert
				$db_avgReplaysPerWeek = $data['replaysPerWeek'];
			}
		}else{															//if no data is available  from last insert
			$db_avgReplaysPerWeek = "keine Daten vorhanden";
		}
		$getReplaysPerMonth = mysqli_query($conn, "SELECT replaysPerMonth FROM yearlyStats WHERE stationId = '$station' ORDER BY timestamp DESC LIMIT 1");
		if(mysqli_num_rows($getReplaysPerMonth) >= 1){		
			while($data = mysqli_fetch_array($getReplaysPerMonth)){			//get Stats from last insert
				$db_avgReplaysPerMonth = $data['replaysPerMonth'];
			}
		}else{
			$db_avgReplaysPerMonth = "keine Daten vorhanden";
		}
		echo $db_avgReplaysPerHour . "\r\n" . "<br>";
		echo $db_avgReplaysPerDay . "\r\n" . "<br>";
		echo $db_avgReplaysPerWeek . "\r\n" . "<br>";
		echo $db_avgReplaysPerMonth . "\r\n" . "<br>";
	}
	$type = "weekChart";
	if($type == weekChart){
		$monday = date('Y-m-d', strtotime('monday last week'));
		$time = strtotime($monday);
		
		for($i = 0; $i <= 6; $i++){
			$day = date('Y-m-d', strtotime('+ {$i} Days', $time));
			$getReplaysPerDayChart = mysqli_query($conn, "SELECT replaysPerDay FROM dailyStats WHERE stationId = '$station' AND timestamp LIKE '$day'");
			while($data = mysqli_fetch_array($getReplaysPerDayChart)){
				$db_DayChart = $data['replaysPerDay'];
				$chart . = $db_DayChart . ", ";
			}
		}
		echo $chart . "\r\n" . "<br>";
	}
?>