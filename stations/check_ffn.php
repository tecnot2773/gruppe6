<?php
	$http_content = file_get_contents("https://www.ffn.de/musik/playlist/");
	preg_match('/<p class="title">(.*)/', $http_content, $songs);
	preg_match('/<h6 class="artist">(.*)/', $http_content, $artists);
	echo($songs[0]);
	echo "<br>";
	echo($artists[0]);

 
?>