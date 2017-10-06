<?php

	include_once "db.php";
	$yearEnd = date('Y-m-d', strtotime('Dec 31'));
	$yearStart = date('Y-m-d', strtotime('Jan 01'));
	$max = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM station"));					//check how many stations we have
	for($i = 1; $i <= $max; $i++){
		$station = $i;

		$avgReplaysPerMonth = 0;
		
		$query_replaysPerMonth = "SELECT replaysPerMonth FROM monthlyStats WHERE stationId = '$station' AND timestamp BETWEEN '$yearStart' AND '$yearEnd'";
		$result_replaysPerMonth = mysqli_query($conn, $query_replaysPerMonth);
		while($data = mysqli_fetch_array($result_replaysPerMonth)){
			$db_replaysPerMonth = $data['replaysPerMonth'];
			$avgReplaysPerMonth = $avgReplaysPerMonth + $db_replaysPerMonth;
		}
		echo $avgReplaysPerMonth . "<br>";
		$days = mysqli_num_rows($result_replaysPerMonth);
		$avgReplaysPerMonth = $avgReplaysPerMonth / $days;
		$avgReplaysPerMonth = round($avgReplaysPerMonth, 2);
		$avgReplaysPerMonth = number_format($avgReplaysPerMonth, 2);
		mysqli_query($conn, "UPDATE yearlyStats SET replaysPerMonth = '$avgReplaysPerMonth' WHERE stationId = '$station' AND timestamp BETWEEN '$yearStart' AND '$yearEnd'");
	}
?>