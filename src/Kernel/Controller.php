<?php

namespace Kernel;

use Exception;

abstract class Controller
{
	/**
	 * Init the controller and check permissions
	 * */
	public function init(array $route)
	{
		# Check access
		if (!empty($route['access'])) {
			if (!Session::active())
				throw new Exception('Access denied', 403);
		}
	}

	/**
	 * Get the controller title
	 * @return string the title
	 * */
	public function title(): string
	{
		return APP_NAME;
	}

	/**
	 * Get the controller content
	 * */
	abstract public function content();
}
