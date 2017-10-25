<?php
	include_once "db.php";

	$station = $_GET['station'];		
	$type = $_GET['type'];
	
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
			$month = date('Y-m', strtotime("first day of january +$i Month"));
			$query_getMonthChart = "SELECT replaysPerMonth FROM yearlyStats WHERE stationId = '$station' AND timestamp LIKE '$month%'";
			$getReplaysPerMonthChart = mysqli_query($conn, $query_getMonthChart);
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
