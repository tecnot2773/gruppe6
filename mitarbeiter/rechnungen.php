<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="content-Type" content="text/html; charset=UTF-8" />
		<link rel="shortcut icon" type="image/x-icon" href="/../images/favicon.ico">
		<link href="/css/custom/mitarbeiter_rechnungen.css" type="text/css" rel="stylesheet" />
		<link href="/css/generic/navbar.css" type="text/css" rel="stylesheet" />
		<link href="/css/generic/body.css" type="text/css" rel="stylesheet" />
		<link href="/../textbox.css" type="text/css" rel="stylesheet" />
		<title>Rechnungen</title>
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
		<div class="placeholder"></div>
		<div class="jumbo-white">
			<form action="/rechnung.php" method="post">
				<div id="main-area" class="container">
					<div id="heading" class="page-header">

					</div>
					<div id="griddiv-search" class="container">
						<div id="rowstart" class="row">
							<input id="text-search-kennzeichen" name="text-search-kennzeichen" class="enjoy-css" type="text" placeholder="Kennzeichen">
							<input class="button" type="submit" name="submit" value="Suchen">
						</div>
		 			</div>

					<div id="griddiv-left" class="test">
						<?php include_once '../include/include_bill.php'; ?>
					</div>
				</div>
			</form>
		</div>
	</body>
</html>
