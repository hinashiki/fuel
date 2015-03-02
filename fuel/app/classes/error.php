<?php
/**
 * error handling extends
 *
 */
class Error extends Fuel\Core\Error
{

	/**
	 * @overwrap
	 */
	public static function exception_handler(\Exception $e)
	{
		// recoverするエラーであればロールバックしない
		$fatal = (bool)( ! in_array($e->getCode(), \Config::get('errors.continue_on', array())));
		if($fatal and DB::in_transaction())
		{
			DB::rollback_transaction();
		}
		return parent::exception_handler($e);
	}

	/**
	 * @overwrap
	 */
	public static function error_handler($severity, $message, $filepath, $line)
	{
		// recoverするエラーであればロールバックしない
		$fatal = (bool)( ! in_array($severity, \Config::get('errors.continue_on', array())));
		if($fatal and DB::in_transaction())
		{
			DB::rollback_transaction();
		}
		return parent::error_handler($severity, $message, $filepath, $line);
	}
}

/**
 * Exception Handler for UT
 *
 */
class RedirectTestException extends \Exception
{
}
