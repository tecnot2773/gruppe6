<?php
	//Create connection
	include_once 'db.php';
	
	//Add new tollgate
	$action= $_POST["selection"];
	
	if ($action == "add")
	{
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
		
		
		$quary_sql_add = "INSERT INTO mautstelle (code, nameAutobahn, nameKreuz, kreuzNummer, lat, lon) VALUES ('$code', '$namehighway', '$namejunction', '$junctionNumber', '$lat_insert', '$lon_insert')";
		
		mysqli_query($conn,$quary_sql_add);
	}
	
	//add new vehicle entry
	if ($action == "entry")
	{
		$plate = $_POST["text-plate-entry"];
		$code_entrytollgate = $_POST["text-CodeEntry"];
		$entry_time = $_POST["text-time-entry"];
		
		$quary_getTollgateCode = "SELECT code FROM mautstelle";
		$result_getTollgateCode = mysqli_query($conn, $quary_getTollgateCode);
		while ($data3 = mysqli_fetch_array($result_getTollgateCode){
			$tollgateCode = $data3['code'];
			if ($tollgateCode == $code_entrytollgate){
				$checkTollgateCode = "true";
			}
			else{
				echo "Falscher MautstellenCode - Keine Einfahrt verbucht";
				$checkTollgateCode = "false";
			}
		}
		if($checkTollgateCode == "true"){
			echo "Richtiger Code";
			
			if (empty($entry_time)){
				$entry_time = date("Y-m-d H:i:s");
			}
			else{
				$entry_time = $entry_time;
			}
			
			if (preg_match("/^(\d{4})([-])(\d{2})([-])(\d{2})(\s)(\d{2})([:])(\d{2})([:])(\d{2})$/", $entry_time)){
			}
			else
			{
				$entry_time = date("Y-m-d H:i:s");
				echo "Falsche Zeitangabe - Zeitangabe wurde zu $entry_time geändert";
			}
			
			$entry_time = mysqli_real_escape_string($conn, $entry_time);
			$plate = mysqli_real_escape_string ($conn, $plate);
			$code_entrytollgate = mysqli_real_escape_string ($conn, $code_entrytollgate);
			
			$quary_get_TollgateEntryId = "SELECT ID FROM mautstelle WHERE code = $code_entrytollgate";
			$result_entrytollgate = mysqli_query($conn, $quary_get_TollgateEntryId);
			while ($data1 = mysqli_fetch_array($result_entrytollgate)){
			$id_entrytollgate = $data1['ID'];
			}
			
			$quary_sql_entry = "INSERT INTO faehrtEin (zeitstempel, mautstelleID) VALUES ('$entry_time', '$id_entrytollgate')";
			mysqli_query($conn, $quary_sql_entry);
			
			$entry_id = mysqli_insert_id ($conn);	//get ID from last INSERT

			$quary_sql_entry_distance = "INSERT INTO strecke (kennzeichen, faehrtEinID) VALUES ('$plate', '$entry_id')";
			mysqli_query($conn, $quary_sql_entry_distance);
		}
	}
	
	//add new vehicle exit and update 
	if ($action == "exit")
	{
		$plate = $_POST["text-plate-exit"];
		$code_exittollgate = $_POST["text-CodeExit"];
		$exit_time = $_POST["text-time-exit"];

		if (empty($exit_time)){
			$exit_time = date("Y-m-d H:i:s");
		}
		else{
			$exit_time = $exit_time;
		}
		
		if (preg_match("/^(\d{4})([-])(\d{2})([-])(\d{2})(\s)(\d{2})([:])(\d{2})([:])(\d{2})$/", $exit_time)){
			echo "Richtiges Zeitangabe";
		}
		else
		{
			$exit_time = date("Y-m-d H:i:s");
			echo "Falsche Zeitangabe - Zeitangabe wurde zu $exit_time geändert";
		}
		$exit_time = mysqli_real_escape_string($conn, $exit_time);
		$plate = mysqli_real_escape_string ($conn, $plate);
		$code_exittollgate = mysqli_real_escape_string ($conn, $code_exittollgate);
		
		$quary_get_TollgateExitId = "SELECT ID FROM mautstelle WHERE code = $code_exittollgate";
		$result_exittollgate = mysqli_query($conn, $quary_get_TollgateExitId);
		while ($data2 = mysqli_fetch_array($result_exittollgate)){
		$id_exittollgate = $data2['ID'];
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
		
	}
	
	/**class check{
		public static function get_sucess ($selction_error)
		$error_list = mysqli_error_list($conn);

		if(!isset($error_list){
			return "Ein Fehler ist Aufgetreten";
		}
		else
		{
			return "Alle Werte erfolgreich eingetragen";
		}
	return 
	}*/
?>