<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="shortcut icon" type="image/x-icon" href="/../images/favicon.ico">
		<link href="/mitarbeiter/index_new.css" type="text/css" rel="stylesheet" />
		<link href="/mitarbeiter/textbox.css" type="text/css" rel="stylesheet" />
		<title>Mautstationen</title>
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
		<form action="/mitarbeiter/index.php" method="post">
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
					<div id="buttondiv_rowend" class="row">
						<center><?php if ($_SERVER['REQUEST_METHOD'] === 'POST') { include_once '../include/mitarbeiter_action.php';} ?><center>
					</div>
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
					</div>
					<div id="rowend" class="row">
						 
					</div>
					<div id="resultstring" class="alert alert-info">

					</div>
				</div>
				<div id="griddiv-left-lower" class="test">
					
					<div id="buttondiv_rowstart" class="row">
					<center><input class="button" type="submit" name="execute" value="Ausführen"></center> 
					</div>
				</div>

			</div>
		</form>
	</body>
</html>
