<?php
/**
 * Observer for geometry type
 *
 * @dependency Orm
 */
class Observer_Geometry extends Orm\Observer
{

	public static $property = 'geometry';
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

	public function before_save(Orm\Model $Model)
	{
		if($Model->is_changed() and preg_match('/^POINT\([0-9. ]+\)/', $Model->{$this->_property}))
		{
			$Model->set($this->_property, \DB::expr('GeomFromText("'.$Model->{$this->_property}.'")'));
		}
	}

}
