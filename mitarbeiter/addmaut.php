<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="shortcut icon" type="image/x-icon" href="/../images/favicon.ico">
		<link href="/mitarbeiter/addmaut.css" type="text/css" rel="stylesheet" />
		<link href="/mitarbeiter/textbox.css" type="text/css" rel="stylesheet" />
		<title>Mautstationen</title>
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
						<li><a href="/mautstellen-info.php">Mautstellen</a></li>
						<li><a href="/mitarbeiter/index.php">Mitarbeiter Login</a></li>
					</ul>
				</nav>
			</div>
		</header>
		<!--main contents          -->
		<form action="/mitarbeiter/addmaut.php" method="post">
			<div id="main-area" class="container">
				<div id="placeholder" class="test"></div>
				<div id="griddiv-nav-top" class="test">
					<div id="buttondiv_rowstart" class="row">
						<center>
							<a href="index.php" class="linkbutton">Ein/Aus-fahrt</a>
							<a href="addmaut.php" class="linkbutton">Mautstelle hinzufügen</a>
							<a href="rechnungen.php" class="linkbutton">Rechnungen</a>
							<a href="autobahn.php" class="linkbutton">Auf der Autobahn</a>
							<a href="stats.php" class="linkbutton">Statistik</a>
						</center>
					</div>
					<div id="buttondiv_line" class="row"></div>
					<div id="buttondiv_rowend" class="row">
						<center><?php if ($_SERVER['REQUEST_METHOD'] === 'POST') { include_once '../include/include_newTollgate.php';} ?><center>
					</div>
				</div>
				<div id="griddiv-main" class="test">
					<div id="rowstart" class="row">
						<input id="text-code" name="text-code" class="enjoy-css" type="text" placeholder="Code/Kürzel">
						<input id="text-namehighway" name="text-namehighway" class="enjoy-css" type="text" placeholder="Name Autobahn">
						<input id="text-namejunction" name="text-namejunction" class="enjoy-css" type="text" placeholder="Name Kreuz">
						<input id="text-junctionNumber" name="text-junctionNumber" class="enjoy-css" type="text" placeholder="Kreuz Nummer">
						<input id="text-lat" name="text-lat" class="enjoy-css" type="text" placeholder="LAT">
						<input id="text-lon" name="text-lon" class="enjoy-css" type="text" placeholder="LON">
					</div>
				</div>
				<div id="griddiv-submit" class="test">
					<div id="buttondiv_rowstart" class="row">
					<center><input class="button" type="submit" name="execute" value="Ausführen"></center> 
					</div>
				</div>
			</div>
		</form>
	</body>
</html>
