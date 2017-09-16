<?php
 include_once 'db.php';																		//include db.php
 
 $query_getRoute = "SELECT id, kennzeichen, faehrtEinID FROM strecke WHERE faehrtAusID IS NULL";		//query getRoute
 $result_getRoute = mysqli_query($conn,$query_getRoute);												//execute Query and save
 
	echo "<table border='1'>
	<tr>
	<th>ID</th>
	<th>Kennzeichen</th>
	<th>Autobahn Einfahrt</th>
	<th>Einfahrts Zeit</th>
	</tr>";

while($data1 = mysqli_fetch_array($result_getRoute)){																//fetch result_getRoute
	$db_entryID = $data1['faehrtEinID'];																			//save faehrtEinID in db_entryID
	$query_getTollgateEntry = "SELECT zeitstempel, mautstelleID FROM faehrtEin WHERE id = $db_entryID";				//query getTollgateEntry
	$result_getTollgateEntry = mysqli_query($conn, $query_getTollgateEntry);										//execute query and save
	while($data2 = mysqli_fetch_array($result_getTollgateEntry)){													//fetch result_getTollgateEntry
		$db_tollgateID = $data2['mautstelleID'];																	//save mautstelleID in db_tollgateID
		$query_getTollgateName = "SELECT nameAutobahn, nameKreuz FROM mautstelle WHERE ID = $db_tollgateID";		//query getTollgateName
		$result_getTollgateName = mysqli_query($conn, $query_getTollgateName);										//execute query and save
		while($data3 = mysqli_fetch_array($result_getTollgateName)){												//fetch result_getTollgateName

		echo "<tr class='userlistoutput'>";
		
		echo "<td width='45px'>" . $data1['id'] . "</td>"; 															//echo id
		echo "<td width='45px'>" . $data1['kennzeichen'] . "</td>";													//echo kennzeichen
		echo "<td width='70px'>" . $data3['nameAutobahn'] . "<br>". $data3['nameKreuz'] . "</td>";					//echo nameAutobahn
		echo "<td width='70px'>" . $data2['zeitstempel'] . "</td>";													//echo zeitstempel
		echo "</tr>";
		}
	}
}
echo "</table>";
?>