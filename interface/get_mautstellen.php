 <?php
	function utf8ize($d)
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
	
	header('Content-type: application/json');
	$servername = "localhost";
	$username = "mysql";
	$password = "dbcodepw12";

	// Create connection
	$conn = new mysqli($servername, $username, $password);
	
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$conn->select_db("maut");
	
	
	$myArray = array();
	$sql = "SELECT id,name,street,zip,city FROM tollgates";
	$result = $conn->query($sql) or trigger_error($conn->error."[$sql]");
	if (mysqli_num_rows($result)==0) { 
		echo("No results");
	}
	//while($row = $result->fetch_array(MYSQLI_ASSOC)) { 
	while($row=mysqli_fetch_assoc($result))
	{
		$myArray[] = $row;
	}
	
	
	
	echo json_encode(utf8ize($myArray));

	$conn->close(); 
?> 