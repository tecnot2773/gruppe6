<?php

	
	include_once 'db.php';
	
	// Distance Calculatitudeion
	class Geo
	{
		const RADIUS = 6378.16; // earth radius in km
	 
		/**
		 * Get distance between two geo coordinates on earth
		 *
		 * @param $latitude1 latitude for point 1
		 * @param $longitude1 longitude for point 1
		 * @param $latitude2 latitude for point 2
		 * @param $longitude1 longitude for point 2
		 * @return (float) distance in kilometer
		 */
		 
		public static function get_distance($latitude1,$longitude1,$latitude2,$longitude2)
		{
			$dlongitude 	= self::radians($longitude2-$longitude1);
			$dlatitude 	= self::radians($latitude2-$latitude1);
			$a 		= pow(sin($dlatitude/2),2) + cos(self::radians($latitude1)) * cos(self::radians($latitude2)) * pow(sin($dlongitude/2),2);
			$angle 	= 2 * atan2(sqrt($a),sqrt(1-$a));
	 
			return round($angle * self::RADIUS, 2, PHP_ROUND_HALF_UP) ;
		}
	 
		private static function radians($x)
		{
			return $x * pi() / 180;
		}
	}
?>