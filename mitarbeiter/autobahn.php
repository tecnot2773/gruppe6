<?php
 include_once '../include/db.php';																		//include db.php
 
 $query_getRoute = "SELECT id, kennzeichen, faehrtEinID FROM strecke WHERE faehrtAusID IS NULL";		//query getRoute
 $result_getRoute = mysqli_query($conn,$query_getRoute);												//execute Query and save
 
?>
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
						<li><a href="/impressum.html">Impressum</a></li>
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
							<a href="index.php" class="linkbutton">Übersicht</a>
							<a href="rechnungen.php" class="linkbutton">Rechnungen</a>
							<a href="autobahn.php" class="linkbutton">Auf der Autobahn</a>
							<a href="stats.php" class="linkbutton">Statistik</a>
						</center>
					</div>
					<div id="buttondiv_line" class="row"></div>
					<p></p>
					<div id="buttondiv_rowend" class="row">
					<center><center>
					<?php if ($_SERVER['REQUEST_METHOD'] === 'POST'){ include_once '../include/mitarbeiter_action.php'; } //if REQUEST_METHOD == POST include mitarbeiter_action.php
					?>	
					</div>
				</div>
			<div id="griddiv-left" class="test">
			   <?php
				echo "<table border='1'>
				<tr>
				<th>ID</th>
				<th>Kennzeichen</th>
				<th>Autobahn Einfahrt</th>
				<th>Einfahrts Zeit</th>
				</tr>";

				while($data1 = mysqli_fetch_array($result_getRoute)){																//fetch result_getRoute
					$db_entryID = $data1['faehrtEinID'];																			//save faehrtEinID in db_entryID
					$query_getTollgateEntry = "SELECT zeitstempel, mautstelleID FROM faehrtEin WHERE id = $db_entryID";				//query getTollgateEntry
					$result_getTollgateEntry = mysqli_query($conn, $query_getTollgateEntry);										//execute query and save
					while($data2 = mysqli_fetch_array($result_getTollgateEntry)){													//fetch result_getTollgateEntry
						$db_tollgateID = $data2['mautstelleID'];																	//save mautstelleID in db_tollgateID
						$query_getTollgateName = "SELECT nameAutobahn, nameKreuz FROM mautstelle WHERE ID = $db_tollgateID";		//query getTollgateName
						$result_getTollgateName = mysqli_query($conn, $query_getTollgateName);										//execute query and save
						while($data3 = mysqli_fetch_array($result_getTollgateName)){												//fetch result_getTollgateName

						echo "<tr class='userlistoutput'>";
						
						echo "<td width='45px'>" . $data1['id'] . "</td>"; 															//echo id
						echo "<td width='45px'>" . $data1['kennzeichen'] . "</td>";													//echo kennzeichen
						echo "<td width='70px'>" . $data3['nameAutobahn'] . "<br>". $data3['nameKreuz'] . "</td>";					//echo nameAutobahn
						echo "<td width='70px'>" . $data2['zeitstempel'] . "</td>";													//echo zeitstempel
						echo "</tr>";
						}
					}
				}
			   echo "</table>";
			   ?>
			</div>
		</div>
		</div>
	</body>
</html>
