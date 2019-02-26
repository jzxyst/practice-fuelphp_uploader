<?php
/**
 * Created by PhpStorm.
 * User: ***
 * Date: 2017/03/08
 * Time: 16:35
 */
class Utility_Format {

	public static function to_formatted_size($size){

		// 単位(B, KB, MB, GB, TB, PB, EB, ZB, YB)
		$unit = array('byte', 'KB', 'MB', 'GB', 'TB');

		$unit_count = count($unit);
		for ($i = 0; $i < $unit_count; $i++) {
			if ($size < 1024 || $i == $unit_count - 1) {
				if ($i == 0) {
					$str = number_format($size) . ' ' . $unit[ $i ];
				} else {
					$str = number_format($size, 2, '.', '' ) . ' ' . $unit[ $i ];
				}
				break;
			}
			$size = $size / 1024;
		}

		return $str;
	}
}