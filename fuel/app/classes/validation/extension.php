<?php
/**
 * Created by PhpStorm.
 * User: ***
 * Date: 2017/03/07
 * Time: 12:27
 */
class Validation_Extension {

	public static function _validation_not_null($value){
		Validation::active()->set_message('not_null', 'value is null.');

		return $value !== '';
	}

}