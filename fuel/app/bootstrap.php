<?php
// Bootstrap the framework DO NOT edit this
require COREPATH.'bootstrap.php';


Autoloader::add_classes(array(
	// Add classes you want to override here
	'Agent'      => APPPATH.'classes/agent.php',
	'Controller' => APPPATH.'classes/controller.php',
	'Error'      => APPPATH.'classes/error.php',
	'Input'      => APPPATH.'classes/input.php',
	'Log'        => APPPATH.'classes/log.php',
	'Response'   => APPPATH.'classes/response.php',
	'TestCase'   => APPPATH.'classes/testcase.php',
	// Add exception what you want
	'RedirectTestException' => APPPATH.'classes/error.php',
));

// Register the autoloader
Autoloader::register();

/**
 * Your environment.  Can be set to any of the following:
 *
 * Fuel::DEVELOPMENT
 * Fuel::TEST
 * Fuel::STAGING
 * Fuel::PRODUCTION
 */
Fuel::$env = (isset($_SERVER['FUEL_ENV']) ? $_SERVER['FUEL_ENV'] : Fuel::DEVELOPMENT);

// Initialize the framework with the config file.
Fuel::init('config.php');
