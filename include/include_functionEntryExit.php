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
			$result_getPlate = mysqli_query($conn,"SELECT DISTINCT nameAutobahn from mautstelle ORDER BY SUBSTR(nameAutobahn FROM 1 FOR 1), CAST(SUBSTR(nameAutobahn FROM 2) AS UNSIGNED)");												//execute query and save
			while($data = mysqli_fetch_array($result_getPlate)){												//fetch data from result_getPlate
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
			$result_getPlate = mysqli_query($conn,"SELECT DISTINCT nameAutobahn from mautstelle ORDER BY SUBSTR(nameAutobahn FROM 1 FOR 1), CAST(SUBSTR(nameAutobahn FROM 2) AS UNSIGNED)");												//execute query and save
			while($data = mysqli_fetch_array($result_getPlate)){												//fetch data from result_getPlate
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
			echo "<option value='${selection}' selected=''>'$selection'</option>";
			$result_getPlate = mysqli_query($conn,"SELECT DISTINCT nameAutobahn from mautstelle ORDER BY SUBSTR(nameAutobahn FROM 1 FOR 1), CAST(SUBSTR(nameAutobahn FROM 2) AS UNSIGNED)");												//execute query and save
			while($data = mysqli_fetch_array($result_getPlate)){												//fetch data from result_getPlate
			echo '<option value="' . $data['nameAutobahn'] . '">' . $data['nameAutobahn']. '</option>';		//use echo to execute html in php
			}
		echo "</select>";
	}

}
























 ?>
