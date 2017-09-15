<?php
 include_once '../include/db.php';																	//include db.php
 
 
 $query_getBill = "SELECT id, kosten, streckeID FROM rechnung ORDER BY id DESC";					//query getBill
 $result_getBill = mysqli_query($conn,$query_getBill);												//execute query and save

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="content-Type" content="text/html; charset=UTF-8" />  
		<link rel="shortcut icon" type="image/x-icon" href="/../images/favicon.ico">
		<link href="/mitarbeiter/stats.css" type="text/css" rel="stylesheet" />
		<link href="/mitarbeiter/textbox.css" type="text/css" rel="stylesheet" />
		<title>Statistiken</title>
	</head>
	<body>
		<!--navbar -->
		<header>
			<div class="container">
				<a href="/index.php">
				<img src="../images/logo.png" alt="logo" class="logo" />
				</a>
				<nav>
					<ul>
						<li><a href="/index.php">Kosten berechnen</a></li>
						<li><a href="/mitarbeiter/index.php">Mitarbeiter Login</a></li>
						<li><a href="/impressum.html">Impressum</a></li>
					</ul>
				</nav>
			</div>
		</header>
		<!--main contents          -->
		<div id="main-area" class="container">
				<div id="placeholder" class="test">
				</div>
				<div id="griddiv-nav-top" class="test">
					<div id="buttondiv_rowstart" class="row">
						<center>
							<a href="index.php" class="linkbutton">Übersicht</a>
							<a href="rechnungen.php" class="linkbutton">Rechnungen</a>
							<a href="autobahn.php" class="linkbutton">Auf der Autobahn</a>
							<a href="stats.php" class="linkbutton">Statistik</a>
						</center>
					</div>
					<div id="buttondiv_line" class="row"></div>
						<p></p>
					<div id="buttondiv_rowend" class="row">
						<center><center>
					</div>
				</div>
			<div id="griddiv-left" class="test">
			   <?php
					include_once '../include/statistics.php';		
			   ?>
			</div>
		</div>
		</div>
	</body>
</html>
