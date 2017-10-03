<?php
include_once "db.php";
for($i = 1; $i <= 9; $i++){
	$station = $i;
	$time = date("Y-m-d h:i:s",strtotime("-10 minutes",strtotime(date("Y-m-d H:i:s"))));
	$result_getLastPlayTime = mysqli_query($conn, "SELECT * FROM plays WHERE stationId = '$station' AND timestamp LIKE '$time' LIMIT 1")
	
}



?>