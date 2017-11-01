<?php 				//USED IN gruppe6/mitarbeiter/stats.php
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
			$exitNumber = Statistic::exitCount($conn);					//call function
			$entryNumber = Statistic::entryCount($conn);				//call function

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
				if (preg_match("/^(\d{2})([.])(\d{2})([.])(\d{4})$/", $start) && preg_match("/^(\d{2})([.])(\d{2})([.])(\d{4})$/", $end)){		//end and start need to match german timestamp
					$start = date("Y-m-d H:i:s", strtotime($start));				//make german timestamp to US timestamp
					$end = date("Y-m-d H:i:s", strtotime($end));

					$result_searchCount = mysqli_query($conn, "SELECT * FROM faehrtAus WHERE zeitstempel BETWEEN '$start' and '$end'");
					$searchCount = mysqli_num_rows($result_searchCount);		//count rows of result

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
			$get_entryCount = mysqli_query($conn, "SELECT fE.mautstelleID, COUNT(fE.mautstelleID) AS `value_occurrence`, m.nameAutobahn, m.nameKreuz FROM faehrtEin fE JOIN mautstelle m ON fE.mautstelleID = m.ID GROUP BY fE.mautstelleID HAVING value_occurrence > 0 ORDER BY value_occurrence DESC, m.nameAutobahn ASC LIMIT 5");		// SELECT most used Einfahrt
			while($data = mysqli_fetch_array($get_entryCount)){
				$count = $data["value_occurrence"];
				$tollgateId = $data["mautstelleID"];
				$db_nameHighway = $data["nameAutobahn"];
				$db_nameJunction = $data["nameKreuz"];

				echo "\t\t\t\t\t<tr> \r\n";
				echo "\t\t\t\t\t\t<td width='350px'>" . $db_nameHighway . " " . $db_nameJunction . "</td> \r\n";
				echo "\t\t\t\t\t\t<td width='350px'> ${count} </td> \r\n";
				echo "\t\t\t\t\t</tr> \r\n";
			}
		}
		public static function mostUsedAusfahrt($conn){
			$get_entryCount = mysqli_query($conn, "SELECT fA.mautstelleID, COUNT(fA.mautstelleID) AS `value_occurrence`, m.nameAutobahn, m.nameKreuz FROM faehrtAus fA JOIN mautstelle m ON fA.mautstelleID = m.ID GROUP BY fA.mautstelleID HAVING value_occurrence > 0 ORDER BY value_occurrence DESC, m.nameAutobahn ASC LIMIT 5");			// SELECT most used Aufahrt
			while($data = mysqli_fetch_array($get_entryCount)){
				$count = $data["value_occurrence"];
				$tollgateId = $data["mautstelleID"];
				$db_nameHighway = $data["nameAutobahn"];
				$db_nameJunction = $data["nameKreuz"];

				echo "\t\t\t\t\t<tr> \r\n";
				echo "\t\t\t\t\t\t<td width='350px'>" . $db_nameHighway . " " . $db_nameJunction . "</td> \r\n";
				echo "\t\t\t\t\t\t<td width='350px'> ${count} </td> \r\n";
				echo "\t\t\t\t\t</tr> \r\n";
			}
		}
	}
?>
