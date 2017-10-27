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
		<link href="/css/generic/buttons.css" type="text/css" rel="stylesheet" />
<?php include_once '../include/include_statistics.php'; include_once '../include/include_db.php'; ?>
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
				<table border='1'>
					<tr>
						<th>Übersicht</th>
						<th></th>
					</tr>
					<tr class='userlistoutput'>
						<td width='350px'> Mautstellen in der Datenbank </td>
						<td width='350px'> <?php echo Statistic::tollgateCount($conn); ?> </td>
					</tr>
					<tr>
						<td width='350px'> Insgesamte Einfahrten </td>
						<td width='350px'> <?php echo Statistic::entryCount($conn); ?> </td>
					</tr>
					<tr>
						<td width='350px'> Insgesamte Ausfahrten </td>
						<td width='350px'> <?php echo Statistic::exitCount($conn); ?> </td>
					</tr>
					<tr>
						<td width='350px'> Autos auf der Autobahn </td>
						<td width='350px'> <?php echo Statistic::onTheRoad($conn); ?> </td>
					</tr>
					<tr>
						<td width='350px'> Autos heute auf der Autobahn </td>
						<td width='350px'> <?php echo Statistic::dailyExit($conn); ?> </td>
					</tr>
					<tr>
						<td width='350px'> Autos diesen Monat auf der Autobahn </td>
						<td width='350px'> <?php echo Statistic::monthlyExit($conn); ?> </td>
					</tr>
				</table>
				<div class="placeholder"></div>
				<table border='1'>
					<tr>
						<th>Meist genutze Einfahrten</th>
						<th></th>
					</tr>
<?php Statistic::mostUsedEinfahrt($conn); ?>
				</table>
				<div class="placeholder"></div>
				<table border='1'>
					<tr>
						<th>Meist genutze Ausfahrten</th>
						<th></th>
					</tr>
<?php Statistic::mostUsedAusfahrt($conn); ?>
				</table>
				<div class="placeholder"></div>
				<table border='1'>
					<tr>
						<th>Statistiken nach Monaten</th>
						<th></th>
					</tr>
<?php Statistic::monthlyCount($conn); ?>
				</table>
				<div class="placeholder"></div>
				<form action="/mitarbeiter/stats.php" method="post">
						<div id="rowstart" class="row">
							<center>
								<input id="startSearch" name="startSearch" class="enjoy-css" type="text" placeholder="Start Datum">
								<input id="endSearch" name="endSearch" class="enjoy-css" type="text" placeholder="End Datum">
								<input class="buttonsmall" type="submit" name="submit" value="Ausführen">
							</center>
						</div>
				</form>
				<div class="placeholder"></div>
				<table border='1'>
					<tr>
						<th>Statistiken nach Zeitraum</th>
						<th></th>
					</tr>
					<tr>
					<?php
						if($_SERVER['REQUEST_METHOD'] == 'POST'){
							$start = $_POST["startSearch"];
							$end = $_POST["endSearch"];
							echo "\t<td width='350px'> Autos im Zeitraum vom ${start} bis ${end} auf der Autobahn </td> \r\n";
						}else{
							echo "\t<td width='350px'> Autos im Zeitraum auf der Autobahn </td>\r\n";
						}
					?>
						<td width='350px'> <?php echo Statistic::searchCount($conn); ?> </td>
					</tr>
				</table>
			</div>
	</body>
</html>
