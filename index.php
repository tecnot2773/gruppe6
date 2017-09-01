<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="shortcut icon" type="image/x-icon" href="/images/favicon.ico">
		<link href="/index.css" type="text/css" rel="stylesheet" />
		<link href="/textbox.css" type="text/css" rel="stylesheet" />
		<title>Mautstationen</title>
	</head>
	<body>
		<!--navbar -->
		<header>
			<div class="container">
				<img src="images/logo.png" alt="logo" class="logo">
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
		<form action="/index.php" method="post">
			<div id="main-area" class="container">
				<div id="heading" class="page-header">
					<h1>Berechnen Sie hier die Kosten für Ihre Route durch Deutschland :-)</h1>
				</div>
				<div id="griddiv-left" class="test">
					<div id="rowstart" class="row">
						<input id="text-startstation" name="text-startstation" class="enjoy-css" type="text" placeholder="Code von Start-Mautstelle"> 
					</div>
					<div id="rowend" class="row">
						<input id="text-endstation" name="text-endstation" class="enjoy-css" type="text" placeholder="Code von End-Mautstelle">
						<input class="button" type="submit" name="submit" value="Berechnen">  						
					</div>
				</div>
				<div id="griddiv-right" class="test">
					<div id="rowstart" class="row">
						Geben Sie ihre Informationen auf der Linken Seite ein, um Ihre Kosten zu berechnen.<br>
						Eine Liste aller Mautstationen finden Sie <a target="_blank" href="/maustellen-info.php">hier</a>.
						<br><br>
						<?php
						namespace my\error;
						if ($_SERVER['REQUEST_METHOD'] === 'POST') {
							include_once 'include/calculation.php';
							$code1 = $_POST["text-startstation"];
							$code2 = $_POST["text-endstation"];

							$query_getTollgateCode = "SELECT code FROM mautstelle WHERE code = $code1";
							$result_getTollgateCode = mysqli_query($conn, $query_getTollgateCode);
							$rows = mysqli_num_rows($result_getTollgateCode);
							if ($rows == 0){
							$checkTollgateCode = "FALSE";
							}
							if($rows >= 1){
								$checkTollgateCode = "TRUE";
							}
							if($checkTollgateCode == "TRUE"){
								$query_getTollgateCode = "SELECT code FROM mautstelle WHERE code = $code2";
								$result_getTollgateCode = mysqli_query($conn, $query_getTollgateCode);
								$rows = mysqli_num_rows($result_getTollgateCode);
								if ($rows == 0){
								$checkTollgateCode = "FALSE";
								}
								if($rows >= 1){
									$checkTollgateCode = "TRUE";
								}
								if($checkTollgateCode == "TRUE"){
									$sql_Code1 = "SELECT lat, lon FROM mautstelle WHERE code = $code1";
									$sql_Code2 = "SELECT lat, lon FROM mautstelle WHERE code = $code2";
									
									$result1 = mysqli_query($conn,$sql_Code1);

									while ($data = mysqli_fetch_assoc($result1)){
									$db_latitude1 = $data['lat'];
									$db_longitude1 = $data['lon'];
									}
									$result2 = mysqli_query($conn,$sql_Code2);

									while ($data = mysqli_fetch_assoc($result2)){
									$db_latitude2 = $data['lat'];
									$db_longitude2 = $data['lon'];
									}
									$distance = Geo::get_distance("$db_latitude1","$db_longitude1","$db_latitude2","$db_longitude2");
									echo "Die Entfernung beträgt: ".$distance." km";
								}
								
							}
							if($checkTollgateCode == "FALSE"){
								echo "MautstellenCode ist nicht in der Datenbank";
							}
						}
						?>
						<br>
						<?php
						if($checkTollgateCode == "TRUE"){
							if ($_SERVER['REQUEST_METHOD'] === 'POST') {
								include 'include/price_calculation.php';
								
								$price = price::get_price("$distance");
								echo "Der Preis für diese Entfernung beträgt: ".$price." Euro.";
							}
						}
						?>
					</div>
					<div id="rowend" class="row">
						 
					</div>
					<div id="resultstring" class="alert alert-info">

					</div>
				</div>
			</form>

		</div>
		</div>
		<!-- JAVASCRIPT  -->
	</body>
</html>