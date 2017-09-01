<?php
 include_once '../include/db.php';
 
 
 $query_get_bill = "SELECT id, kosten, streckeID FROM rechnung ORDER BY id DESC";
 $result_bill = mysqli_query($conn,$query_get_bill);

 
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
		<link href="/mitarbeiter/rechnungen.css" type="text/css" rel="stylesheet" />
		<link href="/mitarbeiter/textbox.css" type="text/css" rel="stylesheet" />
	</head>
	<body>
		<!--navbar -->
		<header>
			<div class="container">
				<img src="../images/logo.png" alt="logo" class="logo">
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
						</center>
					</div>
					<div id="buttondiv_line" class="row"></div>
					<div id="buttondiv_rowend" class="row">
					<?php
					if ($_SERVER['REQUEST_METHOD'] === 'POST') {
						include_once '../include/mitarbeiter_action.php';
					}
					?>
						<center>...<center>
					</div>
				</div>
			<div id="griddiv-left" class="test">
			   <?php
				echo "<table border='1'>
				<tr>
				<th>ID</th>
				<th>Kennzeichen</th>
				<th>Autobahn Einfahrt</th>
				<th>Autobahn Ausfahrt</th>
				<th>Ausfahrt Zeit</th>
				<th>Kosten in Euro</th>
				</tr>";

				while($data1 = mysqli_fetch_array($result_bill)){
					$db_distanceID = $data1['streckeID'];

					$query_get_distance = "SELECT kilometer, kennzeichen, faehrtEinID, faehrtAusID FROM strecke WHERE id = $db_distanceID";
					$result_get_distance = mysqli_query($conn, $query_get_distance);
					while ($data2 = mysqli_fetch_array($result_get_distance)){
						$db_get_tollgate_entry = $data2['faehrtEinID'];
						$db_get_tollgate_exit = $data2['faehrtAusID'];
						
						$query_get_tollgateid_entry = "SELECT mautstelleID FROM faehrtEin WHERE id = $db_get_tollgate_entry";
						$result_get_tollgateid_entry = mysqli_query($conn, $query_get_tollgateid_entry);
						while ($data3 = mysqli_fetch_array($result_get_tollgateid_entry)){
							$db_get_tollgate_entry2 = $data3['mautstelleID'];
						
							$query_get_tollgateid_exit = "SELECT zeitstempel,mautstelleID FROM faehrtAus WHERE id = $db_get_tollgate_exit";
							$result_get_tollgateid_exit = mysqli_query($conn, $query_get_tollgateid_exit);
							while ($data4 = mysqli_fetch_array($result_get_tollgateid_exit)){
								$db_get_tollgate_exit2 = $data4['mautstelleID'];
														
								$query_get_highwayname_entry = "SELECT nameAutobahn, nameKreuz FROM mautstelle WHERE ID = $db_get_tollgate_entry2";
								$result_get_highwayname_entry = mysqli_query($conn, $query_get_highwayname_entry);
								while ($data5 = mysqli_fetch_array($result_get_highwayname_entry)){
									$query_get_highwayname_exit = "SELECT nameAutobahn, nameKreuz FROM mautstelle WHERE ID = $db_get_tollgate_exit2";
									$result_get_highwayname_exit = mysqli_query($conn, $query_get_highwayname_exit);
									while ($data6= mysqli_fetch_array($result_get_highwayname_exit)){
									
										echo "<tr class='userlistoutput'>";
										echo "<td width='45px'><a target=\"_blank\" href=\"detail/index.php?id=" . $data1['id'] . "\">" . $data1['id'] . "</a></td>";
										
										echo "<td width='45px'>" . $data2['kennzeichen'] . "</td>";
										echo "<td width='70px'>" . $data5['nameAutobahn'] . "<br>". $data5['nameKreuz'] . "</td>";
										echo "<td width='70px'>" . $data6['nameAutobahn'] . "<br>". $data6['nameKreuz'] . "</td>";
										echo "<td width='70px'>" . $data4['zeitstempel'] . "</td>";
										echo "<td width='70px'>" . $data1['kosten'] . "</td>";
										echo "</tr>";
									}
								}
							}
						}
					}
			   }
			   echo "</table>";
			   ?>
			</div>
		</div>
		</div>
		<!-- JAVASCRIPT  -->
	</body>
</html>