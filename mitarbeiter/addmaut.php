<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="shortcut icon" type="image/x-icon" href="/../images/favicon.ico">
		<link href="/mitarbeiter/textbox.css" type="text/css" rel="stylesheet" />
		<link href="/css/addmaut.css" type="text/css" rel="stylesheet" />
		<link href="/css/navbar.css" type="text/css" rel="stylesheet" />
		<link href="/css/buttons.css" type="text/css" rel="stylesheet" />
		<link href="/css/body.css" type="text/css" rel="stylesheet" />
		<title>Mautstationen</title>
	</head>
	<body>
		<!--navbar -->
		<header>
			<div class="navbar-container">
				<a href="/index.php">
				<img src="../images/logo.png" alt="logo" class="logo" />
				</a>
			<nav>
					<ul>
						<li><a href="/index.php">Kosten berechnen</a></li>
						<li><a href="/mautstellen-info.php">Mautstellen</a></li>
						<li>
							<div class="dropdown">
								<a>Mitarbeiter Menü</a>
								<div class="dropdown-content">
									<a href="stats.php">Dashboard</a>
									<a href="index.php">Ein/Aus-Fahrt</a>
									<a href="addmaut.php">Mautstellen</a>
									<a href="rechnungen.php">Rechnungen</a>
								</div>
							</div>
						</li>
					</ul>
				</nav>
			</div>
		</header>
		<!--main contents          -->
		<form action="/mitarbeiter/addmaut.php" method="post">
				<div class="placeholder"></div>
				<div class="jumbo-white">
					<div id="first-row" class="row">
						<input id="text-code" name="text-code" class="enjoy-css" type="text" placeholder="Code/Kürzel">
						<input id="text-namehighway" name="text-namehighway" class="enjoy-css" type="text" placeholder="Name Autobahn">
						<input id="text-namejunction" name="text-namejunction" class="enjoy-css" type="text" placeholder="Name Kreuz">
						<input id="text-junctionNumber" name="text-junctionNumber" class="enjoy-css" type="text" placeholder="Kreuz Nummer">
						<input id="text-lat" name="text-lat" class="enjoy-css" type="text" placeholder="LAT">
						<input id="text-lon" name="text-lon" class="enjoy-css" type="text" placeholder="LON">
					</div>
				</div>
				<div id="second-row" class="test">
					<div id="buttondiv_rowstart" class="row">
					<center><input class="button" type="submit" name="execute" value="Ausführen"></center>
					</div>
				</div>
				<div class="row-bottom">
					<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') { include_once '../include/include_newTollgate.php';} ?>
				</div>
		</form>
	</body>
</html>
