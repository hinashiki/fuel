<?php
/**
 * controller wrapper
 *
 */
class Controller extends \Fuel\Core\Controller
{

	public function before()
	{
		\MaintenanceMode::check();
		\Seo::instance($this->request)->in_controller_before();
	}

}
