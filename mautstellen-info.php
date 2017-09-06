<?php
 include_once 'include/db.php';
 $result = mysqli_query($conn,"SELECT id,code,nameAutobahn,nameKreuz,kreuzNummer FROM mautstelle");
 $result = utf8ize($result);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="content-Type" content="text/html; charset=UTF-8" />  
		<link rel="shortcut icon" type="image/x-icon" href="/images/favicon.ico">
		<link href="/mautstellen-info.css" type="text/css" rel="stylesheet" />
		<link href="/textbox.css" type="text/css" rel="stylesheet" />
		<title>Mautstationen Liste</title>
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
						<li><a href="/mitarbeiter/index.php">Mitarbeiter Login</a></li>
						<li><a href="/impressum.html">Impressum</a></li>
					</ul>
				</nav>
			</div>
		</header>
		<!--main contents          -->
		<form action="/mautstellen-info.php" method="post">
		<div id="main-area" class="container">
			<div id="heading" class="page-header">

			</div>
			 		<div id="griddiv-search" class="container">		
 			<div id="rowstart" class="row">		
 			<input id="text-search" name="text-search" class="enjoy-css" type="text" placeholder="Name des Kreuzes"> <br><br>		
 			</div>		
 			<div id="rowend" class="row">		
 			<input class="button" type="submit" name="submit" value="Suchen">  						      		
 			</div>					
 			</div>	

			<div id="griddiv-left" class="test">
			   <?php
			   if ($_SERVER['REQUEST_METHOD'] === 'GET') {
					echo "<table border='1'>
					<tr>
					<th>Code</th>
					<th>Autobahn</th>
					<th>Kreuz Name</th>
					<th>Kreuz Nummer</th>
					</tr>";

					while($data = mysqli_fetch_array($result))
					{
							echo "<tr class='userlistoutput'>";
							echo "<td width='120px'>" . $data['code'] . "</td>";
							echo "<td width='120px'>" . $data['nameAutobahn'] . "</td>";
							echo "<td width='120px'>" . $data['nameKreuz'] . "</td>";
							echo "<td width='120px'>" . $data['kreuzNummer'] . "</td>";
							echo "</tr>";
				   }
			   }
			   echo "</table>";
			   ?>
			   <?php


				if ($_SERVER['REQUEST_METHOD'] === 'POST') {
					$junctionName = $_POST["text-search"];
						
					$query_getTollgateInfo = "SELECT code, nameAutobahn, nameKreuz, kreuzNummer FROM mautstelle WHERE nameKreuz Like '%$junctionName%'";
					$result_getTollgateInfo = mysqli_query($conn, $query_getTollgateInfo);
					
					while($data = mysqli_fetch_array($result_getTollgateInfo)){
						echo "<tr class='userlistoutput'>";
						echo "<td width='120px'>" . $data['code'] . "</td>";
						echo "<td width='120px'>" . $data['nameAutobahn'] . "</td>";
						echo "<td width='120px'>" . $data['nameKreuz'] . "</td>";
						echo "<td width='120px'>" . $data['kreuzNummer'] . "</td>";
						echo "</tr>";
					}
				}
				echo "</table>";
				?>
			</div>

		</div>
		</form>
		</div>
		<!-- JAVASCRIPT  -->
	</body>
</html>
