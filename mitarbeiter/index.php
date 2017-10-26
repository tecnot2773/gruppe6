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
<?php 	include_once '../include/include_db.php';		?>													//create db connection
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
<?php if(($_SERVER['REQUEST_METHOD'] == 'GET'){
							echo "<div class="row-radio">";
								echo "<label>";
									echo "<input type="radio" name="selection" value="entry" checked="checked">";
									echo "Einfahrt";
								echo "</label>";
								echo "<label>";
									echo "<input type="radio" name="selection" value="exit">";
									echo "Ausfahrt";
								echo "</label>";
							echo "</div>";
}
if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST["selection"] == "entry"){
							echo "<div class="row-radio">";
								echo "<label>";
									echo "<input type="radio" name="selection" value="entry" checked="checked">";
									echo "Einfahrt";
								echo "</label>";
								echo "<label>";
									echo "<input type="radio" name="selection" value="exit">";
									echo "Ausfahrt";
								echo "</label>";
							echo "</div>";
}
if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST["selection"] == "exit"){
							echo "<div class="row-radio">";
								echo "<label>";
									echo "<input type="radio" name="selection" value="entry" >";
									echo "Einfahrt";
								echo "</label>";
								echo "<label>";
									echo "<input type="radio" name="selection" value="exit" checked="checked">";
									echo "Ausfahrt";
								echo "</label>";
							echo "</div>";
}
							/*<select name="text-Autobahn" class="enjoy-css">
								<option value="" disabled="" selected="" hidden="">Autobahn</option>
								<option value="A1">A1</option>
								<option value="A2">A2</option>
								<option value="A7">A7</option>
							</select>
							<select name="text-Station" class="enjoy-css">
								<option value="" disabled="" selected="" hidden="">Mautstation</option>
								<option value="A1">Hannover abfahrt Laatzen</option>
								<option value="A2">Am Arsch der Welt</option>
								<option value="A7">Noch weiter dahinten</option>
							</select>
							<input id="text-time-entry" name="text-time-entry" class="enjoy-css" type="text" placeholder="DD.MM.YYYY HH:MM:SS">
						</div>

						<div class="row-data">
							<select name="text-plate-exit" class="enjoy-css">
								<option value="" disabled selected hidden>Kennzeichen</option>
								<?php
									$query_getPlate = "SELECT kennzeichen from strecke WHERE faehrtAusID IS NULL";						//sql query to get  kennzeichen
									$result_getPlate = mysqli_query($conn,$query_getPlate);												//execute query and save
									while($data = mysqli_fetch_array($result_getPlate)){												//fetch data from result_getPlate
										echo '<option value="' . $data['kennzeichen'] . '">' . $data['kennzeichen']. '</option>';		//use echo to execute html in php
									}
								?>
							</select>

						</div>
						*/
						<div class="row-data">
								<input class="buttonsmall" type="submit" id="execute" name="execute" value="Weiter">
						</div>
						<div class="row-bottom">
							<?php if ($_SERVER['REQUEST_METHOD'] === 'POST') { include_once '../include/include_entryExit.php';} ?>
						</div>
				</center>
			</div>
		</form>
	</body>
</html>
