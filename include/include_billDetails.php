<?php
include 'include_db.php';																								//create DB connection

$bill_id = $_GET["id"];																									//get id from html
$bill_id = mysqli_real_escape_string ($conn, $bill_id);

																														//get some data from database that is needed in the Bill
$query_getBillData = "SELECT kosten, berechneteKosten streckeID FROM rechnung WHERE id = $bill_id";
$billData = mysqli_query($conn, $query_getBillData);
while ($data1 = mysqli_fetch_array($billData)){
	$costs = $data1['kosten'];
	$routeId = $data1 ['streckeID'];
	$calcCosts = $data1['berechneteKosten'];
}

$query_getRouteData = "SELECT kilometer, kennzeichen, faehrtEinID, faehrtAusID FROM strecke WHERE id = $routeId";
$routeData = mysqli_query($conn, $query_getRouteData);
while ($data2 = mysqli_fetch_array($routeData)){
	$distance = $data2['kilometer'];
	$licensePlate = $data2['kennzeichen'];
	$entryId = $data2['faehrtEinID'];
	$exitId = $data2['faehrtAusID'];
}

$query_getEntryTollgateData = "SELECT zeitstempel, mautstelleID FROM faehrtEin WHERE id = $entryId";
$EntryTollgateData = mysqli_query($conn, $query_getEntryTollgateData);
while ($data3 = mysqli_fetch_array($EntryTollgateData)){
	$entryTime = $data3['zeitstempel'];
	$entryTollgate = $data3['mautstelleID'];
	$entryTime = date("d.m.Y H:i:s", strtotime($entryTime));
}

$query_getExitTollgateData = "SELECT zeitstempel, mautstelleID FROM faehrtAus WHERE id = $exitId";
$exitTollgateData = mysqli_query($conn, $query_getExitTollgateData);
while ($data4 = mysqli_fetch_array($exitTollgateData)){
	$exitTime = $data4['zeitstempel'];
	$exitTollgate = $data4['mautstelleID'];
	$exitTime = date("d.m.Y H:i:s", strtotime($exitTime));
}

$query_getEntryTollgateInfo = "SELECT code, nameAutobahn, nameKreuz FROM mautstelle WHERE id = $entryTollgate";
$entryTollgateInfo = mysqli_query($conn, $query_getEntryTollgateInfo);
while ($data5 = mysqli_fetch_array($entryTollgateInfo)){
	$entryTollgateCode = $data5['code'];
	$entryTollgateHighway = $data5['nameAutobahn'];
	$entryTollgateInterchange = $data5['nameKreuz'];
}

$query_getExitTollgateInfo = "SELECT code, nameAutobahn, nameKreuz FROM mautstelle WHERE id = $exitTollgate";
$exitTollgateInfo = mysqli_query($conn, $query_getExitTollgateInfo);
while ($data6 = mysqli_fetch_array($exitTollgateInfo)){
	$exitTollgateCode = $data6['code'];
	$exitTollgateHighway = $data6['nameAutobahn'];
	$exitTollgateInterchange = $data6['nameKreuz'];
}
?>
