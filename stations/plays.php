<?php
include_once 'db.php';

$songname = $_GET["songname"];
$timestamp = $_GET["time"];
$stationname = $_GET["station"];
echo $timestamp;

$currentMonth = date("Y-m");
$currentDay = date("Y-m-d");
$currentHour = date("Y-m-d H");
$currentSeconds = date("Y-m-d H:i:s");

$getstation = mysqli_query($conn, "SELECT id FROM station WHERE name = '$stationname'");
while($data = mysqli_fetch_array($getstation)){
	$station = $data['id'];
}

$query_getSongId = "SELECT id FROM song WHERE name = '$songname'";
$result_getSongId = mysqli_query($conn, $query_getSongId);
$rows_getSongid = mysqli_num_rows($result_getSongId);
if ($rows_getSongid == 0){
	$query_insertSong = "INSERT INTO song (name) VALUES ('$songname')";
	mysqli_query($conn, $query_insertSong);
	$db_songId = mysqli_query($conn, $query_getSongId);
}
else{
	while($data = mysqli_fetch_array($result_getSongId)){
		$db_songId = $data['id'];
	}
}
if (empty($timestamp)){
	$timestamp = date("Y-m-d H:i:s");
}

//echo $station;
echo $db_songId;
echo $timestamp;
$query_insertPlays = "INSERT INTO plays (stationId, songId, timestamp) VALUES ('$station', '$db_songId', '$timestamp')";
echo $query_insertPlays;
mysqli_query($conn, $query_insertPlays);

$query_checkPlaysHour = "SELECT songId FROM plays WHERE stationId = '$station' AND timestamp LIKE '%$currentHour%'";
$result_checkPlaysHour = mysqli_query($conn, $query_checkPlaysHour);
$playsHourRows = mysqli_num_rows($result_checkPlaysHour);

$query_checkPlaysDay = "SELECT songId FROM plays WHERE stationId = '$station' AND timestamp LIKE '%$currentDay%'";
$result_checkPlaysDay = mysqli_query($conn, $query_checkPlaysDay);
$playsDayRows = mysqli_num_rows($result_checkPlaysDay);

$dailystatsExists = mysqli_query($conn, "SELECT * FROM dailyStats WHERE stationId = '$station' and timestamp LIKE '$currentDay%'");
$dailystatsRows = mysqli_num_rows($dailystatsExists);
if($dailystatsRows == 0){
	mysqli_query($conn, "INSERT INTO dailyStats (stationId, timestamp) VALUES ('$station', '$currentSeconds'");
}

if($playsHourRows >= 1){
	mysqli_query($conn, "UPDATE dailyStats SET replaysPerDay = '$newReplaysPerDay', replaysPerHour = '$newReplaysPerHour' WHERE stationId = '$station'");
}
elseif($playsDayRows >= 1){
	mysqli_query($conn, "UPDATE dailyStats SET replaysPerDay = '$newReplaysPerDay' WHERE stationId = '$station'");
}

$query_getPlaysDAY = "	SELECT `songId`,
						COUNT(`songId`) AS `value_occurrence` 
						FROM `plays`
						WHERE `stationId`= '$station' AND timestamp LIKE '$currentDay%'
						GROUP BY `songId`
						ORDER BY `value_occurrence` DESC
						LIMIT    1";
$mostPlaysDAY = mysqli_query($conn, $query_getPlaysDAY);
mysqli_query($conn,"UPDATE dailyStats SET mostPlayedSong = '$mostPlaysDAY' WHERE stationId = '$station'");

$runs = "24";

WHILE($runs > 0){
	$runs = $runs - 1;
	if($runs >= 10){
	$day = $currentMonth . "-" . $runs;
	}
	else{
		$day = $currentMonth . "-0" . $runs;
	}
	$query_mostPlaysDuring = "	SELECT COUNT(`songId`)
								FROM `plays`
								WHERE `stationId` = '$station' AND timestamp LIKE '$day%'";
	$mostPlaysDuring = mysqli_query($conn, $query_mostPlaysDuring);
	if($mostPlaysDuring > $save_mostPlaysDuring){
		$save_mostPlaysDuring = $mostPlaysDuring;
		$saveTime = $runs;
	}

}
$asd = "$saveTime und ++$saveTime Uhr";
mysqli_query($conn, "UPDATE dailyStats SET mostPlaysDuring = '$asd' WHERE stationId = '$station'");
?>