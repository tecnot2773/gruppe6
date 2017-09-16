<?php
	//Create connection
	include_once 'include_db.php';
	
	//Add new tollgate
	$action= $_POST["selection"];

	//add new vehicle entry
	if ($action == "entry")
	{
		$plate = $_POST["text-plate-entry"];
		$code_entrytollgate = $_POST["text-CodeEntry"];
		$entry_time = $_POST["text-time-entry"];
		
		$entry_time = mysqli_real_escape_string($conn, $entry_time);
		$plate = mysqli_real_escape_string ($conn, $plate);
		$code_entrytollgate = mysqli_real_escape_string ($conn, $code_entrytollgate);
		
		$plateLength = strlen($plate); 
		if($plateLength > 12){
			echo "Kennzeichen ist zu lang";
		}
		if($plateLength <= 12){
			$query_getPlateFromRoute = "SELECT kennzeichen FROM strecke WHERE kennzeichen = '$plate' AND faehrtAusID IS NULL";
			$resultPlateFromRoute = mysqli_query($conn, $query_getPlateFromRoute);
			$rows = mysqli_num_rows($resultPlateFromRoute);
			if ($rows == 0){
				$plateCheck = "TRUE";
			}
			if ($rows >= 1){
				echo "Kennzeichen ist bereits auf einer Autobahn";
				$plateCheck = "FALSE";
			}
			if($plateCheck == "TRUE"){
			
				//Start Check TollgateCode
				$query_getTollgateCode = "SELECT code FROM mautstelle";
				$result_getTollgateCode = mysqli_query($conn, $query_getTollgateCode);
				while ($data = mysqli_fetch_array($result_getTollgateCode)){
					$tollgateCode = $data['code'];
					if ($tollgateCode == $code_entrytollgate){
						$checkTollgateCode = "TRUE";
						break 1;
					}
					else{
						$checkTollgateCode = "FALSE";
					}
				}
				//End Check TollgateCode
				
				if($checkTollgateCode == "TRUE"){
					//Start Check Time
					if (empty($entry_time)){
						$entry_time = date("Y-m-d H:i:s");
					}
					else{
						$entry_time = $entry_time;
					}
					
					//if (preg_match("/^(\d{4})([.])(\d{2})([.])(\d{2})(\s)(\d{2})([:])(\d{2})([:])(\d{2})$/", $entry_time)){
					if (preg_match("/^(\d{2})([.])(\d{2})([.])(\d{4})(\s)(\d{2})([:])(\d{2})([:])(\d{2})$/", $entry_time)){	
					}
					else
					{
						$entry_time = date("d.m.Y H:i:s");
						echo "Falsche Zeitangabe - Zeitangabe wurde zu $entry_time geändert";
					}
					//End Check Time

					$quary_get_TollgateEntryId = "SELECT ID FROM mautstelle WHERE code = $code_entrytollgate";
					$result_entrytollgate = mysqli_query($conn, $quary_get_TollgateEntryId);
					while ($data = mysqli_fetch_array($result_entrytollgate)){
						$id_entrytollgate = $data['ID'];
					}
					
					$quary_sql_entry = "INSERT INTO faehrtEin (zeitstempel, mautstelleID) VALUES ('$entry_time', '$id_entrytollgate')";
					mysqli_query($conn, $quary_sql_entry);
					
					$entry_id = mysqli_insert_id ($conn);	//get ID from last INSERT

					$quary_sql_entry_distance = "INSERT INTO strecke (kennzeichen, faehrtEinID) VALUES ('$plate', '$entry_id')";
					mysqli_query($conn, $quary_sql_entry_distance);
					echo "Neue Einfahrt mit Kennzeichen $plate verbucht";
				}
				if($checkTollgateCode == "FALSE"){
					echo "Falscher MautstellenCode - Keine Einfahrt verbucht";
				}
			}
		}
	}
	//add new vehicle exit and update 
	if ($action == "exit")
	{
		$plate = $_POST["text-plate-exit"];
		$code_exittollgate = $_POST["text-CodeExit"];
		$exit_time = $_POST["text-time-exit"];
		
		$exit_time = mysqli_real_escape_string($conn, $exit_time);
		$plate = mysqli_real_escape_string ($conn, $plate);
		$code_exittollgate = mysqli_real_escape_string ($conn, $code_exittollgate);
		
		//Start Check if license plate is on Highway
		$query_getPlateFromRoute = "SELECT kennzeichen FROM strecke WHERE kennzeichen = '$plate' AND faehrtAusID IS NULL";
		$resultPlateFromRoute = mysqli_query($conn, $query_getPlateFromRoute);
		$rows = mysqli_num_rows($resultPlateFromRoute);
		if ($rows == 0){
			echo "Kennzeichen nicht Gefunden";
			$plateCheck = "FALSE";
		}
		if ($rows >= 1){
			$plateCheck = "TRUE";
		}
		if($plateCheck == "TRUE"){
			//Start Check TollgateCode
			$query_getTollgateCode = "SELECT code FROM mautstelle";
			$result_getTollgateCode = mysqli_query($conn, $query_getTollgateCode);
			while ($data = mysqli_fetch_array($result_getTollgateCode)){
				$tollgateCode = $data['code'];
				if ($tollgateCode == $code_exittollgate){
					$checkTollgateCode = "TRUE";
					break 1;
				}
				else{
					$checkTollgateCode = "FALSE";
				}
			}
			//End Check TollgateCode
			
			if($checkTollgateCode == "TRUE"){				
				if (empty($exit_time)){
					$exit_time = date("d-m-Y H:i:s");
				}
				else{
					$exit_time = $exit_time;
				}
				
				if (preg_match("/^(\d{2})([.])(\d{2})([.])(\d{4})(\s)(\d{2})([:])(\d{2})([:])(\d{2})$/", $exit_time)){
				}
				else
				{
					$exit_time = date("Y.m.d H:i:s");
					echo "Falsche Zeitangabe - Zeitangabe wurde zu $exit_time geändert";
				}
				
				$quary_get_TollgateExitId = "SELECT ID FROM mautstelle WHERE code = $code_exittollgate";
				$result_exittollgate = mysqli_query($conn, $quary_get_TollgateExitId);
				while ($data = mysqli_fetch_array($result_exittollgate)){
				$id_exittollgate = $data['ID'];
				}
				
				$quary_sql_exit = "INSERT INTO faehrtAus (zeitstempel, mautstelleID) VALUES ('$exit_time', '$id_exittollgate')";
				mysqli_query($conn, $quary_sql_exit);
				
				$exit_id = mysqli_insert_id ($conn);	//get ID from last INSERT
				
				$quary_sql_exit_dist = "UPDATE strecke SET faehrtAusID = '$exit_id' WHERE faehrtAusID IS NULL and kennzeichen = '$plate'";
				mysqli_query($conn, $quary_sql_exit_dist);
				
				//get tollgate IDs
				$quary_get_entry_id = "SELECT faehrtEinID FROM strecke WHERE faehrtAusID = $exit_id";
				$entry_id_calc = mysqli_fetch_assoc(mysqli_query($conn, $quary_get_entry_id))['faehrtEinID'];
				$quary_get_tollgate_id_one = "SELECT mautstelleID FROM faehrtEin WHERE id = $entry_id_calc";
				$tollgate_id_one = mysqli_fetch_assoc(mysqli_query($conn, $quary_get_tollgate_id_one))['mautstelleID'];
				$quary_get_tollgate_id_two = "SELECT mautstelleID FROM faehrtAus WHERE id = $exit_id";
				$tollgate_id_two = mysqli_fetch_assoc(mysqli_query($conn, $quary_get_tollgate_id_two))['mautstelleID'];
				//get coordiates
				$quary_sql_Code1 = "SELECT lat, lon FROM mautstelle WHERE id = $tollgate_id_one";
				$quary_sql_Code2 = "SELECT lat, lon FROM mautstelle WHERE id = $tollgate_id_two";
				
				$result1 = mysqli_query($conn,$quary_sql_Code1);

				while ($data = mysqli_fetch_assoc($result1)){
				$db_latitude1 = $data['lat'];
				$db_longitude1 = $data['lon'];
				}
				$result2 = mysqli_query($conn,$quary_sql_Code2);

				while ($data = mysqli_fetch_assoc($result2)){
				$db_latitude2 = $data['lat'];
				$db_longitude2 = $data['lon'];
				}
			
				//calculation
				include_once 'calculation.php';

					$distance = Geo::get_distance("$db_latitude1","$db_longitude1","$db_latitude2","$db_longitude2");
					
					$quary_push_distance = "UPDATE strecke SET kilometer = $distance WHERE faehrtEinID = $entry_id_calc and faehrtAusID = $exit_id";
					mysqli_query($conn, $quary_push_distance);
					
				//add Rechnung
				$quary_get_kosten = "SELECT kosten FROM gebuehren WHERE bisEntfernung > $distance ORDER BY bisEntfernung ASC LIMIT 1";
				$kosten = mysqli_fetch_assoc(mysqli_query($conn, $quary_get_kosten))['kosten'];
				$quary_get_strecke_id = "SELECT id FROM strecke WHERE faehrtEinID = $entry_id_calc and faehrtAusID = $exit_id and kennzeichen = '$plate'";
				$strecke_id = mysqli_fetch_assoc(mysqli_query($conn, $quary_get_strecke_id))['id'];
				
				$quary_add_rechnung = "INSERT INTO rechnung (kosten, streckeID) VALUES ('$kosten', '$strecke_id')";
				mysqli_query($conn, $quary_add_rechnung);
				echo "Neue Ausfahrt verbucht und Rechnung erstellt";
			}
			if($checkTollgateCode == "FALSE"){
			echo "Falscher MautstellenCode - Keine Ausfahrt verbucht";
			}
		}
	}
?>
