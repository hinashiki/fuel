<?php
/**
 * extends fuel core log
 *
 */
class Log extends \Fuel\Core\Log
{

	/**
	 * @overwrap
	 */
	public static function write($level, $msg, $method = null)
	{
		if(is_array($msg))
		{
			$msg = var_export($msg, true);
		}
		return parent::write($level, $msg, $method);
	}
}
