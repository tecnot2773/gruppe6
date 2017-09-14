<?php
include_once 'include/db.php';

$query_tollgateNumber = "SELECT * FROM mautstelle";
$result_tollgateNumber = mysqli_query($conn,$query_tollgateNumber);
$tollgateNumberRows = mysqli_num_rows($result_tollgateNumber);
echo "Es sind ${tollgateNumberRows} Mautstellen in der Datenbank" . "<br>" . PHP_EOL;

$query_entryNumber = "SELECT * FROM faehrtEin";
$result_entryNumber = mysqli_query($conn,$query_entryNumber);
$entryNumberRows = mysqli_num_rows($result_entryNumber);
echo "Es sind insgesamt ${entryNumberRows} Einfahrten verbucht";

$query_exitNumber = "SELECT * FROM faehrtAus";
$result_exitNumber = mysqli_query($conn,$query_exitNumber);
$exitNumberRows = mysqli_num_rows($result_exitNumber);
echo "Es sind insgesamt ${exitNumberRows} Ausfahrten verbucht";
$onTheRoad = $entryNumberRows - $exitNumberRows;
echo "Derzeit sind also ${onTheRoad} Fahrzeuge auf der Autobahn";
?>