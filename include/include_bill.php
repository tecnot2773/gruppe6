<?php
include_once 'include_db.php';																										//include db.php
 
$query_getBill = "SELECT id, kosten, streckeID FROM rechnung ORDER BY id DESC";												//query getBill
$result_getBill = mysqli_query($conn,$query_getBill);																		//execute query and save

echo "<table border='1'>
<tr>
<th>ID</th>
<th>Kennzeichen</th>
<th>Autobahn Einfahrt</th>
<th>Autobahn Ausfahrt</th>
<th>Ausfahrt Zeit</th>
<th>Kosten</th>
</tr>";

while($data1 = mysqli_fetch_array($result_getBill)){																		//fetch getBill
	$db_distanceID = $data1['streckeID'];																					//save streckeID in db_distanceID	
	$query_getDistance = "SELECT kilometer, kennzeichen, faehrtEinID, faehrtAusID FROM strecke WHERE id = $db_distanceID";	//query getDistance
	$result_getDistance = mysqli_query($conn, $query_getDistance);															//execute query and save
	while ($data2 = mysqli_fetch_array($result_getDistance)){																//fetch getDistance
		$db_getTollgateEntry = $data2['faehrtEinID'];																		//save faehrtEinID in db_getTollgateEntry
		$db_getTollgateExit = $data2['faehrtAusID'];																		//save faehrtAusID in db_getTollgateExit
		
		$query_getTollgateidEntry = "SELECT mautstelleID FROM faehrtEin WHERE id = $db_getTollgateEntry";					//query getTollgateidEntry
		$result_getTollgateidEntry = mysqli_query($conn, $query_getTollgateidEntry);										//execute query and save
		while ($data3 = mysqli_fetch_array($result_getTollgateidEntry)){													//fetch getTollgateidEntry
			$db_getTollgateEntry2 = $data3['mautstelleID'];																	//save mautstelleID in getTollgateidEntry2
		
			$query_getTollgateidExit = "SELECT zeitstempel,mautstelleID FROM faehrtAus WHERE id = $db_getTollgateExit";	
			$result_getTollgateidExit = mysqli_query($conn, $query_getTollgateidExit);
			while ($data4 = mysqli_fetch_array($result_getTollgateidExit)){
				$db_getTollgateExit2 = $data4['mautstelleID'];
				
				$query_getHighwaynameEntry = "SELECT nameAutobahn, nameKreuz FROM mautstelle WHERE ID = $db_getTollgateEntry2";
				$result_getHighwaynameEntry = mysqli_query($conn, $query_getHighwaynameEntry);
				while ($data5 = mysqli_fetch_array($result_getHighwaynameEntry)){
					$query_get_HighwaynameExit = "SELECT nameAutobahn, nameKreuz FROM mautstelle WHERE ID = $db_getTollgateExit2";
					$result_getHighwaynameExit = mysqli_query($conn, $query_get_HighwaynameExit);
					while ($data6= mysqli_fetch_array($result_getHighwaynameExit)){
					
					echo "<tr class='userlistoutput'>";																		//html chart with output
					echo "<td width='45px'><a target=\"_blank\" href=\"detail/index.php?id=" . $data1['id'] . "\">" . $data1['id'] . "</a></td>";
					
					echo "<td width='45px'>" . $data2['kennzeichen'] . "</td>";
					echo "<td width='70px'>" . $data5['nameAutobahn'] . "<br>". $data5['nameKreuz'] . "</td>";
					echo "<td width='70px'>" . $data6['nameAutobahn'] . "<br>". $data6['nameKreuz'] . "</td>";
					echo "<td width='70px'>" . $data4['zeitstempel'] . "</td>";
					echo "<td width='70px'>" . $data1['kosten'] . "&nbsp;" . "\xE2\x82\xAc" . "</td>";
					echo "</tr>";
					}
				}
			}
		}
	}
}
echo "</table>";
?>
			   
			   
			   
			   