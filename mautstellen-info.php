<?php
 include_once 'include/include_db.php';																				//include db.php
 $query_getTollgate = "SELECT id,code,nameAutobahn,nameKreuz,kreuzNummer FROM mautstelle";					//SQL query getTollgate
 $result_getTollgate = mysqli_query($conn,$query_getTollgate);												//execute query and save
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
						<li><a href="/mautstellen-info.php">Mautstellen</a></li>
						<li><a href="/mitarbeiter/index.php">Mitarbeiter Login</a></li>
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
					<input id="text-search-autobahn" name="text-search-autobahn" class="enjoy-css" type="text" placeholder="Autobahn Nummer">
					<input id="text-search-kreuz" name="text-search-kreuz" class="enjoy-css" type="text" placeholder="Name des Kreuzes">
					<input class="button" type="submit" name="submit" value="Suchen">  					
				</div>						
 			</div>	

			<div id="griddiv-left" class="test">
			<?php include_once 'include/include_tollgateInfo.php'; ?>
			</div>

		</div>
		</form>
		</div>
	</body>
</html>
