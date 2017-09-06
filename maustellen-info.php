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
		
		<div id="griddiv-search" class="container">
			<div id="rowstart" class="row">
			<input id="text-search" name="text-search" class="enjoy-css" type="text" placeholder="Name des Kreuzes"> <br><br>
			</div>
			<div id="rowend" class="row">
			<input class="button" type="submit" name="submit" value="Suchen">  						
			</div>			
			</div>		
		<div id="main-area" class="container">
			<div id="heading" class="page-header">

			</div>
			<div id="griddiv-left" class="test">
			   <?php
				echo "<table border='1'>
				<tr>
				<th>Code</th>
				<th>Autobahn</th>
				<th>Kreuz Name</th>
				<th>Kreuz Nummer</th>
				</tr>";

				while($row = mysqli_fetch_array($result))
				{
						echo "<tr class='userlistoutput'>";
						//echo "<td width='120px'>" . $row['id'] . "</td>";
						echo "<td width='120px'>" . $row['code'] . "</td>";
						echo "<td width='120px'>" . $row['nameAutobahn'] . "</td>";
						echo "<td width='120px'>" . $row['nameKreuz'] . "</td>";
						echo "<td width='120px'>" . $row['kreuzNummer'] . "</td>";
						echo "</tr>";
			   }
			   echo "</table>";
			   ?>
			</div>

		</div>
		</div>
		<!-- JAVASCRIPT  -->
	</body>
</html>