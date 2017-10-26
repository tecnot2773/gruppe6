<?php
	$action= $_POST["selection"];																											//get selection from html and save in action

	//add new vehicle entry
	if ($action == "entry")																													//if action = entry
	{
		$plate = $_POST["text-plate"];																								//get text-plate-entry and save in plate
		$highwayName = $_POST["text-Autobahn"];
		$junctionName = $_POST["text-Station"];																				//get text-codeEntry and save in codeEntryTollgate
		$entryTime = $_POST["text-time-entry"];																								//get text-time-entry and save in time

		$entryTime = mysqli_real_escape_string($conn, $entryTime);																			//escape entryTime
		$plate = mysqli_real_escape_string ($conn, $plate);																					//escape plate
		$highwayName = mysqli_real_escape_string ($conn, $highwayName);															//escape highwayName
		$junctionName = mysqli_real_escape_string($conn, $junctionName);														//escape junctionName


		$get_code = mysqli_query($conn, "SELECT code FROM mautstelle WHERE nameAutobahn = '$highwayName' AND nameKreuz = '$junctionName'");
		while($data = mysqli_fetch_array($get_code)){
			$db_code = $data['code'];
		}

		$plateLength = strlen($plate); 																										//get plate length
		if($plateLength > 12){																												//skip everything if plate is > 12
			echo "Kennzeichen ist zu lang";
		}
		if($plateLength <= 12){																												//do if plate is <= 12
			$query_getPlateFromRoute = "SELECT kennzeichen FROM strecke WHERE kennzeichen = '$plate' AND faehrtAusID IS NULL";				//query get Plate
			$result_getPlateFromRoute = mysqli_query($conn, $query_getPlateFromRoute);
			$rows = mysqli_num_rows($result_getPlateFromRoute);																				//get Rows from result
			if ($rows == 0){																												//if rows == 0 this plate is not already on the road
				$plateCheck = "TRUE";																										//check = True
			}
			if ($rows >= 1){																												//if rows >= 1 this plate is already is on the road
				echo "Kennzeichen ist bereits auf einer Autobahn";
				$plateCheck = "FALSE";																										//check = FALSE
			}
			if($plateCheck == "TRUE"){																										// if plate is not on the road
				//Start Check Time
				if (empty($entryTime)){																									//check if time is empty
					$entryTime = date("Y-m-d H:i:s");																					//if time is empty insert current time
				}
				else{
				$entryTime = $entryTime;

					if (preg_match("/^(\d{2})([.])(\d{2})([.])(\d{4})(\s)(\d{2})([:])(\d{2})([:])(\d{2})$/", $entryTime)){					//check if time format ist correct							$entryTime = date("Y-m-d H:i:s", strtotime($entryTime));
					}
					else
					{
						$entryTime = date("Y-m-d H:i:s");																					//if time format is not correct, replace with current time
						echo "Falsche Zeitangabe - Zeitangabe wurde zu $entryTime geändert. ";
					}
				}
				//End Check Time

				$query_getTollgateEntryId = "SELECT ID FROM mautstelle WHERE code = $db_code";
				$result_getEntryTollgateId = mysqli_query($conn, $query_getTollgateEntryId);
				while ($data = mysqli_fetch_array($result_getEntryTollgateId)){
					$db_EntryTollgateId = $data['ID'];
				}

				$query_sqlEntry = "INSERT INTO faehrtEin (zeitstempel, mautstelleID) VALUES ('$entryTime', '$db_code')";
				mysqli_query($conn, $query_sqlEntry);

				$entry_id = mysqli_insert_id ($conn);	//get ID from last INSERT

				$query_sqlEntryRoute = "INSERT INTO strecke (kennzeichen, faehrtEinID) VALUES ('$plate', '$entry_id')";
				mysqli_query($conn, $query_sqlEntryRoute);
				echo "Neue Einfahrt mit Kennzeichen $plate verbucht";
			}
		}
	}
	//add new vehicle exit and update
	if ($action == "exit")																													//do if action = exit
	{
		$plate = $_POST["text-plate"];
		$highwayName = $_POST["text-Autobahn"];
		$junctionName = $_POST["text-Station"];
		$exit_time = $_POST["text-time-exit"];

		$exit_time = mysqli_real_escape_string($conn, $exit_time);
		$plate = mysqli_real_escape_string ($conn, $plate);
		$highwayName = mysqli_real_escape_string ($conn, $highwayName);															//escape highwayName
		$junctionName = mysqli_real_escape_string($conn, $junctionName);														//escape junctionName

		$get_code = mysqli_query($conn, "SELECT code FROM mautstelle WHERE nameAutobahn = '$highwayName' AND nameKreuz = '$junctionName'");
		while($date = mysqli_fetch_array($get_code)){
			$db_code = $data['code'];
		}

		if (empty($exit_time)){
			$exit_time = date("Y-m-d H:i:s");
		}
		else{
			$exit_time = $exit_time;

		if (preg_match("/^(\d{2})([.])(\d{2})([.])(\d{4})(\s)(\d{2})([:])(\d{2})([:])(\d{2})$/", $exit_time)){
			$exit_time = date("Y-m-d H:i:s", strtotime($exit_time));
			}
			else
			{
				$exit_time = date("Y-m-d H:i:s");
				echo "Falsche Zeitangabe - Zeitangabe wurde zu $exit_time geändert. ";
			}
		}

		$query_getTollgateExitId = "SELECT ID FROM mautstelle WHERE code = $db_code";
		$result_getExitTollgateId = mysqli_query($conn, $query_getTollgateExitId);
		while ($data = mysqli_fetch_array($result_getExitTollgateId)){
			$db_exitTollgateId = $data['ID'];
		}

		$query_sqlExit = "INSERT INTO faehrtAus (zeitstempel, mautstelleID) VALUES ('$exit_time', '$db_exitTollgateId')";
		mysqli_query($conn, $query_sqlExit);

		$exit_id = mysqli_insert_id ($conn);																						//get ID from last INSERT

		$query_sqlExitRoute = "UPDATE strecke SET faehrtAusID = '$exit_id' WHERE faehrtAusID IS NULL and kennzeichen = '$plate'";
		mysqli_query($conn, $query_sqlExitRoute);

				//get tollgate IDs
		$query_getEntryId = "SELECT faehrtEinID FROM strecke WHERE faehrtAusID = $exit_id";
		$db_EntryId = mysqli_fetch_assoc(mysqli_query($conn, $query_getEntryId))['faehrtEinID'];
		$query_getTollgateIdOne = "SELECT mautstelleID FROM faehrtEin WHERE id = $db_EntryId";
		$db_TollgateIdOne = mysqli_fetch_assoc(mysqli_query($conn, $query_getTollgateIdOne))['mautstelleID'];
		$query_getTollgateIdTwo = "SELECT mautstelleID FROM faehrtAus WHERE id = $exit_id";
		$db_TollgateIdTwo = mysqli_fetch_assoc(mysqli_query($conn, $query_getTollgateIdTwo))['mautstelleID'];
				//get coordiates
		$query_sqlCodeOne = "SELECT lat, lon FROM mautstelle WHERE id = $db_TollgateIdOne";
		$query_sqlCodeTwo = "SELECT lat, lon FROM mautstelle WHERE id = $db_TollgateIdTwo";

		$result_sqlCodeOne = mysqli_query($conn,$query_sqlCodeOne);

		while ($data = mysqli_fetch_assoc($result_sqlCodeOne)){
			$db_latitude1 = $data['lat'];
			$db_longitude1 = $data['lon'];
		}
		$result_sqlCodeTwo = mysqli_query($conn,$query_sqlCodeTwo);

		while ($data = mysqli_fetch_assoc($result_sqlCodeTwo)){
			$db_latitude2 = $data['lat'];
			$db_longitude2 = $data['lon'];
		}

		//calculation
		include_once 'include_calculation.php';																						//include price calculation

		$distance = Geo::get_distance("$db_latitude1","$db_longitude1","$db_latitude2","$db_longitude2");						//hand over coordiates to distance function

		$query_updateRoute = "UPDATE strecke SET kilometer = $distance WHERE faehrtEinID = $db_EntryId and faehrtAusID = $exit_id";		//update strecke
		mysqli_query($conn, $query_updateRoute);

		//add Rechnung
		$query_getCost = "SELECT kosten FROM gebuehren WHERE bisEntfernung > $distance ORDER BY bisEntfernung ASC LIMIT 1";
		$db_costs = mysqli_fetch_assoc(mysqli_query($conn, $query_getCost))['kosten'];
		$query_getRouteId = "SELECT id FROM strecke WHERE faehrtEinID = $db_EntryId and faehrtAusID = $exit_id and kennzeichen = '$plate'";
		$db_routeId = mysqli_fetch_assoc(mysqli_query($conn, $query_getRouteId))['id'];

		$query_insertBill = "INSERT INTO rechnung (kosten, streckeID) VALUES ('$db_costs', '$db_routeId')";
		mysqli_query($conn, $query_insertBill);
		echo "Neue Ausfahrt verbucht und Rechnung erstellt";
		if($checkTollgateCode == "FALSE"){
		echo "Falscher MautstellenCode - Keine Ausfahrt verbucht";
		}
	}
?>
