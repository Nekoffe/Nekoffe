<?php

spl_autoload_register(function (string $class) {
	$path = str_replace('\\', '/', $class);
	require_once __DIR__ . "/{$path}.php";
});
