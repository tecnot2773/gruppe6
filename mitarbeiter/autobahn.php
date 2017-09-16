<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<link rel="shortcut icon" type="image/x-icon" href="/../images/favicon.ico">
		<link href="/mitarbeiter/autobahn.css" type="text/css" rel="stylesheet" />
		<link href="/mitarbeiter/textbox.css" type="text/css" rel="stylesheet" />
		<title>Auf der Autobahn</title>
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
		<div id="main-area" class="container">
				<div id="placeholder" class="test">
				</div>
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
					<p></p>
					<div id="buttondiv_rowend" class="row">
					<center><center>
					</div>
				</div>
			<div id="griddiv-left" class="test">
			    <?php include_once '../include/onHighway.php'; ?>
			</div>
		</div>
		</div>
	</body>
</html>
