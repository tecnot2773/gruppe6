<?php
	include 'include_db.php';
	class Tollgate
	{
		public static function getHighway($conn)
		{

			$query_getHighway = "SELECT DISTINCT nameAutobahn FROM `mautstelle`";											//sql query to get  kennzeichen
			$result_getHighway = mysqli_query($conn,$query_getHighway);												//execute query and save
			while($data = mysqli_fetch_array($result_getHighway)){												//fetch data from result_getPlate
				echo '<option value="' . $data['nameAutobahn'] . '">' . $data['nameAutobahn']. '</option>';		//use echo to execute html in php
			}
		}
	}

?>