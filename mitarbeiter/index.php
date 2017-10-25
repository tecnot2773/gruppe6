<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="shortcut icon" type="image/x-icon" href="/../images/favicon.ico">
		<link href="/mitarbeiter/index.css" type="text/css" rel="stylesheet" />
		<link href="/mitarbeiter/textbox.css" type="text/css" rel="stylesheet" />
		<link href="/css/navbar.css" type="text/css" rel="stylesheet" />
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
		<form action="/mitarbeiter/index.php" method="post">
				<div id="placeholder" class="test">
				</div>
				<div id="griddiv-nav-top" class="test">
					<div id="buttondiv_rowend" class="row">
						<center><?php if ($_SERVER['REQUEST_METHOD'] === 'POST') { include_once '../include/include_entryExit.php';} ?><center>
					</div>
				</div>
				<div id="jumbo-white" class="test">
						<div class="row-radio">
							<label>
								<input type="radio" name="selection" value="entry" checked="checked">
								Einfahrt
							</label>
						</div>
						<div id="first-row" class="row-data">
							<input id="text-plate-entry" name="text-plate-entry" class="enjoy-css" type="text" placeholder="Kennzeichen">
							<input id="text-IDentry" name="text-CodeEntry" class="enjoy-css" type="text" placeholder="Code Einfahrt">
							<input id="text-time-entry" name="text-time-entry" class="enjoy-css" type="text" placeholder="Einfahrts Zeit">DD.MM.YYYY HH:MM:SS
						</div>


						<div class="row-radio">
							<label>
								<input type="radio" name="selection" value="exit">
								Ausfahrt
							</label>
						</div>

						<div class="row-data">
							<select name="text-plate-exit" class="enjoy-css">
								<option value="" disabled selected hidden>Kennzeichen</option>
								<?php
									include_once '../include/include_db.php';																	//create db connection
									$query_getPlate = "SELECT kennzeichen from strecke WHERE faehrtAusID IS NULL";						//sql query to get  kennzeichen
									$result_getPlate = mysqli_query($conn,$query_getPlate);												//execute query and save
									while($data = mysqli_fetch_array($result_getPlate)){												//fetch data from result_getPlate
										echo '<option value="' . $data['kennzeichen'] . '">' . $data['kennzeichen']. '</option>';		//use echo to execute html in php
									}
								?>
							</select>
							<input id="text-IDexit" name="text-CodeExit" class="enjoy-css" type="text" placeholder="Code Ausfahrt">
							<input id="text-time-exit" name="text-time-exit" class="enjoy-css" type="text" placeholder="Ausfahrts Zeit">DD.MM.YYYY HH:MM:SS
							<input class="button" type="submit" name="execute" value="Ausführen">
						</div>

			</div>
		</form>
	</body>
</html>
