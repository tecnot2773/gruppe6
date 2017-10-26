<?php
class Statistic
	{
		public static function tollgateCount($conn)
		{																								//get some Data
			$query_tollgateNumber = "SELECT * FROM mautstelle";
			$result_tollgateNumber = mysqli_query($conn,$query_tollgateNumber);
			$tollgateNumberRows = mysqli_num_rows($result_tollgateNumber);

			echo $tollgateNumberRows;
		}
		public static function entryCount($conn)
		{
			$query_entryNumber = "SELECT * FROM faehrtEin";
			$result_entryNumber = mysqli_query($conn,$query_entryNumber);
			$entryNumberRows = mysqli_num_rows($result_entryNumber);

			echo $entryNumberRows;
		}
		public static function exitCount($conn)
		{
			$query_exitNumber = "SELECT * FROM faehrtAus";
			$result_exitNumber = mysqli_query($conn,$query_exitNumber);
			$exitNumberRows = mysqli_num_rows($result_exitNumber);

			echo $exitNumberRows;
		}
		public static function onTheRoad($conn)
		{
			$query_entryNumber = "SELECT * FROM faehrtEin";
			$result_entryNumber = mysqli_query($conn,$query_entryNumber);
			$entryNumberRows = mysqli_num_rows($result_entryNumber);


			$query_exitNumber = "SELECT * FROM faehrtAus";
			$result_exitNumber = mysqli_query($conn,$query_exitNumber);
			$exitNumberRows = mysqli_num_rows($result_exitNumber);
			$onTheRoad = $entryNumberRows - $exitNumberRows;

			echo $onTheRoad;
		}
		public static function dailyExit($conn)
		{
			$currentDay = date("Y-m-d");																				//get current date in form DD.MM.YYYY

			$query_getDailyExit = "SELECT * FROM faehrtAus WHERE zeitstempel LIKE '$currentDay%'";						//SELECT where zeitstempel is current day
			$result_getDailyExit = mysqli_query($conn,$query_getDailyExit);
			$dailyExitRows = mysqli_num_rows($result_getDailyExit);														//get rows from previous select

			echo $dailyExitRows;
		}
		public static function monthlyExit($conn)
		{
			$currentMonth = date("Y-m");																				//get current date in form MM.YYYY
			$query_getMonthlyExit = "SELECT * FROM faehrtAus WHERE zeitstempel LIKE '%$currentMonth%'";					//SELECT where zeitstempel is curren month
			$result_getMonthlyExit = mysqli_query($conn,$query_getMonthlyExit);
			$monthlyExitRows = mysqli_num_rows($result_getMonthlyExit);													//get rows from previous select

			echo $monthlyExitRows;
		}
		public static function monthlyCount($conn)
		{
			setlocale(LC_TIME, "de_DE");
			for($i = 1; $i < 13; $i++){
				$month = date("Y");
				$month = $month . "-" . $i;
				$result_monthyCount = mysqli_query($conn, "SELECT * FROM faehrtAus WHERE zeitstempel LIKE '$month%'");
				$monthlyCount = mysqli_num_rows($result_monthyCount);

				$monthName = strftime("%B", strtotime($month));


				echo "<td width='350px'> Autos im ${monthName} auf der Autobahn </td>";
				echo "<td width='350px'> ${monthlyCount} </td>";
				echo "</tr>";
			}
		}
		public static function searchCount($conn)
		{
			$start = $_POST["startSearch"];
			$end = $_POST["endSearch"];

			$start = date("Y-m-d H:i:s", strtotime($start));
			$end = date("Y-m-d H:i:s", strtotime($end));

			$result_searchCount = mysqli_query($conn, "SELECT * FROM faehrtAus WHERE zeitstempel BETWEEN '$start' and '$end'");
			$searchCount = mysqli_num_rows($result_searchCount);

			echo $searchCount;
		}
	}
?>
