<?php
	$yearEnd = date('Y-m-d', strtotime('Dec 31'));
	$yearStart = date('Y-m-d', strtotime('Jan 01'));
	
	$max = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM station"));					//check how many stations we have
	for($i = 1; $i <= $max; $i++){
		$station = $i;
		$avgReplaysPerMonth = 0;
		
		$query_replaysPerDay = "SELECT replaysPerDay FROM dailyStats WHERE stationId = '$station' AND timestamp BETWEEN '$yearStart' AND '$yearEnd'";
		$result_replaysPerDay = mysqli_query($conn, $query_replaysPerDay);
		while($data = mysqli_fetch_array($result_replaysPerDay)){
			$db_replaysPerDay = $data['replaysPerDay'];
			$avgReplaysPerYear = $avgReplaysPerMonth + $db_replaysPerDay;
		}
		mysqli_query($conn, "UPDATE yearlyStats SET replaysPerYear = '$avgReplaysPerYear' WHERE stationId = '$station' AND timestamp BETWEEN '$yearStart' AND '$yearEnd'");
	}
?>