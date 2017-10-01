<?php
include_once 'db.php';

$songname = $_GET["songname"];
$timestamp = $_GET["time"];
$station = $_GET["stationID"];

$currentDay = date("Y-m-d");
$currentHour = date("Y-m-d H");

$query_getSongId = "SELECT id FROM song WHERE name = '$songname'";
$result_getSongId = mysqli_query($conn, query_getSongId);
if (empty($result_getSongId)){
	$query_insertSong = "INSERT INTO song (name) VALUES ('$songname')";
	$db_songId = mysqli_insert_id($conn);
}
else{
	while($data = mysqli_fetch_array($result_getSongId)){
		$db_songId = $data['id'];
	}
}

if (empty($timestamp)){
	$time = date("Y-m-d H:i:s");
}
else{
	$time = date("Y-m-d H:i:s", $timestamp);
}

$query_insertPlays = "INSERT INTO plays (stationId, songId, timestamp) VALUES ('$station', '$db_songId', '$time')";
mysqli_query($conn, $query_insertPlays);

$query_checkPlaysHour = "SELECT songId FROM plays WHERE stationId = '$station' AND timestamp LIKE '%$currentHour%'";
$result_checkPlaysHour = mysqli_query($conn, $query_checkPlaysHour);
$playsHourRows = mysqli_num_rows($result_checkPlaysHour);

$query_checkPlaysDay = "SELECT songId FROM plays WHERE stationId = '$station' AND timestamp LIKE '%$currentDay%'";
$result_checkPlaysDay = mysqli_query($conn, $query_checkPlaysDay);
$playsDayRows = mysqli_num_rows($result_checkPlaysDay);

if($playsHourRows >= 1){
	mysqli_query($conn, "UPDATE station SET replaysPerDay = '$newReplaysPerDay', replaysPerHour = '$newReplaysPerHour' WHERE id = '$station'");
}
elseif($playsDayRows >= 1){
	mysqli_query($conn, "UPDATE station SET replaysPerDay = '$newReplaysPerDay' WHERE id = '$station'");
}

$query_getPlaysDAY = "	SELECT `songId`,
						COUNT(`songId`) AS `value_occurrence` 
						FROM `plays`
						WHERE `stationId`= '$station' AND timestamp LIKE '$currentDay%'
						GROUP BY `songId`
						ORDER BY `value_occurrence` DESC
						LIMIT    1";
$mostPlaysDAY = mysqli_query($conn, $query_getPlaysDAY);
mysqli_query($conn,"UPDATE station SET mostPlayedSong = '$mostPlaysDAY' WHERE id = '$station'");


?>