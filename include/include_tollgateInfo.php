<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {																		//if REQUEST_METHOD == GET

	include_once 'include_db.php';																				//include db.php
	$query_getTollgate = "SELECT code, nameAutobahn, nameKreuz, kreuzNummer FROM mautstelle ORDER BY SUBSTR(nameAutobahn FROM 1 FOR 1), CAST(SUBSTR(nameAutobahn FROM 2) AS UNSIGNED)";					//SQL query getTollgate
	$result_getTollgate = mysqli_query($conn,$query_getTollgate);												//execute query and save

	echo "\t\t\t\t<table border='1'>\r\n";
	echo "\t\t\t\t\t<tr>\r\n";
	echo "\t\t\t\t\t\t<th>Code</th>\r\n";
	echo "\t\t\t\t\t\t<th>Autobahn</th>\r\n";
	echo "\t\t\t\t\t\t<th>Kreuz Name</th>\r\n";
	echo "\t\t\t\t\t\t<th>Kreuz Nummer</th>\r\n";
	echo "\t\t\t\t\t</tr>\r\n";

	while($data = mysqli_fetch_array($result_getTollgate))							//fetch arry getTollgate
	{
		echo "\t\t\t\t\t<tr class='userlistoutput'>\r\n";
		echo "\t\t\t\t\t\t<td width='120px'>" . $data['code'] . "</td>\r\n";					//echo code
		echo "\t\t\t\t\t\t<td width='120px'>" . $data['nameAutobahn'] . "</td>\r\n";			//echo nameAutobahn
		echo "\t\t\t\t\t\t<td width='120px'>" . $data['nameKreuz'] . "</td>\r\n";				//echo nameKreuz
		echo "\t\t\t\t\t\t<td width='120px'>" . $data['kreuzNummer'] . "</td>\r\n";				//echo kreuzNummer
		echo "\t\t\t\t\t</tr>\r\n";
	}
	  echo "\t\t\t\t</table>\r\n";
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {										//if REQUEST_METHOD == POST
	include_once 'include_db.php';
	$junctionName = $_POST["text-search-kreuz"];									//save text-search-kreuz in junctionName
	$highwayName = $_POST["text-search-autobahn"];									//save text-search-autobahn in highwayName

	$junctionName = mysqli_real_escape_string ($conn, $junctionName);				//escape junctionName
	$highwayName = mysqli_real_escape_string ($conn, $highwayName);					//escape highwayName


	$query_getTollgateInfo = "SELECT code, nameAutobahn, nameKreuz, kreuzNummer FROM mautstelle WHERE nameKreuz Like '%$junctionName%' AND nameAutobahn LIKE '%$highwayName' ORDER BY SUBSTR(nameAutobahn FROM 1 FOR 1), CAST(SUBSTR(nameAutobahn FROM 2) AS UNSIGNED)";		//SQL query getTollgateInfo
	$result_getTollgateInfo = mysqli_query($conn, $query_getTollgateInfo);			//execute query and save

	$rows = mysqli_num_rows($result_getTollgateInfo);
	if ($rows > 0){
		echo "\t\t\t\t<table border='1'>\r\n";
		echo "\t\t\t\t\t\t<tr>\r\n";
		echo "\t\t\t\t\t\t\t<th>Code</th>\r\n";
		echo "\t\t\t\t\t\t\t<th>Autobahn</th>\r\n";
		echo "\t\t\t\t\t\t\t<th>Kreuz Name</th>\r\n";
		echo "\t\t\t\t\t\t\t<th>Kreuz Nummer</th>\r\n";
		echo "\t\t\t\t\t\t</tr>\r\n";

		while($data = mysqli_fetch_array($result_getTollgateInfo)){						//fetch getTollgateInfo
			echo "\t\t\t\t\t\t<tr class='userlistoutput'>\r\n";
			echo "\t\t\t\t\t\t\t<td width='120px'>" . $data['code'] . "</td>\r\n";						//echo code
			echo "\t\t\t\t\t\t\t<td width='120px'>" . $data['nameAutobahn'] . "</td>\r\n";				//echo nameAutobahn
			echo "\t\t\t\t\t\t\t<td width='120px'>" . $data['nameKreuz'] . "</td>\r\n";					//echo nameKreuz
			echo "\t\t\t\t\t\t\t<td width='120px'>" . $data['kreuzNummer'] . "</td>\r\n";					//echo kreuzNummer
			echo "\t\t\t\t\t\t</tr>\r\n";
		}
		echo "\t\t\t\t\t</table>\r\n";
	}
	else{
		echo "\t\t\t\tDie Suche hat keine Ergebnisse ergeben.\r\n";
	}
}
?>
