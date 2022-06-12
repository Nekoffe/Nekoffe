<?php

namespace Kernel;

use Error;
use Exception;

final class Router
{
	/**
	 * Named routes defintions
	 * @var array 
	 * */
	private array $routes;

	/**
	 * Routing tree
	 * @var array
	 * */
	private array $tree = [];

	/**
	 * Create a router using a file 
	 * to import the routes
	 * @param string $filename the full file name and path
	 * */
	public function __construct(string $filename)
	{
		$this->routes = yaml_parse_file($filename);
		foreach ($this->routes as $name => $route)
			$this->processRoute($name, $route);
	}

	private function parsePath(string $path): array
	{
		# Convert path to an array form
		$result = explode('/', $path);
		# Normalize the route
		$result = array_filter($result, function ($entry) {
			return !empty($entry);
		});
		return $result;
	}

	/**
	 * Process a given route and put it in the routing tree
	 * @param string $name the route machine name
	 * @param object $route the route definition
	 * */
	private function processRoute(string $name, array $route)
	{
		$params = [];
		$path = $route['path'] ?? null;
		if (empty($path))
			throw new Error('You need to specify a path');
		$path = $this->parsePath($path);
		$current = &$this->tree;
		foreach ($path as $sub) {
			if ($sub[0] === '$') {
				$params[] = substr($sub, 1);
				$current = &$current['sub']['$'];
			} else
				$current = &$current['sub'][$sub];
		}
		$current['name'] = $name;
		if (!empty($params))
			$current['params'] = $params;
	}

	/**
	 * Get route using a path
	 * @param string $path the path
	 * @return ?array the path info
	 * */
	public function path(string $path): ?array
	{
		$data = [];
		$current = &$this->tree;
		$path = $this->parsePath($path);
		foreach ($path as $sub) {
			if (!isset($current['sub'][$sub])) {
				$data[] = $sub;
				$current = &$current['sub']['$'];
			} else
				$current = &$current['sub'][$sub];
		}
		$name = $current['name'] ?? null;
		if (empty($name))
			throw new Exception('Route not found', 404);
		$route = $this->get($name);
		$params = [];
		if (!empty($current['params'])) {
			foreach ($current['params'] as $i => $key)
				$params[$key] = $data[$i];
		}
		return [
			'route' => $route,
			'params' => $params,
		];
	}

	/**
	 * Get route by name
	 * @param string $name route name
	 * @return ?array the route info
	 * */
	public function get(string $name): ?array
	{
		return $this->routes[$name] ?? null;
	}

	/**
	 * Get the route and load the controller 
	 * @param string $path the routing path
	 * @param string $method the method used
	 * @return Controller the route controller
	 * */
	public function __invoke(string $path = null): Controller
	{
		$path ??= parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
		$info = $this->path($path);
		$class = $info['route']['controller'];
		$class = "\\Controller\\$class";
		$controller = new $class(...$info['params']);
		$controller->init($info['route']);
		return $controller;
	}
}
