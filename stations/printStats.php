<?php
	include_once "db.php";
	
	$currentYear = date("Y");
	$currentMonth = date("Y-m");			
	$currentDay = date("Y-m-d");			
	$currentHour = date("Y-m-d H");			
	$currentSeconds = date("Y-m-d H:i:s");
	$yearEnd = date('Y-m-d', strtotime('Dec 31'));
	$yearStart = date('Y-m-d', strtotime('Jan 01'));
	$lastDay = date('Y-m-d',(strtotime ( '-1 day' , strtotime ( $currentDay) ) ));
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
	
	$query_getStationOrder = "SELECT `IDs` FROM station s JOIN weeklyStats wS ON s.IDs = wS.stationId where YEARWEEK(`timestamp`, 1) = YEARWEEK(CURDATE(), 1) order by wS.replaysPerDay ASC";
	$result_getStationOrder = mysqli_query($conn,$query_getStationOrder);
	if(mysqli_num_rows($result_getStationOrder) == 0){
		$query_getStationOrder = "SELECT `IDs` FROM station s JOIN dailyStats yS ON s.IDs = yS.stationId where yS.timestamp LIKE '$lastDay%' order by yS.replaysPerDay ASC";
		$result_getStationOrder = mysqli_query($conn,$query_getStationOrder);
	}
	while($data = mysqli_fetch_array($result_getStationOrder)){
		$i = $data['IDs'];					
		$station = $i;
		$getstationName = mysqli_query($conn,"SELECT name FROM station WHERE IDs = '$station'");
		while($data = mysqli_fetch_array($getstationName)){
			$db_stationName = $data['name'];
			$stationName = strtoupper($db_stationName);
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
		
		
		
		
		
		
			echo "\t\t\t\t <tr>\r\n";
			echo "\t\t\t\t\t <td><a href=\"/stations/ui/details.php?stationname=%22" . $stationName . "%22&amp;stationid=" . "1" . "\">" . $stationName . "</a></td>\r\n";
            echo "\t\t\t\t\t <td>" . $db_avgReplaysPerDay . "</td>\r\n";
            echo "\t\t\t\t\t <td>" . $db_avgReplaysPerWeek . "</td>\r\n";
            echo "\t\t\t\t\t <td>" . $db_avgReplaysPerMonth . "</td>\r\n";
			echo "\t\t\t\t </tr>\r\n";
			echo "\r\n";
	}	
?>