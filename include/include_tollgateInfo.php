<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {								//if REQUEST_METHOD == GET

	include_once 'include/include_db.php';																				//include db.php
	$query_getTollgate = "SELECT id,code,nameAutobahn,nameKreuz,kreuzNummer FROM mautstelle ORDER BY nameAutobahn";					//SQL query getTollgate
	$result_getTollgate = mysqli_query($conn,$query_getTollgate);												//execute query and save

	echo "<table border='1'>
	<tr>
	<th>Code</th>
	<th>Autobahn</th>
	<th>Kreuz Name</th>
	<th>Kreuz Nummer</th>
	</tr>";

	while($data = mysqli_fetch_array($result_getTollgate))							//fetch arry getTollgate
	{
			echo "<tr class='userlistoutput'>";
			echo "<td width='120px'>" . $data['code'] . "</td>";					//echo code
			echo "<td width='120px'>" . $data['nameAutobahn'] . "</td>";			//echo nameAutobahn
			echo "<td width='120px'>" . $data['nameKreuz'] . "</td>";				//echo nameKreuz
			echo "<td width='120px'>" . $data['kreuzNummer'] . "</td>";				//echo kreuzNummer
			echo "</tr>";
   }
   }
   echo "</table>";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {										//if REQUEST_METHOD == POST
	$junctionName = $_POST["text-search-kreuz"];									//save text-search-kreuz in junctionName
	$highwayName = $_POST["text-search-autobahn"];									//save text-search-autobahn in highwayName
	
	$junctionName = mysqli_real_escape_string ($conn, $junctionName);				//escape junctionName
	$highwayName = mysqli_real_escape_string ($conn, $highwayName);					//escape highwayName
	
	echo "<table border='1'>
	<tr>
	<th>Code</th>
	<th>Autobahn</th>
	<th>Kreuz Name</th>
	<th>Kreuz Nummer</th>
	</tr>";
	
	$query_getTollgateInfo = "SELECT code, nameAutobahn, nameKreuz, kreuzNummer FROM mautstelle WHERE nameKreuz Like '%$junctionName%' AND nameAutobahn LIKE '%$highwayName' ORDER BY nameAutobahn ACS";		//SQL query getTollgateInfo
	$
		
	Info = mysqli_query($conn, $query_getTollgateInfo);			//execute query and save
	
	while($data = mysqli_fetch_array($result_getTollgateInfo)){						//fetch getTollgateInfo
		echo "<tr class='userlistoutput'>";
		echo "<td width='120px'>" . $data['code'] . "</td>";						//echo code
		echo "<td width='120px'>" . $data['nameAutobahn'] . "</td>";				//echo nameAutobahn
		echo "<td width='120px'>" . $data['nameKreuz'] . "</td>";					//echo nameKreuz
		echo "<td width='120px'>" . $data['kreuzNummer'] . "</td>";					//echo kreuzNummer
		echo "</tr>";
	}
}
echo "</table>";
?>
