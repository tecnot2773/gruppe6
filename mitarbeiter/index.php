<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="shortcut icon" type="image/x-icon" href="/../images/favicon.ico">
		<link href="/css/custom/mitarbeiter_index.css" type="text/css" rel="stylesheet" />
		<link href="/css/generic/textbox.css" type="text/css" rel="stylesheet" />
		<link href="/css/generic/navbar.css" type="text/css" rel="stylesheet" />
		<link href="/css/generic/body.css" type="text/css" rel="stylesheet" />
		<link href="/css/generic/buttons.css" type="text/css" rel="stylesheet" />
<?php 	include_once '../include/include_db.php';		include_once '../include/include_functionEntryExit.php'; ?>
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
		<form action="/mitarbeiter/index.php" method="post">
				<div class="placeholder">
				</div>
				<div class="jumbo-white">
					<center>
<?php
if($_SERVER['REQUEST_METHOD'] == 'GET'){
	EntryExit::noSelect($conn);
}
if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST["selection"] == "entry" && empty($_POST["text-Autobahn"]) && empty($_POST["text-Plate"])){
	EntryExit::entry($conn);
}
if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST["selection"] == "exit" && empty($_POST["text-Autobahn"]) && empty($_POST["text-Plate"])){
	EntryExit::exit($conn);
}
if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST["selection"] == "entry" && !empty($_POST["text-Autobahn"])){
	if(empty($_POST["text-Station"]) || empty($_POST["text-Plate"])){
		EntryExit::entryChoosen($conn);
	}
}
if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST["selection"] == "exit" && !empty($_POST["text-Autobahn"]) && $_POST['execute'] == "Weiter"){
	if(empty($_POST["text-Station"]) || empty($_POST["text-Plate"])){
		EntryExit::exitChoosen($conn)
	}
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['execute'] == "Abschicken" && !empty($_POST["text-Station"]) && !empty($_POST["text-Plate"])){
	EntryExit::action($conn);
}

?>
				</center>
			</div>
		</form>
	</body>
</html>
