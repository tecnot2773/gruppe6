<?php


	$npc = $_GET['npc'];

	$http_content = file_get_contents("http://ptr.wowhead.com/npc=" .$npc);
	
	preg_match_all('/"name":"4(.+?)(?=")/', $http_content, $itemName);
	$len=count($itemName);
	echo $len;
	for ($i=0; $i<$len ;$i++){
		echo $itemName[1][$i];
		echo "<br";
	}
	
?>