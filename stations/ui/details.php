<!DOCTYPE html>
<html>
	<head>
		<title>Title</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		<!-- Bootstrap core CSS -->
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
		<!-- Custom CSS -->
		<link href="css/navbar-top-fixed.css" type="text/css" rel="stylesheet" />
		<link href="css/background.css" type="text/css" rel="stylesheet" />
		<link href="css/sizes.css" type="text/css" rel="stylesheet" />
		<link href="css/testing.css" type="text/css" rel="stylesheet" />
		<link href="css/listbox.css" type="text/css" rel="stylesheet" />
		<link href="css/rows.css" type="text/css" rel="stylesheet" />
	</head>
	<body>
		<div w3-include-html="content.html"></div>
		<nav class="navbar navbar-expand-md navbar-dark bg-dark">
			<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
			</button>
			<a class="navbar-brand" href="#">Radiopunkte.de</a>
			<div class="collapse navbar-collapse" id="navbarsExampleDefault">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item">
						<a class="nav-link" href="/stations/ui/index.html">Start</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="/stations/ui/stats.php">Statistiken<span class="sr-only">(current)</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link disabled" href="#">Nicht klicken</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
						<div class="dropdown-menu" aria-labelledby="dropdown01">
							<a class="dropdown-item" href="#">Action</a>
							<a class="dropdown-item" href="#">Another action</a>
							<a class="dropdown-item" href="#">Something else here</a>
						</div>
					</li>
				</ul>
			</div>
		</nav>
		<div class="container">
			<div class="jumbotron">
					<div class="row" id="heading">
						<p id="station_id" class="heading-text"><?php $stationId = $_GET['stationid'];?></p>
						<p class="heading-text"><?php include_once "../getName.php"; Name::getName($stationId); ?></p>
					<!-- Javascipript variable parsing -->
					</div>
			</div>
			<div class="jumbotron">

					<div class="row" id="top">
						<div class="col-sm-3">
							<div class="list-group">
								<div class="list-group-item visitor">
									<h4 class="list-group-item-heading count">
										500
									</h4>
									<p class="list-group-item-text">
										Wiederholungen<br>pro Tag
									</p>
								</div>
								<div class="list-group-item visitor">
									<h4 class="list-group-item-heading count">
										1000
									</h4>
									<p class="list-group-item-text">
										Wiederholungen<br>pro Woche
									</p>
								</div>
								<div class="list-group-item visitor">
									<h4 class="list-group-item-heading count">
										1000
									</h4>
									<p class="list-group-item-text">
										Wiederholungen<br>pro Monat
									</p>
								</div>
								<div class="list-group-item visitor">
									<h4 class="list-group-item-heading count">
										1000
									</h4>
									<p class="list-group-item-text">
										Wiederholungen<br>pro Tag
									</p>
								</div>
							</div>
						</div>
						<div class="col-sm-8">
							<div class="fillParent" style="position:relative;">
								<canvas id="weeklyChart" width="400" height="400"></canvas>
							</div>
						</div>
					</div>
					<div class="row" id="bottom">
							<div class="fillParent" style="position:relative;">
								<canvas id="monthlyChart" width="400" height="400"></canvas>
							</div>
					</div>
				
			</div>
		</div>
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://code.jquery.com/jquery-3.2.1.js"="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.js"></script>
		<script src="js/testing.js"></script>
		<script src="js/chart.js"></script>
	</body>
</html>

