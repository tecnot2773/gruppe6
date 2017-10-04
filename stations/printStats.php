<?php
	include_once "db.php";
	$max = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM station"));					//check how many stations we have
	for($i = 1; $i <= $max; $i++){							
		$station = $i;
		
		$stationName = mysqli_query($conn,"SELECT name FROM station WHERE id = '$station'");
		while($data = mysqli_fetch_array($stationName)){
			$db_stationName = $data['name'];
		}
		
		
		
		
		
		
		
		
		
		
		echo"<tr>";
                  echo"<td>" . $db_stationName . "</td>";
                  echo"<td>0</td>";
                  echo"<td>54</td>";
                  echo"<td>100</td>";
                  echo"<td>999</td>";
			echo"</tr>";
	}
?>