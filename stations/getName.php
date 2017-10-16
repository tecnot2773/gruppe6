<?php

	include_once "db.php";
	
	class Name
	{
		
		public static function getName($stationId)
		{
			$getstationName = mysqli_query($conn,"SELECT name FROM station WHERE IDs = '$stationId'");		//get Station Name from Id
			while($data = mysqli_fetch_array($getstationName)){
			$db_stationName = $data['name'];
			$stationName = strtoupper($db_stationName);
			
			echo $stationName;
		}
		
	}