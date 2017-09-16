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
				<a href="/index.php">
				<img src="images/logo.png" alt="logo" class="logo" />
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
		<form action="/index.php" method="post">
			<div id="main-area" class="container">
				<div id="heading" class="page-header">
					<h1>Berechnen Sie hier die Kosten für Ihre Route durch Deutschland :)</h1>
				</div>
				<div id="griddiv-left" class="test">
					<div id="rowstart" class="row">
						<input id="text-startstation" name="text-startstation" class="enjoy-css" type="text" placeholder="Code von Start-Mautstelle"> 
					</div>
					<div id="rowend" class="row">
						<input id="text-endstation" name="text-endstation" class="enjoy-css" type="text" placeholder="Code von End-Mautstelle"><br>				
					</div>
					<div id="buttonrow" class="row">
						<input class="button" type="submit" name="submit" value="Berechnen">  						
					</div>
				</div>
				<div id="griddiv-right" class="test">
					<div id="rowstart" class="row">
						Geben Sie ihre Informationen auf der Linken Seite ein, um Ihre Kosten zu berechnen.<br>
						Eine Liste aller Mautstationen finden Sie <a target="_blank" href="/mautstellen-info.php">hier</a>.
						<br><br><br>
						<?php
						if ($_SERVER['REQUEST_METHOD'] === 'POST') {										//Check if REQUEST_METHOD == POST
							include_once 'include/calculation.php';											//include calculaction.php
							$code1 = $_POST["text-startstation"];											//write input from text-startstation in code1
							$code2 = $_POST["text-endstation"];												//write input from text-endstation in code2
							
							$code1 = mysqli_real_escape_string ($conn, $code1);								//escape string "code1"
							$code2 = mysqli_real_escape_string ($conn, $code2);								//escape string "code2"

							$query_getTollgateCode = "SELECT code FROM mautstelle WHERE code = $code1";		//SQL query getTollgateCode1
							$result_getTollgateCode = mysqli_query($conn, $query_getTollgateCode);			//execute query getTollgateCode and save
							$rows = mysqli_num_rows($result_getTollgateCode);								//get rows from getTollgateCode
							if ($rows == 0){																//if rows == 0 checktollgateCode = FALSE 
							$checkTollgateCode = "FALSE";
							}
							if($rows >= 1){																	//if rows >=1 checktollgateCode = TRUE
								$checkTollgateCode = "TRUE";
							}
							if($checkTollgateCode == "TRUE"){												//if checkTollgateCode == TRUE
								$query_getTollgateCode = "SELECT code FROM mautstelle WHERE code = $code2";	//SQL query getTollgateCode1
								$result_getTollgateCode = mysqli_query($conn, $query_getTollgateCode);	    //execute query getTollgateCode and save
								$rows = mysqli_num_rows($result_getTollgateCode);                           //get rows from getTollgateCode
								if ($rows == 0){                                                            //if rows == 0 checktollgateCode = FALSE 
								$checkTollgateCode = "FALSE";                                               
								}                                                                           
								if($rows >= 1){                                                             //if rows >=1 checktollgateCode = TRUE
									$checkTollgateCode = "TRUE";
								}
								if($checkTollgateCode == "TRUE"){											//if checktollgateCode still TRUE
									$query_getLatLon1 = "SELECT lat, lon FROM mautstelle WHERE code = $code1";		//sql getLanLon1
									$query_getLatLon2 = "SELECT lat, lon FROM mautstelle WHERE code = $code2";		//sql getLanLon2
									
									$result_getLanLon1 = mysqli_query($conn,$query_getLatLon1);				//execute Query and save result

									while ($data = mysqli_fetch_assoc($result_getLanLon1)){					//fetch array result_getLanLon1
									$db_latitude1 = $data['lat'];											//save lan in db_latitude1
									$db_longitude1 = $data['lon'];											//save lon in db_longitude1
									}
									$result_getLanLon2 = mysqli_query($conn,$query_getLatLon2);				//execute Query and save result

									while ($data = mysqli_fetch_assoc($result_getLanLon2)){					//fetch arry result_getLanLon2
									$db_latitude2 = $data['lat'];											//save lan in db_latitude2
									$db_longitude2 = $data['lon'];											//save lon in db_longitude2
									}	
									$distance = Geo::get_distance("$db_latitude1","$db_longitude1","$db_latitude2","$db_longitude2");		//hand over variables to distance function 
									echo "Die Entfernung beträgt: ".$distance." km";						//echo distance from function 
								}
								
							}
							if($checkTollgateCode == "FALSE"){												//if checktollgateCode == FALSE 
								echo "MautstellenCode ist nicht in der Datenbank";							//echo error message
							}

							if($checkTollgateCode == "TRUE"){												//if checktollgateCode == TRUE
									include 'include/price_calculation.php';								//include price_calculation.php
									
									$price = price::get_price("$distance");									//hand over variable to price function
									echo "Der Preis für diese Entfernung beträgt: ".$price." Euro.";		//echo price from function
							}
						}
						else	
						{
							echo "<br>"; //empty line, we need the same height all the time!
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
