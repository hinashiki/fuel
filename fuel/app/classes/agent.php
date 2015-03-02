<?php
/**
 * coreのagentクラスがメモリを食いまくるので
 * extends \Fuel\Core\Agentはせずに独自拡張する
 */
class Agent
{
	/**
	 *
	 * @return bool
	 */
	public static function is_sp()
	{
		$ua = $_SERVER['HTTP_USER_AGENT'];
		if(
			(strpos($ua, 'iPhone')  !== false) ||
			(strpos($ua, 'iPod')    !== false) ||
			(strpos($ua, 'Android') !== false) ||
			(strpos($ua, 'Googlebot-Mobile') !== false)
		)
		{
			return true;
		}
		return false;
	}

	/**
	 *
	 * @return bool
	 */
	public static function is_android()
	{
		$ua = $_SERVER['HTTP_USER_AGENT'];
		if(strpos($ua, 'Android') !== false)
		{
			return true;
		}
		return false;
	}
}
