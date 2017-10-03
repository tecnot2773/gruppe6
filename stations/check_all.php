 <?php

	$servername = "localhost";														//server name
	$username = "stationssql";														//login name
	$password = "veve113ppe";														//login password

	// Create connection
	$conn = new mysqli($servername, $username, $password);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);							//error log
	}
	$conn->select_db("stations");													//selet Database
	
	$strQuery = "SET character_set_results = 'utf8', 
	  character_set_client = 'utf8', 
	  character_set_connection = 'utf8', 
	  character_set_database = 'utf8', 
	  character_set_server = 'utf8'";
	$conn->query($strQuery);  

	include_once "check_ffn.php";
	include_once "check_bremenvier.php";
	include_once "check_ndr2.php";
	include_once "check_njoy.php";
	include_once "check_bremennext.php";
	include_once "check_1live.php";
	include_once "check_wdr2.php";
	include_once "check_bremeneins.php";
	include_once "check_ndr1.php";
	if($doStats >= 1){
		include_once "updateStatistics.php";
		echo "Stats updated";
	}
?> 