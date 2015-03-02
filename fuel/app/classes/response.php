<?php
class Response extends Fuel\Core\Response
{
	/**
	 * UT時にExceptionを投げるように修正
	 * @overwrap
	 */
	public static function redirect($url = '', $method = 'location', $code = 302)
	{
		if(Fuel::$is_test)
		{
			throw new RedirectTestException($url, $code);
		}
		parent::redirect($url, $method, $code);
	}
}
