<?php
/**
 * Fuel\Core\Validation wrapper
 * write common site validation here
 *
 */
class Validation_Common extends \Fuel\Core\Validation
{

	/**
	 * same as inList validation in cakePHP
	 *
	 * @param array $list ex. (1, 2, 3...)
	 * @return boolean
	 */
	public static function _validation_in_list($val, $list = array())
	{
		return in_array($val, $list);
	}

	/**
	 * compare field value
	 *
	 * @param string $compare_field
	 * @return boolean
	 */
	public static function _validation_same($val, $compare_field)
	{
		return ($val === \Input::{strtolower(\Input::method())}($compare_field));
	}


}
