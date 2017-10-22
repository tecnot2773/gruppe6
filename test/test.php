<?php


	$npc = $_GET['npc'];

	$http_content = file_get_contents("ptr.wowhead.com/npc=" .$npc);
	
	preg_match('name":"4(.+?)(?=")', $http_content, $itemName);
	
	$i = 0
	foreach($itemName as $key => $item){
		echo $item . "<br>";
		i++
	}
	
?>