<?php
/**
 * extends input
 *
 */
class Input extends Fuel\Core\Input
{
	/**
	 * @overwrap
	 */
	public static function real_ip($default = '0.0.0.0', $exclude_reserved = false)
	{
		$dummy = \Config::get('dummy_ip_address');
		if($dummy !== null)
		{
			return $dummy;
		}
		return parent::real_ip($default, $exclude_reserved);
	}
}
