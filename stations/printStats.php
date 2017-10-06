<?php
	include_once "db.php";
	
	$currentMonth = date("Y-m");			
	$currentDay = date("Y-m-d");			
	$currentHour = date("Y-m-d H");			
	$currentSeconds = date("Y-m-d H:i:s");
	$yearEnd = date('Y-m-d', strtotime('Dec 31'));
	$yearStart = date('Y-m-d', strtotime('Jan 01'));
	$firstAndLastOfMonth = mysqli_query($conn,"
	SELECT
	DATE_SUB(
		LAST_DAY(
			DATE_ADD(NOW(), INTERVAL 0 MONTH)
		), 
		INTERVAL DAY(
			LAST_DAY(
				DATE_ADD(NOW(), INTERVAL 0 MONTH)
			)
		)-1 DAY
	) AS firstOfThisMonth,
	
	LAST_DAY(
		DATE_ADD(NOW(), INTERVAL 0 MONTH)
	)AS lastOfThisMonth");											//get first and last day of this month
	while($data = mysqli_fetch_array($firstAndLastOfMonth)){
		$firstOfMonth = $data['firstOfThisMonth'];
		$lastOfMonth = $data['lastOfThisMonth'];
	}
	
	$query_getStationOrder = "SELECT * FROM station s join yearlyStats yS on s.id = yS.stationId where yS.replaysPerMonth > 1 AND yS.timestamp LIKE '2017%' order by yS.replaysPerMonth DESC";
	$result_getStationOrder = mysqli_query($conn,$query_getStationOrder);
	print_r($result_getStationOrder);
	while($data = mysqli_fetch_array($result_getStationOrder)){
		$i = $data['id'];					
		$station = $i;
		echo $station . "<br>";
		$getstationName = mysqli_query($conn,"SELECT name FROM station WHERE id = '$station'");
		while($data = mysqli_fetch_array($getstationName)){
			$db_stationName = $data['name'];
			$stationName = strtoupper($db_stationName);
		}
		$getReplaysPerDay = mysqli_query($conn, "SELECT replaysPerDay FROM weeklyStats WHERE stationId = '1' AND `timestamp` >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY AND `timestamp` < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY");
		if(mysqli_num_rows($getReplaysPerDay) >= 1 ){					
			while($data = mysqli_fetch_array($getReplaysPerDay)){		//get Stats from last week
				$db_avgReplaysPerDay = $data['replaysPerDay'];
			}
		}else{															//if no data is available from last week
			$db_avgReplaysPerDay = "keine Daten vorhanden";
		}
		$getReplaysPerWeek = mysqli_query($conn, "SELECT replaysPerWeek FROM monthlyStats WHERE stationId = '$station' AND YEAR(`timestamp`) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) AND MONTH(`timestamp`) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)");
		if(mysqli_num_rows($getReplaysPerWeek) >= 1){
			while($data = mysqli_fetch_array($getReplaysPerWeek)){		//get Stats from last Month
				$db_avgReplaysPerWeek = $data['replaysPerWeek'];
			}
		}else{															//if no data is available from last month
			$db_avgReplaysPerWeek = "keine Daten vorhanden";
		}
		$getReplaysPerMonth = mysqli_query($conn, "SELECT replaysPerMonth FROM yearlyStats WHERE stationId = '$station' AND timestamp BETWEEN '$yearStart' AND '$yearEnd'");
		while($data = mysqli_fetch_array($getReplaysPerMonth)){			//get data from this year
			$db_avgReplaysPerMonth = $data['replaysPerMonth'];
		}
		
		
		
		
		
		
		
		
		echo"<tr>";
                  echo"<td>" . $stationName . "</td>";
                  echo"<td>" . " RAUS JUNGE " . "</td>";
                  echo"<td>" . $db_avgReplaysPerDay . "</td>";
                  echo"<td>" . $db_avgReplaysPerWeek . "</td>";
                  echo"<td>" . $db_avgReplaysPerMonth . "</td>";
			echo"</tr>";
	}
?>