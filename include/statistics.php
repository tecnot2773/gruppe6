<?php
include_once 'db.php';

$query_tollgateNumber = "SELECT * FROM mautstelle";
$result_tollgateNumber = mysqli_query($conn,$query_tollgateNumber);
$tollgateNumberRows = mysqli_num_rows($result_tollgateNumber);
echo "Es sind ${tollgateNumberRows} Mautstellen in der Datenbank." . "<br>" . PHP_EOL;

$query_entryNumber = "SELECT * FROM faehrtEin";
$result_entryNumber = mysqli_query($conn,$query_entryNumber);
$entryNumberRows = mysqli_num_rows($result_entryNumber);
echo "Es sind insgesamt ${entryNumberRows} Einfahrten verbucht." . "<br>" . PHP_EOL;

$query_exitNumber = "SELECT * FROM faehrtAus";
$result_exitNumber = mysqli_query($conn,$query_exitNumber);
$exitNumberRows = mysqli_num_rows($result_exitNumber);
echo "Es sind insgesamt ${exitNumberRows} Ausfahrten verbucht." . "<br>" . PHP_EOL;
$onTheRoad = $entryNumberRows - $exitNumberRows;
echo "Derzeit sind also ${onTheRoad} Fahrzeuge auf der Autobahn." . "<br>" . PHP_EOL;

$currentMonth = date("Y-m");
$currentDay = date("Y-m-d");

$query_getDailyExit = "SELECT * FROM faehrtAus WHERE zeitstempel LIKE '$currentDay%'";
$result_getDailyExit = mysqli_query($conn,$query_getDailyExit);
$dailyExitRows = mysqli_num_rows($result_getDailyExit);
echo "Heute sind ${dailyExitRows} Autos über die Autobahn gefahren." . "<br>" . PHP_EOL;

$query_getMonthlyExit = "SELECT * FROM faehrtAus WHERE zeitstempel LIKE '$currentMonth%'";
$result_getMonthlyExit = mysqli_query($conn,$query_getMonthlyExit);
$monthlyExitRows = mysqli_num_rows($result_getMonthlyExit);
echo "Diesen Monat sind ${monthlyExitRows} Autos über die Autobahn gefahren." . "<br>" . PHP_EOL;

echo "<table border='1'>
<tr>
<th>Statistiken</th>
<th>" "</th>
</tr>";
echo "<tr class='userlistoutput'>";
echo "<td width='350px'> Mautstellen in der Datenbank </td>";
echo "<td width='350px'> ${tollgateNumberRows} </td>";
echo "</tr>";
echo "<td width='350px'> Insgesamte Einfahrten </td>";
echo "<td width='350px'> ${entryNumberRows} </td>";
echo "</tr>";
echo "<td width='350px'> Insgesamte Ausfahrten </td>";
echo "<td width='350px'> ${exitNumberRows} </td>";
echo "</tr>";
echo "<td width='350px'> Mautstellen in der Datenbank </td>";
echo "<td width='350px'> ${tollgateNumberRows} </td>";
echo "</tr>";
echo "<td width='350px'> Mautstellen in der Datenbank </td>";
echo "<td width='350px'> ${tollgateNumberRows} </td>";
echo "</tr>";
echo "<td width='350px'> Mautstellen in der Datenbank </td>";
echo "<td width='350px'> ${tollgateNumberRows} </td>";
echo "</tr>";

echo "</table>";
?>