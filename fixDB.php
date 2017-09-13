<?php
 include_once 'include/db.php';
 $result = mysqli_query($conn,"SELECT id,code,nameAutobahn,nameKreuz,kreuzNummer FROM mautstelle");
 $result = utf8ize($result);
 
 while($data = mysqli_fetch_array($result)){
	$http_content = file_get_contents("https://www.openstreetmap.org/node/".$data['code']);
	
	// Works in PHP 5.2.2 and later.
	preg_match('/ title="highway=motorway".*<bdi>(.*)<\/bdi>\ \(/', $http_content, $matches);

	print_r($matches[1]);
	die();
 }
 
 
?>