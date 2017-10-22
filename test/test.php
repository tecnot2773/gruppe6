<?php


	$npc = $_GET['npc'];

	$http_content = file_get_contents("ptr.wowhead.com/npc=" .$npc);
	
	preg_match('name":"4(.+?)(?=")', $http_content, $itemName);
	
	$len=count($itemName);
	for ($i=0; $i<$len ;$i++){
		echo $itemName[$i];
	}
	
?>