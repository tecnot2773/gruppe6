<?php
 include_once '../include/db.php';
 
 $query_get_route = "SELECT id, kennzeichen, faehrtEinID FROM strecke WHERE faehrtAusID IS NULL";
 $result_get_route = mysqli_query($conn,$query_get_route);
 
 //$result = utf8ize($result);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="content-Type" content="text/html; charset=UTF-8" />  
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
						</center>
					</div>
					<div id="buttondiv_line" class="row"></div>
					<p></p>
					<div id="buttondiv_rowend" class="row">
					<center><center>
					<?php if ($_SERVER['REQUEST_METHOD'] === 'POST'){ include_once '../include/mitarbeiter_action.php'; }?>
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

				while($data1 = mysqli_fetch_array($result_get_route)){
					$db_entryID = $data1['faehrtEinID'];
					$query_get_tollgateEntry = "SELECT zeitstempel, mautstelleID FROM faehrtEin WHERE id = $db_entryID";
					$result_get_tollgateEntry = mysqli_query($conn, $query_get_tollgateEntry);
					while($data2 = mysqli_fetch_array($result_get_tollgateEntry)){
						$db_tollgateID = $data2['mautstelleID'];
						$query_get_tollgateName = "SELECT nameAutobahn, nameKreuz FROM mautstelle WHERE ID = $db_tollgateID";
						$result_get_tollgateName = mysqli_query($conn, $query_get_tollgateName);
						while($data3 = mysqli_fetch_array($result_get_tollgateName)){

						echo "<tr class='userlistoutput'>";
						
						echo "<td width='45px'>" . $data1['id'] . "</td>"; 
						echo "<td width='45px'>" . $data1['kennzeichen'] . "</td>";
						echo "<td width='70px'>" . $data3['nameAutobahn'] . "<br>". $data3['nameKreuz'] . "</td>";
						echo "<td width='70px'>" . $data2['zeitstempel'] . "</td>";
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
