<?php
include_once 'db.php';

$songname = $_GET["songname"];
$timestamp = $_GET["time"];
$station = $_GET["stationID"];


$query_getSongId = "SELECT id FROM song WHERE name = '$songname'";
$result_getSongId = mysqli_query($conn, query_getSongId);
if (empty($result_getSongId)){
	$query_insertSong = "INSERT INTO song (name) VALUES ('$songname')";
	$query_getSongId = "SELECT id FROM song WHERE name = '$songname'";
	$result_getSongId = mysqli_query($conn, query_getSongId);
	
	while ($data = mysqli_fetch_array($result_getSongId)){
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


?>