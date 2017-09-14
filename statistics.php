<?php
include_once '/include/db.php';

$query_tollgateNumber = "SELECT * FROM mautstelle";
$result_tollgateNumber = mysqli_query($conn,$query_tollgateNumber);
$tollgateNumberRows = mysqli_num_rows($result_tollgateNumber);
echo "Es sind ${tollgateNumberRows} Mautstellen in der Datenbank";

?>