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
		<form action="/mitarbeiter/index.php" method="post">
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
					<div id="buttondiv_rowend" class="row">
						<center><?php if ($_SERVER['REQUEST_METHOD'] === 'POST') { include_once '../include/include_entryExit.php';} ?><center>
					</div>
				</div>
				<div id="griddiv-left" class="test">
					<div id="rowstart" class="row">
						<input type="radio" name="selection" value="entry" checked="checked">Einfahrt<br>
					</div>
					
					<div id="rowend" class="row">
					<input id="text-plate-entry" name="text-plate-entry" class="enjoy-css" type="text" placeholder="Kennzeichen"><br><br>
					

					<div id="rowend" class="row">
						<select name="highway-number" class="enjoy-css">
							<option value="" disabled selected hidden> Autobahnnummer</option>
							<?php include_once '../include/include_db.php'; include_once '../include/include_tollgate.php'; Tollgate::getHighway(); ?>
							</select> <br> <br>
							</div>
					<div id="rowend" class="row">
						<select name="entry-point" class="enjoy-css">
							<option value="" disabled selected hidden> Kreuzname </option></select> <br><br>
						</div>
						
					<input id="text-time-entry" name="text-time-entry" class="enjoy-css" type="text" placeholder="Einfahrts Zeit">DD.MM.YYYY HH:MM:SS<br><br>					
					
					</div>
				</div>
				<div id="griddiv-right" class="test">
					<div id="rowstart" class="row">
						<input type="radio" name="selection" value="exit">Ausfahrt<br>
					</div>
					
					<div id="rowend" class="row">
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
						</select> <br><br>
						<input id="text-IDexit" name="text-CodeExit" class="enjoy-css" type="text" placeholder="Code Ausfahrt"><br><br>
						<input id="text-time-exit" name="text-time-exit" class="enjoy-css" type="text" placeholder="Ausfahrts Zeit">DD.MM.YYYY HH:MM:SS				
					</div>
					
					<div id="resultstring" class="alert alert-info">

					</div>
				</div>
				<div id="griddiv-left-lower" class="test">
					
					<div id="buttondiv_rowstart" class="row">
					<center><input class="button" type="submit" name="execute" value="Ausführen"></center> 
					</div>
				</div>

			</div>
		</form>
	</body>
</html>
