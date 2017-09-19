<?php
include_once 'include_db.php';																				//create DB connection
																											//get some Data
$query_tollgateNumber = "SELECT * FROM mautstelle";
$result_tollgateNumber = mysqli_query($conn,$query_tollgateNumber);
$tollgateNumberRows = mysqli_num_rows($result_tollgateNumber);

$query_entryNumber = "SELECT * FROM faehrtEin";
$result_entryNumber = mysqli_query($conn,$query_entryNumber);
$entryNumberRows = mysqli_num_rows($result_entryNumber);

$query_exitNumber = "SELECT * FROM faehrtAus";
$result_exitNumber = mysqli_query($conn,$query_exitNumber);
$exitNumberRows = mysqli_num_rows($result_exitNumber);
$onTheRoad = $entryNumberRows - $exitNumberRows;

$currentDay = date("d.m.Y");																				//get current date in form DD.MM.YYYY
$currentMonth = date("m.Y");																				//get current date in form MM.YYYY

$query_getDailyExit = "SELECT * FROM faehrtAus WHERE zeitstempel LIKE '$currentDay%'";						//SELECT where zeitstempel is current day
$result_getDailyExit = mysqli_query($conn,$query_getDailyExit);
$dailyExitRows = mysqli_num_rows($result_getDailyExit);														//get rows from previous select

$query_getMonthlyExit = "SELECT * FROM faehrtAus WHERE zeitstempel LIKE '%$currentMonth%'";					//SELECT where zeitstempel is curren month
$result_getMonthlyExit = mysqli_query($conn,$query_getMonthlyExit);
$monthlyExitRows = mysqli_num_rows($result_getMonthlyExit);													//get rows from previous select
																											//html chart with output
echo "<table border='1'>																					
<tr>
<th>Statistiken</th>
<th></th>
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
echo "<td width='350px'> Autos auf der Autobahn </td>";
echo "<td width='350px'> ${onTheRoad} </td>";
echo "</tr>";
echo "<td width='350px'> Autos heute auf der Autobahn </td>";
echo "<td width='350px'> ${dailyExitRows} </td>";
echo "</tr>";
echo "<td width='350px'> Autos diesen Monat auf der Autobahn </td>";
echo "<td width='350px'> ${monthlyExitRows} </td>";
echo "</tr>";

echo "</table>";
?>