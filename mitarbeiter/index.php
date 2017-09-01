<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="shortcut icon" type="image/x-icon" href="/../images/favicon.ico">
		<link href="/mitarbeiter/index.css" type="text/css" rel="stylesheet" />
		<link href="/mitarbeiter/textbox.css" type="text/css" rel="stylesheet" />
		<title>Mautstationen</title>
	</head>
	<body>
		<!--navbar -->
		<header>
			<div class="container">
				<img src="../images/logo.png" alt="logo" class="logo">
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
		<form action="/mitarbeiter/index.php" method="post">
			<div id="main-area" class="container">
				<div id="heading" class="page-header">
					<h1></h1>
				</div>
				<div id="griddiv-nav-top" class="test">
					<div id="buttondiv_rowstart" class="row">
						<a href="rechnungen.php" class="linkbutton">Rechnungen anzeigen</a>
					</div>
					<div id="buttondiv_line" class="row"></div>
					<div id="buttondiv_rowend" class="row">
						<center><?php if ($_SERVER['REQUEST_METHOD'] === 'POST') { include_once '../include/mitarbeiter_action.php';} ?><center>
					</div>
				</div>
				<div id="griddiv-left-upper" class="test">
					<div id="rowstart" class="row">
						<input type="radio" name="selection" value="add">Mautstation hinzufügen<br>
					</div>
					<div id="rowend-left-upper" class="row">
						<input id="text-code" name="text-code" class="enjoy-css" type="text" placeholder="Code/Kürzel"><br><br>
						<input id="text-namehighway" name="text-namehighway" class="enjoy-css" type="text" placeholder="Name Autobahn"><br><br>
						<input id="text-namejunction" name="text-namejunction" class="enjoy-css" type="text" placeholder="Name Kreuz"><br><br>
						<input id="text-junctionNumber" name="text-junctionNumber" class="enjoy-css" type="text" placeholder="Kreuz Nummer"><br><br>
						<input id="text-lat" name="text-lat" class="enjoy-css" type="text" placeholder="LAT"><br><br>
						<input id="text-lon" name="text-lon" class="enjoy-css" type="text" placeholder="LON"><br><br>
					</div>
				</div>
				<div id="griddiv-right-upper" class="test">
					<div id="rowstart" class="row">
						<input type="radio" name="selection" value="entry">Einfahrt<br>
					</div>
					
					<div id="rowend" class="row">
					<input id="text-plate-entry" name="text-plate-entry" class="enjoy-css" type="text" placeholder="Kennzeichen"><br><br>
					<input id="text-IDentry" name="text-CodeEntry" class="enjoy-css" type="text" placeholder="Code Einfahrt"><br><br>
					<input id="text-time-entry" name="text-time-entry" class="enjoy-css" type="text" placeholder="Einfahrts Zeit">YYYY-MM-DD HH:MM:SS<br><br>					
					
					</div>
					<div id="resultstring" class="alert alert-info">

					</div>
				</div>
				<div id="griddiv-right-lower" class="test">
					<div id="rowstart" class="row">
						<input type="radio" name="selection" value="exit">Ausfahrt<br>
					</div>
					
					<div id="rowend" class="row">
					<input id="text-plate-exit" name="text-plate-exit" class="enjoy-css" type="text" placeholder="Kennzeichen"><br><br>
					<input id="text-IDexit" name="text-CodeExit" class="enjoy-css" type="text" placeholder="Code Ausfahrt"><br><br>
					<input id="text-time-exit" name="text-time-exit" class="enjoy-css" type="text" placeholder="Ausfahrts Zeit">YYYY-MM-DD HH:MM:SS<br><br>					
					</div>
					<div id="resultstring" class="alert alert-info">

					</div>
				</div>
				<div id="griddiv-left-lower" class="test">
					
					<div id="buttondiv_rowstart" class="row">
						<input class="button" type="submit" name="execute" value="Ausführen"> 
					</div>
				</div>

			</div>
		</form>
	</body>
</html>