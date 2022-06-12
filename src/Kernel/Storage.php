<?php

namespace Kernel;

final class Storage
{
	/**
	 * The database instance
	 * @var self the database actual connection
	 * */
	static private $instance;

	/**
	 * Get the database connection
	 * @return self
	 * */
	static public function driver()
	{
		if (!isset(self::$instance)) {
			$driver_class = DRIVER;
			self::$instance = new $driver_class(...STORAGE);
		}
		return self::$instance;
	}
}
