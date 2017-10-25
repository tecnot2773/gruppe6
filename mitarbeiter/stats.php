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
				<?php include_once '../include/include_statistics.php'; include_once '../include/include_db.php'; ?>
			<table border='1'>																					
			<tr>
			<th>Statistiken</th>
			<th></th>
			</tr>";
			<tr class='userlistoutput'>";
			<td width='350px'> Mautstellen in der Datenbank </td>
			<td width='350px'> <?php Statistic::tollgateCount($conn); ?> </td>
			</tr>
			<td width='350px'> Insgesamte Einfahrten </td>
			<td width='350px'> <?php Statistic::entryCount($conn); ?> </td>
			</tr>
			<td width='350px'> Insgesamte Ausfahrten </td>
			<td width='350px'> <?php Statistic::exitCount($conn); ?> </td>
			</tr>
			<td width='350px'> Autos auf der Autobahn </td>
			<td width='350px'> <?php Statistic::onTheRoad($conn); ?> </td>
			</tr>
			<td width='350px'> Autos heute auf der Autobahn </td>
			<td width='350px'> <?php Statistic::dailyExit($conn); ?> </td>
			</tr>
			<td width='350px'> Autos diesen Monat auf der Autobahn </td>
			<td width='350px'> <?php Statistic::monthlyExit($conn); ?> </td>
			</tr>
			</table>
			</div>
		</div>
		</div>
	</body>
</html>
