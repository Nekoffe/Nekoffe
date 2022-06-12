<?php
require_once './src/autoloader.php';
require_once './src/app.php';

use Kernel\Router;
use Kernel\Session;
use Kernel\View;

Session::start();
$router = new Router('routing.yml');

try {
	$controller = $router();
	$response = $controller->content();
	if($response instanceof View) {
		$page = new View('page.phtml', [
			'content' => $response,
			'title' => $controller->title(),
		]);
		echo $page;
	}
	else
		echo $response;
} catch(Throwable $err) {
	dbg($err);
}
