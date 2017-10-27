<?php
class EntryExit{
	public static function entry($conn)
	{
		echo "\t\t\t\t\t<div class='row-radio'>\r\n";
		echo "\t\t\t\t\t\t<label>\r\n";
		echo "\t\t\t\t\t\t\t<input type='radio' name='selection' value='entry' checked='checked'>\r\n";
		echo "\t\t\t\t\t\t\tEinfahrt\r\n";
		echo "\t\t\t\t\t\t</label>\r\n";
		echo "\t\t\t\t\t\t<label>\r\n";
		echo "\t\t\t\t\t\t\t<input type='radio' name='selection' value='exit'>\r\n";
		echo "\t\t\t\t\t\t\tAusfahrt\r\n";
		echo "\t\t\t\t\t\t</label>\r\n";
		echo "\t\t\t\t\t</div>\r\n";
		echo "\t\t\t\t\t<select name='text-Autobahn' class='enjoy-css'>\r\n";
		echo "\t\t\t\t\t\t<option value='' disabled='' selected='' hidden=''>Autobahn</option>\r\n";
		$result_Highway = mysqli_query($conn,"SELECT DISTINCT nameAutobahn from mautstelle ORDER BY SUBSTR(nameAutobahn FROM 1 FOR 1), CAST(SUBSTR(nameAutobahn FROM 2) AS UNSIGNED)");												//execute query and save
		while($data = mysqli_fetch_array($result_Highway)){												//fetch data from result_getPlate
			echo "\t\t\t\t\t\t" . '<option value="' . $data['nameAutobahn'] . '">' . $data['nameAutobahn']. '</option>' . "\r\n";		//use echo to execute html in php
		}
		echo "\t\t\t\t\t</select>\r\n";
		echo "\t\t\t\t\t<div class='placeholder'></div>\r\n";
		echo "\t\t\t\t\t<div class='row-data'>\r\n";
		echo "\t\t\t\t\t\t<input class='buttonsmall' type='submit' name='execute' value='Weiter'>\r\n";
		echo "\t\t\t\t\t</div>\r\n";
		echo "\t\t\t\t\t<div class='row-bottom'>\r\n";
		echo "\t\t\t\t\t</div>\r\n";
	}
	public static function exit($conn)
	{
		echo "\t\t\t\t\t<div class='row-radio'>\r\n";
		echo "\t\t\t\t\t\t<label>\r\n";
		echo "\t\t\t\t\t\t\t<input type='radio' name='selection' value='entry' >\r\n";
		echo "\t\t\t\t\t\t\tEinfahrt\r\n";
		echo "\t\t\t\t\t\t</label>\r\n";
		echo "\t\t\t\t\t\t<label>\r\n";
		echo "\t\t\t\t\t\t\t<input type='radio' name='selection' value='exit' checked='checked'>\r\n";
		echo "\t\t\t\t\t\t\tAusfahrt\r\n";
		echo "\t\t\t\t\t\t</label>\r\n";
		echo "\t\t\t\t\t</div>\r\n";
		echo "\t\t\t\t\t<select name='text-Autobahn' class='enjoy-css'>\r\n";
		echo "\t\t\t\t\t\t<option value='' disabled='' selected='' hidden=''>Autobahn</option>\r\n";
		$result_Highway = mysqli_query($conn,"SELECT DISTINCT nameAutobahn from mautstelle ORDER BY SUBSTR(nameAutobahn FROM 1 FOR 1), CAST(SUBSTR(nameAutobahn FROM 2) AS UNSIGNED)");												//execute query and save
		while($data = mysqli_fetch_array($result_Highway)){												//fetch data from result_getPlate
			echo "\t\t\t\t\t\t" . '<option value="' . $data['nameAutobahn'] . '">' . $data['nameAutobahn']. '</option>' . "\r\n";		//use echo to execute html in php
		}
		echo "\t\t\t\t\t</select>\r\n";

		echo "\t\t\t\t\t<div class='placeholder'></div>\r\n";
		echo "\t\t\t\t\t<div class='row-data'>\r\n";
		echo "\t\t\t\t\t\t<input class='buttonsmall' type='submit' name='execute' value='Weiter'>\r\n";
		echo "\t\t\t\t\t</div>\r\n";
		echo "\t\t\t\t\t<div class='row-bottom'>\r\n";
		echo "\t\t\t\t\t</div>\r\n";
	}
	public static function entryChoosen($conn)
	{
		$selection = $_POST["text-Autobahn"];
		echo "\t\t\t\t\t<div class='row-radio'>\r\n";
		echo "\t\t\t\t\t\t<label>\r\n";
		echo "\t\t\t\t\t\t\t<input type='radio' name='selection' value='entry' checked='checked'>\r\n";
		echo "\t\t\t\t\t\t\tEinfahrt\r\n";
		echo "\t\t\t\t\t\t</label>\r\n";
		echo "\t\t\t\t\t</div>\r\n";
		echo "\t\t\t\t\t<select name='text-Autobahn' class='enjoy-css'>\r\n";
		echo "\t\t\t\t\t\t<option value=${selection} selected=''>${selection}</option>\r\n";
		echo "\t\t\t\t\t</select>\r\n";

		echo "\t\t\t\t\t<select name='text-Station' class='enjoy-css'>\r\n";
		echo "\t\t\t\t\t\t<option value='' disabled='' selected='' hidden=''>Mautstation</option>\r\n";
		$result_getJunction = mysqli_query($conn,"SELECT DISTINCT nameKreuz from mautstelle WHERE nameAutobahn = '$selection' ORDER BY SUBSTR(nameKreuz FROM 1 FOR 1), CAST(SUBSTR(nameKreuz FROM 2) AS UNSIGNED)");												//execute query and save
		while($data = mysqli_fetch_array($result_getJunction)){												//fetch data from result_getPlate
			echo "\t\t\t\t\t\t" . '<option value="' . $data['nameKreuz'] . '">' . $data['nameKreuz']. '</option>' . "\r\n";		//use echo to execute html in php
		}
		echo "\t\t\t\t\t</select>\r\n";

		echo "\t\t\t\t\t<input name='text-plate' class='enjoy-css' type='text' placeholder='Kennzeichen'>\r\n";
		echo "\t\t\t\t\t<input name='text-time-entry' class='enjoy-css' type='text' placeholder='DD.MM.YYYY HH:MM:SS'>\r\n";

		echo "\t\t\t\t\t<div class='placeholder'></div>\r\n";
		echo "\t\t\t\t\t<div class='row-data'>\r\n";
		echo "\t\t\t\t\t\t<input class='buttonsmall' type='submit' name='execute' value='Abschicken'>\r\n";
		echo "\t\t\t\t\t</div>\r\n";
		echo "\t\t\t\t\t<div class='row-bottom'>\r\n";
		echo "\t\t\t\t\t</div>\r\n";
	}
	public static function exitChoosen($conn)
	{
		$selection = $_POST["text-Autobahn"];
		echo "\t\t\t\t\t<div class='row-radio'>\r\n";
		echo "\t\t\t\t\t\t<label>\r\n";
		echo "\t\t\t\t\t\t\t<input type='radio' name='selection' value='exit' checked='checked'>\r\n";
		echo "\t\t\t\t\t\t\tAusfahrt\r\n";
		echo "\t\t\t\t\t\t</label>\r\n";
		echo "\t\t\t\t\t</div>\r\n";
		echo "\t\t\t\t\t<select name='text-Autobahn' class='enjoy-css'>\r\n";
		echo "\t\t\t\t\t\t<option value=${selection} selected=''>${selection}</option>\r\n";
		echo "\t\t\t\t\t</select>\r\n";

		echo "\t\t\t\t\t<select name='text-Station' class='enjoy-css'>\r\n";
		echo "\t\t\t\t\t\t<option value='' disabled='' selected='' hidden=''>Mautstation</option>\r\n";
		$result_getJunction = mysqli_query($conn,"SELECT DISTINCT nameKreuz from mautstelle WHERE nameAutobahn = '$selection' ORDER BY SUBSTR(nameKreuz FROM 1 FOR 1), CAST(SUBSTR(nameKreuz FROM 2) AS UNSIGNED)");												//execute query and save
		while($data = mysqli_fetch_array($result_getJunction)){												//fetch data from result_getPlate
			echo "\t\t\t\t\t\t" . '<option value="' . $data['nameKreuz'] . '">' . $data['nameKreuz']. '</option>' . "\r\n";		//use echo to execute html in php
		}
		echo "\t\t\t\t\t</select>\r\n";

		echo "\t\t\t\t\t<select name='text-plate' class='enjoy-css'>\r\n";
		echo "\t\t\t\t\t\t<option value='' disabled selected hidden>Kennzeichen</option>\r\n";
		$query_getPlate = "SELECT kennzeichen from strecke WHERE faehrtAusID IS NULL\r\n";						//sql query to get  kennzeichen
		$result_getPlate = mysqli_query($conn,$query_getPlate);												//execute query and save
		while($data = mysqli_fetch_array($result_getPlate)){												//fetch data from result_getPlate
			echo "\t\t\t\t\t\t" . '<option value="' . $data['kennzeichen'] . '">' . $data['kennzeichen']. '</option>' . "\r\n";		//use echo to execute html in php
		}
		echo "\t\t\t\t\t</select>\r\n";

		echo "\t\t\t\t\t<input name='text-time-exit' class='enjoy-css' type='text' placeholder='DD.MM.YYYY HH:MM:SS'>\r\n";

		echo "\t\t\t\t\t<div class='placeholder'></div>\r\n";
		echo "\t\t\t\t\t<div class='row-data'>\r\n";
		echo "\t\t\t\t\t\t<input class='buttonsmall' type='submit' name='execute' value='Abschicken'>\r\n";
		echo "\t\t\t\t\t</div>\r\n";
		echo "\t\t\t\t\t<div class='row-bottom'>\r\n";
		echo "\t\t\t\t\t</div>\r\n";
	}
	public static function action($conn)
	{
		include_once 'include_entryExit.php';
		echo "\t\t\t\t\t<div class='row-radio'>\r\n";
		echo "\t\t\t\t\t\t<label>\r\n";
		echo "\t\t\t\t\t\t\t<input type='radio' name='selection' value='entry' checked='checked'>\r\n";
		echo "\t\t\t\t\t\t\tEinfahrt\r\n";
		echo "\t\t\t\t\t\t</label>\r\n";
		echo "\t\t\t\t\t\t<label>\r\n";
		echo "\t\t\t\t\t\t\t<input type='radio' name='selection' value='exit'>\r\n";
		echo "\t\t\t\t\t\t\tAusfahrt\r\n";
		echo "\t\t\t\t\t\t</label>\r\n";
		echo "\t\t\t\t\t</div>\r\n";
		echo "\t\t\t\t\t<select name='text-Autobahn' class='enjoy-css'>\r\n";
		echo "\t\t\t\t\t\t<option value='' disabled='' selected='' hidden=''>Autobahn</option>\r\n";
		$result_Highway = mysqli_query($conn,"SELECT DISTINCT nameAutobahn from mautstelle ORDER BY SUBSTR(nameAutobahn FROM 1 FOR 1), CAST(SUBSTR(nameAutobahn FROM 2) AS UNSIGNED)");												//execute query and save
		while($data = mysqli_fetch_array($result_Highway)){												//fetch data from result_getPlate
			echo "\t\t\t\t\t\t" . '<option value="' . $data['nameAutobahn'] . '">' . $data['nameAutobahn']. '</option>' . "\r\n";		//use echo to execute html in php
		}
		echo "\t\t\t\t\t</select>\r\n";

		echo "\t\t\t\t\t<div class='placeholder'></div>\r\n";
		echo "\t\t\t\t\t<div class='row-data'>\r\n";
		echo "\t\t\t\t\t\t<input class='buttonsmall' type='submit' name='execute' value='Weiter'>\r\n";
		echo "\t\t\t\t\t</div>\r\n";
		echo "\t\t\t\t\t<div class='row-bottom'>\r\n";
		echo "\t\t\t\t\t</div>\r\n";
	}

}
























 ?>
