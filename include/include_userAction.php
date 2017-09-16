<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {										//Check if REQUEST_METHOD == POST
	include_once 'include/include_calculation.php';											//include calculaction.php
	$code1 = $_POST["text-startstation"];											//write input from text-startstation in code1
	$code2 = $_POST["text-endstation"];												//write input from text-endstation in code2
	
	$code1 = mysqli_real_escape_string ($conn, $code1);								//escape string "code1"
	$code2 = mysqli_real_escape_string ($conn, $code2);								//escape string "code2"

	$query_getTollgateCode = "SELECT code FROM mautstelle WHERE code = $code1";		//SQL query getTollgateCode1
	$result_getTollgateCode = mysqli_query($conn, $query_getTollgateCode);			//execute query getTollgateCode and save
	$rows = mysqli_num_rows($result_getTollgateCode);								//get rows from getTollgateCode
	if ($rows == 0){																//if rows == 0 checktollgateCode = FALSE 
	$checkTollgateCode = "FALSE";
	}
	if($rows >= 1){																	//if rows >=1 checktollgateCode = TRUE
		$checkTollgateCode = "TRUE";
	}
	if($checkTollgateCode == "TRUE"){												//if checkTollgateCode == TRUE
		$query_getTollgateCode = "SELECT code FROM mautstelle WHERE code = $code2";	//SQL query getTollgateCode1
		$result_getTollgateCode = mysqli_query($conn, $query_getTollgateCode);	    //execute query getTollgateCode and save
		$rows = mysqli_num_rows($result_getTollgateCode);                           //get rows from getTollgateCode
		if ($rows == 0){                                                            //if rows == 0 checktollgateCode = FALSE 
		$checkTollgateCode = "FALSE";                                               
		}                                                                           
		if($rows >= 1){                                                             //if rows >=1 checktollgateCode = TRUE
			$checkTollgateCode = "TRUE";
		}
		if($checkTollgateCode == "TRUE"){											//if checktollgateCode still TRUE
			$query_getLatLon1 = "SELECT lat, lon FROM mautstelle WHERE code = $code1";		//sql getLanLon1
			$query_getLatLon2 = "SELECT lat, lon FROM mautstelle WHERE code = $code2";		//sql getLanLon2
			
			$result_getLanLon1 = mysqli_query($conn,$query_getLatLon1);				//execute Query and save result

			while ($data = mysqli_fetch_assoc($result_getLanLon1)){					//fetch array result_getLanLon1
			$db_latitude1 = $data['lat'];											//save lan in db_latitude1
			$db_longitude1 = $data['lon'];											//save lon in db_longitude1
			}
			$result_getLanLon2 = mysqli_query($conn,$query_getLatLon2);				//execute Query and save result

			while ($data = mysqli_fetch_assoc($result_getLanLon2)){					//fetch arry result_getLanLon2
			$db_latitude2 = $data['lat'];											//save lan in db_latitude2
			$db_longitude2 = $data['lon'];											//save lon in db_longitude2
			}	
			$distance = Geo::get_distance("$db_latitude1","$db_longitude1","$db_latitude2","$db_longitude2");		//hand over variables to distance function 
			echo "Die Entfernung beträgt: ".$distance." km.";						//echo distance from function
			echo "<br>";
			
			include_once 'include/include_price_calculation.php';					//include price_calculation.php
			$price = price::get_price("$distance");									//hand over variable to price function
			echo "Der Preis für diese Entfernung beträgt: ".$price." Euro.";		//echo price from function
		}
		
	}
	if($checkTollgateCode == "FALSE"){												//if checktollgateCode == FALSE 
		echo "MautstellenCode ist nicht in der Datenbank";							//echo error message
	}
}
else	
{
	echo "<br>"; //empty line, we need the same height all the time!
}
?>