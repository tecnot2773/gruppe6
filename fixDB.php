<?php
 include_once 'include/db.php';
 $result = mysqli_query($conn,"SELECT id,code,nameAutobahn,nameKreuz,kreuzNummer FROM mautstelle");
 $result = utf8ize($result);
 
 while($data = mysqli_fetch_array($result)){
	echo $data['code'];
	$http_content = file_get_contents("https://www.openstreetmap.org/node/".$data['code']);
	echo $http_content;
	die();
 }
 
 
?>