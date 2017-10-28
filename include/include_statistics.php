<?php
class Statistic
	{
		public static function tollgateCount($conn)
		{																								//get some Data
			$query_tollgateNumber = "SELECT * FROM mautstelle";
			$result_tollgateNumber = mysqli_query($conn,$query_tollgateNumber);
			$tollgateNumberRows = mysqli_num_rows($result_tollgateNumber);

			return $tollgateNumberRows;
		}
		public static function entryCount($conn)
		{
			$query_entryNumber = "SELECT * FROM faehrtEin";
			$result_entryNumber = mysqli_query($conn,$query_entryNumber);
			$entryNumberRows = mysqli_num_rows($result_entryNumber);

			return $entryNumberRows;
		}
		public static function exitCount($conn)
		{
			$query_exitNumber = "SELECT * FROM faehrtAus";
			$result_exitNumber = mysqli_query($conn,$query_exitNumber);
			$exitNumberRows = mysqli_num_rows($result_exitNumber);

			return $exitNumberRows;
		}
		public static function onTheRoad($conn)
		{
			$exitNumber = Statistic::exitCount($conn);
			$entryNumber = Statistic::entryCount($conn);

			$onTheRoad = $entryNumber - $exitNumber;

			return $onTheRoad;
		}
		public static function dailyExit($conn)
		{
			$currentDay = date("Y-m-d");																				//get current date in form DD.MM.YYYY

			$query_getDailyExit = "SELECT * FROM faehrtAus WHERE zeitstempel LIKE '$currentDay%'";						//SELECT where zeitstempel is current day
			$result_getDailyExit = mysqli_query($conn,$query_getDailyExit);
			$dailyExitRows = mysqli_num_rows($result_getDailyExit);														//get rows from previous select

			return $dailyExitRows;
		}
		public static function monthlyExit($conn)
		{
			$currentMonth = date("Y-m");																				//get current date in form MM.YYYY
			$query_getMonthlyExit = "SELECT * FROM faehrtAus WHERE zeitstempel LIKE '%$currentMonth%'";					//SELECT where zeitstempel is curren month
			$result_getMonthlyExit = mysqli_query($conn,$query_getMonthlyExit);
			$monthlyExitRows = mysqli_num_rows($result_getMonthlyExit);													//get rows from previous select

			return $monthlyExitRows;
		}
		public static function monthlyCount($conn)
		{
			setlocale(LC_TIME, "de_DE.utf8");				//set local langugage for date and time
			for($i = 0; $i < 12; $i++){
				$month = date("Y-m",strtotime("January this Year +$i Month"));
				$result_monthyCount = mysqli_query($conn, "SELECT * FROM faehrtAus WHERE zeitstempel LIKE '$month%'");
				$monthlyCount = mysqli_num_rows($result_monthyCount);

				$monthName = strftime("%B", strtotime($month));		//make date to month in german
				echo "\t\t\t\t\t<tr> \r\n";
				echo "\t\t\t\t\t\t<td width='350px'> Autos im ${monthName} auf der Autobahn </td> \r\n";
				echo "\t\t\t\t\t\t<td width='350px'> ${monthlyCount} </td> \r\n";
				echo "\t\t\t\t\t</tr> \r\n";
			}
		}
		public static function searchCount($conn)
		{
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				$start = $_POST["startSearch"];
				$end = $_POST["endSearch"];
				if (preg_match("/^(\d{2})([.])(\d{2})([.])(\d{4})$/", $start) && preg_match("/^(\d{2})([.])(\d{2})([.])(\d{4})$/", $end)){
					$start = date("Y-m-d H:i:s", strtotime($start));
					$end = date("Y-m-d H:i:s", strtotime($end));

					$result_searchCount = mysqli_query($conn, "SELECT * FROM faehrtAus WHERE zeitstempel BETWEEN '$start' and '$end'");+
					$searchCount = mysqli_num_rows($result_searchCount);

					return $searchCount;
				}
				else{
					echo "Falsche Zeitangabe";
				}
			}
			else {
				echo "Keine Eingabe";
			}
		}
		public static function mostUsedEinfahrt($conn){
			$get_entryCount = mysqli_query($conn, "SELECT `mautstelleID`, COUNT(`mautstelleID`) AS `value_occurrence` FROM `faehrtEin` GROUP BY `mautstelleID` HAVING `value_occurrence` > 0 ORDER BY `value_occurrence` DESC LIMIT 5");
			while($data = mysqli_fetch_array($get_entryCount)){
				$count = $data["value_occurrence"];
				$tollgateId = $data["mautstelleID"];
				$get_tollgateName = mysqli_query($conn, "SELECT nameAutobahn, nameKreuz FROM mautstelle WHERE id = '$tollgateId'");
				while($data = mysqli_fetch_array($get_tollgateName)){
					$db_nameHighway = $data["nameAutobahn"];
					$db_nameJunction = $data["nameKreuz"];

					echo "\t\t\t\t\t<tr> \r\n";
					echo "\t\t\t\t\t\t<td width='350px'>" . $db_nameHighway . " " . $db_nameJunction . "</td> \r\n";
					echo "\t\t\t\t\t\t<td width='350px'> ${count} </td> \r\n";
					echo "\t\t\t\t\t</tr> \r\n";
				}
			}
		}
		public static function mostUsedAusfahrt($conn){
			$get_entryCount = mysqli_query($conn, "SELECT `mautstelleID`, COUNT(`mautstelleID`) AS `value_occurrence` FROM `faehrtAus` GROUP BY `mautstelleID` HAVING `value_occurrence` > 0 ORDER BY `value_occurrence` DESC LIMIT 5");
			while($data = mysqli_fetch_array($get_entryCount)){
				$count = $data["value_occurrence"];
				$tollgateId = $data["mautstelleID"];
				$get_tollgateName = mysqli_query($conn, "SELECT nameAutobahn, nameKreuz FROM mautstelle WHERE id = '$tollgateId'");
				while($data = mysqli_fetch_array($get_tollgateName)){
					$db_nameHighway = $data["nameAutobahn"];
					$db_nameJunction = $data["nameKreuz"];

					echo "\t\t\t\t\t<tr> \r\n";
					echo "\t\t\t\t\t\t<td width='350px'>" . $db_nameHighway . " " . $db_nameJunction . "</td> \r\n";
					echo "\t\t\t\t\t\t<td width='350px'> ${count} </td> \r\n";
					echo "\t\t\t\t\t</tr> \r\n";
				}
			}
		}
	}
?>
