<?php
	
	include_once 'include_db.php';
	
	// Distance Calculatitudeion
	class Geo
	{
		const RADIUS = 6378.16; 																														// earth radius in km
	 
		 
		public static function get_distance($latitude1,$longitude1,$latitude2,$longitude2)																//get parameters from function call
		{
			$dlongitude 	= self::radians($longitude2-$longitude1);																					//call function radians and hand over parameters
			$dlatitude 	= self::radians($latitude2-$latitude1);																							//call function radians and hand over parameters
			$a 		= pow(sin($dlatitude/2),2) + cos(self::radians($latitude1)) * cos(self::radians($latitude2)) * pow(sin($dlongitude/2),2);			//calculate
			$angle 	= 2 * atan2(sqrt($a),sqrt(1-$a));																									//more calculation
	 
			return round($angle * self::RADIUS, 2, PHP_ROUND_HALF_UP) ;																					//return distance to funtion call
		}
	 
		private static function radians($x)
		{
			return $x * pi() / 180;
		}
	}
?>