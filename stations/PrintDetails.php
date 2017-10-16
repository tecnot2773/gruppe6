<?php
	include_once "db.php";

	$station = $_GET['station'];
	$type = $_GET['type'];
	if($type == "stationName"){
		$getstationName = mysqli_query($conn,"SELECT name FROM station WHERE IDs = '$station'");		//get Station Name from Id
		while($data = mysqli_fetch_array($getstationName)){
			$db_stationName = $data['name'];
			$stationName = strtoupper($db_stationName);
		}
		echo $stationName;
	}
	if($type == "avgStats"){
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
		echo $db_avgReplaysPerHour;
		echo $db_avgReplaysPerDay;
		echo $db_avgReplaysPerWeek;
		echo $db_avgReplaysPerMonth;
	}
	if($type == "weekChart"){
		$weekChart = "";
		for($i = 0; $i <= 6; $i++){
			$day = date('Y-m-d', strtotime("monday last week +$i Days"));		//get monday last week + i
			$getReplaysPerDayChart = mysqli_query($conn, "SELECT replaysPerDay FROM dailyStats WHERE stationId = '$station' AND timestamp LIKE '$day%'");
			if(mysqli_num_rows($getReplaysPerDayChart) >= 1){
				while($data = mysqli_fetch_array($getReplaysPerDayChart)){
					$db_DayChart = $data['replaysPerDay'];
					$weekChart = $weekChart . $db_DayChart . ", ";		//build string
				}
			}else{
				$db_DayChart = 0;
				$weekChart = $weekChart . $db_DayChart . ", ";		//build string
			}
		}
		$weekChart = rtrim($weekChart, ", ");			//trim string
		echo $weekChart;
	}
	if($type == "yearChart"){
		$monthChart = "";
		for ($i = 0; $i <= 11; $i++){
			$month = date('Y-m', strtotime("first day of january last year +$i Month"));
			$getReplaysPerMonthChart = mysqli_query($conn, "SELECT replaysPerMonth FROM yearlyStats WHERE stationId = '$station' AND timestamp LIKE '$month%'");
			if(mysqli_num_rows($getReplaysPerMonthChart) >= 1){
				while($data = mysqli_fetch_array($getReplaysPerMonthChart)){
					$db_MonthChart = $data['replaysPerMonth'];
					$monthChart = $monthChart . $db_MonthChart . ", ";
				}
			}else{
				$db_MonthChart = 0;
				$monthChart = $monthChart . $db_MonthChart . ", ";
			}
		}
		$monthChart = rtrim($monthChart, ", ");			//trim string
		echo $monthChart;
	}
?>