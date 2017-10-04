<?php
	include_once "db.php";
	
	$currentMonth = date("Y-m");			
	$currentDay = date("Y-m-d");			
	$currentHour = date("Y-m-d H");			
	$currentSeconds = date("Y-m-d H:i:s");	
	
	$max = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM station"));					//check how many stations we have
	for($i = 1; $i <= $max; $i++){							
		$station = $i;
		
		$getstationName = mysqli_query($conn,"SELECT name FROM station WHERE id = '$station'");
		while($data = mysqli_fetch_array($getstationName)){
			$db_stationName = $data['name'];
		}
		$getReplaysPerHour = mysqli_query($conn, "SELECT replaysPerHour FROM hourlyStats WHERE stationId = '$station' AND timestamp LIKE '$currentHour'");
		while($data = mysqli_fetch_array($getReplaysPerHour)){
			$db_replaysPerHour = $data['replaysPerHour'];
		}
		
		
		
		
		
		
		
		
		
		echo"<tr>";
                  echo"<td>" . $db_stationName . "</td>";
                  echo"<td>" . $db_replaysPerHour . "</td>";
                  echo"<td>54</td>";
                  echo"<td>100</td>";
                  echo"<td>999</td>";
			echo"</tr>";
	}
?>