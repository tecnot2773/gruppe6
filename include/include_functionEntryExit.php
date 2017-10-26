<?php
class EntryExit{
	public static function noSelect($conn)
	{
		echo "<div class=row-radio>";
			echo "<label>";
				echo "<input type='radio' name='selection' value='entry' checked='checked'>";
				echo "Einfahrt";
			echo "</label>";
			echo "<label>";
				echo "<input type='radio' name='selection' value='exit'>";
				echo "Ausfahrt";
			echo "</label>";
		echo "</div>";
	}
	public static function entry($conn)
	{
		echo "<div class='row-radio'>";
			echo "<label>";
				echo "<input type='radio' name='selection' value='entry' checked='checked'>";
				echo "Einfahrt";
			echo "</label>";
			echo "<label>";
				echo "<input type='radio' name='selection' value='exit'>";
				echo "Ausfahrt";
			echo "</label>";
		echo "</div>";
		echo "<select name='text-Autobahn' class='enjoy-css'>";
			echo "<option value='' disabled='' selected='' hidden=''>Autobahn</option>";
			$result_Highway = mysqli_query($conn,"SELECT DISTINCT nameAutobahn from mautstelle ORDER BY SUBSTR(nameAutobahn FROM 1 FOR 1), CAST(SUBSTR(nameAutobahn FROM 2) AS UNSIGNED)");												//execute query and save
			while($data = mysqli_fetch_array($result_Highway)){												//fetch data from result_getPlate
			echo '<option value="' . $data['nameAutobahn'] . '">' . $data['nameAutobahn']. '</option>';		//use echo to execute html in php
			}
		echo "</select>";
	}
	public static function exit($conn)
	{
		echo "<div class='row-radio'>";
			echo "<label>";
				echo "<input type='radio' name='selection' value='entry' >";
				echo "Einfahrt";
			echo "</label>";
			echo "<label>";
				echo "<input type='radio' name='selection' value='exit' checked='checked'>";
				echo "Ausfahrt";
			echo "</label>";
		echo "</div>";
		echo "<select name='text-Autobahn' class='enjoy-css'>";
			echo "<option value='' disabled='' selected='' hidden=''>Autobahn</option>";
			$result_Highway = mysqli_query($conn,"SELECT DISTINCT nameAutobahn from mautstelle ORDER BY SUBSTR(nameAutobahn FROM 1 FOR 1), CAST(SUBSTR(nameAutobahn FROM 2) AS UNSIGNED)");												//execute query and save
			while($data = mysqli_fetch_array($result_Highway)){												//fetch data from result_getPlate
			echo '<option value="' . $data['nameAutobahn'] . '">' . $data['nameAutobahn']. '</option>';		//use echo to execute html in php
			}
		echo "</select>";
	}
	public static function entryChoosen($conn)
	{
		$selection = $_POST["text-Autobahn"];
		echo "<div class='row-radio'>";
			echo "<label>";
				echo "<input type='radio' name='selection' value='entry' checked='checked'>";
				echo "Einfahrt";
			echo "</label>";
			echo "<label>";
				echo "<input type='radio' name='selection' value='exit'>";
				echo "Ausfahrt";
			echo "</label>";
		echo "</div>";
		echo "<select name='text-Autobahn' class='enjoy-css'>";
			echo "<option value=${selection} selected=''>${selection}</option>";
			$result_Highway = mysqli_query($conn,"SELECT DISTINCT nameAutobahn from mautstelle ORDER BY SUBSTR(nameAutobahn FROM 1 FOR 1), CAST(SUBSTR(nameAutobahn FROM 2) AS UNSIGNED)");												//execute query and save
			while($data = mysqli_fetch_array($result_Highway)){												//fetch data from result_getPlate
			echo '<option value="' . $data['nameAutobahn'] . '">' . $data['nameAutobahn']. '</option>';		//use echo to execute html in php
			}
		echo "</select>";

		echo "<select name='text-Station' class='enjoy-css'>";
		echo "<option value='' disabled='' selected='' hidden=''>Mautstation</option>";
		$result_getJunction = mysqli_query($conn,"SELECT DISTINCT nameKreuz from mautstelle WHERE nameAutobahn = '$selection' ORDER BY SUBSTR(nameKreuz FROM 1 FOR 1), CAST(SUBSTR(nameKreuz FROM 2) AS UNSIGNED)");												//execute query and save
		while($data = mysqli_fetch_array($result_getJunction)){												//fetch data from result_getPlate
		echo '<option value="' . $data['nameKreuz'] . '">' . $data['nameKreuz']. '</option>';		//use echo to execute html in php
		}
		echo "</select>";

		echo "<input id='text-plate-entry' name='text-plate-entry' class='enjoy-css' type='text' placeholder='Kennzeichen'>";
		echo "<input id='text-time-entry' name='text-time-entry' class='enjoy-css' type='text' placeholder='DD.MM.YYYY HH:MM:SS'>";
	}
	public static function exitChoosen($conn)
	{
		echo "<div class='row-radio'>";
			echo "<label>";
				echo "<input type='radio' name='selection' value='entry' >";
				echo "Einfahrt";
			echo "</label>";
			echo "<label>";
				echo "<input type='radio' name='selection' value='exit' checked='checked'>";
				echo "Ausfahrt";
			echo "</label>";
		echo "</div>";
		echo "<select name='text-Autobahn' class='enjoy-css'>";
			echo "<option value='' disabled='' selected='' hidden=''>Autobahn</option>";
			$result_Highway = mysqli_query($conn,"SELECT DISTINCT nameAutobahn from mautstelle ORDER BY SUBSTR(nameAutobahn FROM 1 FOR 1), CAST(SUBSTR(nameAutobahn FROM 2) AS UNSIGNED)");												//execute query and save
			while($data = mysqli_fetch_array($result_Highway)){												//fetch data from result_getPlate
			echo '<option value="' . $data['nameAutobahn'] . '">' . $data['nameAutobahn']. '</option>';		//use echo to execute html in php
			}
		echo "</select>";

		echo "<select name='text-plate-exit' class='enjoy-css'>";
			echo "<option value="" disabled selected hidden>Kennzeichen</option>";
			$query_getPlate = "SELECT kennzeichen from strecke WHERE faehrtAusID IS NULL";						//sql query to get  kennzeichen
			$result_getPlate = mysqli_query($conn,$query_getPlate);												//execute query and save
			while($data = mysqli_fetch_array($result_getPlate)){												//fetch data from result_getPlate
				echo '<option value="' . $data['kennzeichen'] . '">' . $data['kennzeichen']. '</option>';		//use echo to execute html in php
			}
		echo "</select>";

		echo "<input id='text-time-exit' name='text-time-exit' class='enjoy-css' type='text' placeholder='DD.MM.YYYY HH:MM:SS'>";
	}

}
























 ?>
