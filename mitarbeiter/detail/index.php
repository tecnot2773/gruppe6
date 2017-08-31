<?php
include '../../include/db.php';

$bill_id = $_GET["id"];

$query_getBillData = "SELECT kosten, streckeID FROM rechnung WHERE id = $bill_id";
$billData = mysqli_query($conn, $query_getBillData);
while ($data1 = mysqli_fetch_array($billData)){
	$costs = $data1['kosten'];
	$routeId = $data1 ['streckeID'];
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
}

$query_getExitTollgateData = "SELECT zeitstempel, mautstelleID FROM faehrtAus WHERE id = $exitId";
$exitTollgateData = mysqli_query($conn, $query_getExitTollgateData);
while ($data4 = mysqli_fetch_array($exitTollgateData)){
	$exitTime = $data4['zeitstempel'];
	$exitTollgate = $data4['mautstelleID'];
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

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Mautrechnung</title>
    <link rel="stylesheet" href="style.css" media="all" />
  </head>
  <body>
    <header class="clearfix">
      <div id="logo">
        <img src="../../images/logo-big.png">
      </div>
      <h1>Rechnung #<?php echo $bill_id ?></h1>
      <div id="company" class="clearfix">
        <div>Gruppe 6 security corporation</div>
        <div>GG Street 42,<br /> 1337 Berlin </div>
      </div>

      <div id="briefkopf">
        <div><span>Kennzeichen</span> <?php echo $licensePlate ?></div>
        <div><span>Zeitpunkt</span> <?php echo $exitTime ?></div>
      </div>
    </header>
    <main>
      <table>
        <thead>
          <tr>
            <th class="service">Art</th>
            <th class="desc">Beschreibung</th>
            <th></th>
            <th></th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="service">Start</td>
            <td class="desc">Autobahn <?php echo $entryTollgateHighway ?> Auffahrt <?php echo $entryTollgateInterchange ?><br>Am <?php echo $entryTime ?></td>
            <td class="unit">Mautstellen Code <?php echo $entryTollgateCode ?></td>
            <td class="qty"></td>
            <td class="total"></td>
          </tr>
          <tr>
            <td class="service">Strecke</td>
            <td class="desc"><?php echo $distance ?> Kilometer.</td>
            <td class="unit"></td>
            <td class="qty"></td>
            <td class="total"></td>
          </tr>
          <tr>
            <td class="service">Ende</td>
            <td class="desc">Autobahn <?php echo $exitTollgateHighway ?> Ausfahrt <?php echo $exitTollgateInterchange ?><br>Am <?php echo $exitTime ?></td>
            <td class="unit">Mautstellen Code <?php echo $exitTollgateCode ?></td>
            <td class="qty"></td>
            <td class="total"></td>
          </tr>
          <tr>
            <td colspan="4"></td>
            <td class="total"></td>
          </tr>
          <tr>
            <td colspan="4"> </td>
            <td class="total"></td>
          </tr>
          <tr>
            <td colspan="4" class="grand total">Summe</td>
            <td class="grand total"><?php echo $costs ?>€</td>
          </tr>
        </tbody>
      </table>
      <div id="notices">
        <div>Zahlungsbedingungen:</div>
        <div class="notice">Zahlbar innerhalb von 14 Tagen ohne Abzug</div>
      </div>
    </main>
    <footer>
      Invoice was created on a computer and is valid without the signature and seal.
    </footer>
  </body>
</html>