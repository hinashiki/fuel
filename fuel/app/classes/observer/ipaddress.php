<?php
/**
 * Observer for ip_address column
 *
 * @dependency Orm
 */
class Observer_IpAddress extends Orm\Observer
{

	public static $property = 'ip_address';
	protected $_property;


	/**
	 * Set the properties for this observer instance, based on the parent model's
	 * configuration or the defined defaults.
	 *
	 * @param  string  Model class this observer is called on
	 */
	public function __construct($class)
	{
		$props = $class::observers(get_class($this));
		$this->_property = isset($props['property']) ? $props['property'] : static::$property;
	}

	public function before_insert(Orm\Model $Model)
	{
		if(is_null($Model->{$this->_property}))
		{
			$Model->set($this->_property, \Input::real_ip());
		}
	}

}
