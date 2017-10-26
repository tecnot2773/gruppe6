<?php
class EntryExit{
	public static function noSelect($conn){
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

}
























 ?>
