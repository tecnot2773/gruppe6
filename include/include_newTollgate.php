<?php
	include_once 'include_db.php';
	
	$code = $_POST["text-code"];
	$namehighway = $_POST["text-namehighway"];
	$namejunction = $_POST["text-namejunction"];
	$junctionNumber = $_POST["text-junctionNumber"];
	$lat_insert = $_POST["text-lat"];
	$lon_insert = $_POST["text-lon"];
	
	$code = mysqli_real_escape_string ($conn, $code);
	$namehighway = mysqli_real_escape_string ($conn, $namehighway);
	$namejunction = mysqli_real_escape_string ($conn, $namejunction);
	$junctionNumber = mysqli_real_escape_string ($conn, $junctionNumber);
	$lat_insert = mysqli_real_escape_string ($conn, $lat_insert);
	$lon_insert = mysqli_real_escape_string ($conn, $lon_insert);
	//Start Check TollgateCode
	$query_getTollgateCode = "SELECT code FROM mautstelle WHERE code = $code";
	$result_getTollgateCode = mysqli_query($conn, $query_getTollgateCode);
	$rows = mysqli_num_rows($result_getTollgateCode);
	if ($rows == 0){
		$checkTollgateCode = "TRUE";
	}
	if ($rows >= 1){
		$checkTollgateCode = "FALSE";
		echo "MautstellenCode ist bereits in der Datenbank";
	}
	//End Check TollgateCode
	if($checkTollgateCode == "TRUE"){
		if (preg_match("/^(\d{1,2})([.])(\d{1,10})$/", $lat_insert)){
			$wrongLat = "FALSE";
		}
		else
		{
			$wrongLat = "TRUE";
			echo "Latitude hat falsches Format";
		}
		
		if($wrongLat == "FALSE"){
			if (preg_match("/^(\d{1,2})([.])(\d{1,10})$/", $lon_insert)){
				$wrongLon = "FALSE";
			}
			else
			{
				$wrongLon = "TRUE";
				echo "Longitude hat falsches Format";
			}
		
			if($wrongLon == "FALSE"){
			
				$query_sql_add = "INSERT INTO mautstelle (code, nameAutobahn, nameKreuz, kreuzNummer, lat, lon) VALUES ('$code', '$namehighway', '$namejunction', '$junctionNumber', '$lat_insert', '$lon_insert')";
				mysqli_query($conn,$query_sql_add);
				echo "Mautstelle erfolgreich hinzugefügt";
			}
		}
	}
	
?>