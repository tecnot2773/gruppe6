<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="content-Type" content="text/html; charset=UTF-8" />
		<link rel="shortcut icon" type="image/x-icon" href="/../images/favicon.ico">
		<link href="/css/custom/mitarbeiter_stats.css" type="text/css" rel="stylesheet" />
		<link href="/css/generic/textbox.css" type="text/css" rel="stylesheet" />
		<link href="/css/generic/body.css" type="text/css" rel="stylesheet" />
		<link href="/css/generic/navbar.css" type="text/css" rel="stylesheet" />
		<title>Statistiken</title>
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
				<?php include_once '../include/include_statistics.php'; include_once '../include/include_db.php'; ?>
				<table border='1'>
					<tr>
						<th>Übersicht</th>
						<th></th>
					</tr>
					<tr class='userlistoutput'>
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
				<div class="placeholder"><div>
				<table border='1'>
					<tr>
						<th>Statistiken nach Monaten</th>
						<th></th>
					</tr>
					</tr>
						<?php Statistic::monthlyCount($conn); ?>
					</tr>
				</table>
				<div class="placeholder"><div>
				<table border='1'>
					<tr>
						<th>Statistiken nach Zeitraum</th>
						<th></th>
					</tr>
					</tr>
						<td width='350px'> Autos im Zeitraum auf der Autobahn </td>
						<td width='350px'> <?php Statistic::searchCount($conn); ?> </td>
					</tr>
				</table>
				<form action="/mitarbeiter/stats.php" method="post">
					</div>
					<div id="rowstart" class="row">
						<input id="startSearch" name="startSearch" class="enjoy-css" type="text" placeholder="Start Datum">
					</div>
					<div id="rowend" class="row">
						<input id="endSearch" name="endSearch" class="enjoy-css" type="text" placeholder="End Datum"><br>
					</div>
					<div id="buttonrow" class="row">
						<input class="button" type="submit" name="submit" value="Ausführen">
					</div>
				</form>
				<?php Statistic::searchCount($conn); ?>
			</div>
	</body>
</html>
