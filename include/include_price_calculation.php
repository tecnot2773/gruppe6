<?php

	class price																																//create class price
	{		
		public static function get_price($distance)																							//create function get_price
		{
			$servername = "localhost";																										//create DB connection
			$username = "mysql";
			$password = "dbcodepw12";

			// Create connection
			$conn = new mysqli($servername, $username, $password);
			
			$conn->select_db("maut");
			
			$quary_get_kosten = "SELECT kosten FROM gebuehren WHERE bisEntfernung > $distance ORDER BY bisEntfernung ASC LIMIT 1";			//get kosten 
			$get_kosten = mysqli_real_escape_string ($conn, $quary_get_kosten);
			$result_kosten = mysqli_query($conn, $get_kosten);
			while ($data = mysqli_fetch_assoc($result_kosten)){
				$price_return = $data['kosten'];																							
			}
			return $price_return;																											//hand over price_return to funtion call
		}
	}
	
?>