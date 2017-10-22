<?php


	$npc = $_GET['npc'];

	$http_content = file_get_contents("http://ptr.wowhead.com/npc=" .$npc);
	
	preg_match('/"name":"4(.+?)(?=")/', $http_content, $itemName);
	print_r($itemName);
	$len=count($itemName);
	for ($i=0; $i<$len ;$i++){
		echo $itemName[1][$i];
	}
	
?>