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
					<h1>Berechnen Sie hier die Kosten für Ihre Route durch Deutschland</h1>
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
					<?php include_once'include/include_userAction.php'; ?>
					</div>
					<div id="rowend" class="row">
					</div>
					<div id="resultstring" class="alert alert-info">

					</div>
				</div>
			</div>
		</form>

		
		</div>
		<!-- JAVASCRIPT  -->
	</body>
</html>
