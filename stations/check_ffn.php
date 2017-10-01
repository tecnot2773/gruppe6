<?php
	$http_content = file_get_contents("https://www.ffn.de/musik/playlist/");
	preg_match('/<p class="title">(.*)/', $http_content, $matches);
	echo($matches[0]);



 
 
?>