<?php
 include_once 'include/db.php';
 $result = mysqli_query($conn,"SELECT id,code,nameAutobahn,nameKreuz,kreuzNummer FROM mautstelle");
 $result = utf8ize($result);
 
 while($data = mysqli_fetch_array($result)){
	$http_content = file_get_contents("https://www.openstreetmap.org/node/".$data['code']);
	preg_match('/ title="highway=motorway".*<bdi>(.*)<\/bdi>\ \(/', $http_content, $matches);
	$autobahn = str_replace(' ', '', $matches[1]);

	mysqli_query($conn,"UPDATE `mautstelle` SET `nameAutobahn` = 'A2".$autobahn."' WHERE `mautstelle`.`code` = ".$data['code']);


	
	die();
 }
 
 
?>