 <?php
	if (! function_exists(utf8ize()){
		function utf8ize($d)															//funtion to convert DB select into UTF8 (currently not used)
		{
			if (is_array($d)) {
				foreach ($d as $k => $v) {
					$d[$k] = utf8ize($v);
				}
			} else if (is_string ($d)) {
				return utf8_encode($d);
			}
			return $d;
		}
	}
	
	$servername = "localhost";														//server name
	$username = "mysql";															//login name
	$password = "dbcodepw12";														//login password

	// Create connection
	$conn = new mysqli($servername, $username, $password);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);							//error log
	}
	$conn->select_db("maut");														//selet Database
	
	$strQuery = "SET character_set_results = 'utf8', 
	  character_set_client = 'utf8', 
	  character_set_connection = 'utf8', 
	  character_set_database = 'utf8', 
	  character_set_server = 'utf8'";
	$conn->query($strQuery);  

	
?> 