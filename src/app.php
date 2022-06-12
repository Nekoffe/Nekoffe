<?php
require_once 'settings.php';
include_once 'local.settings.php';

/**
 * Clean all the active buffers
 * */
function ob_purge()
{
	while (ob_get_level() > 0)
		ob_end_clean();
	return true;
}

/**
 * Pretty print variables and end script
 * */
function dbg(mixed ...$values)
{
	ob_purge();
	foreach ($values as $out) {
		echo '<pre>';
		switch(gettype($out)) {
			case 'boolean':
				echo $out ? 'true' : 'false';
				break;
			case 'NULL':
				echo 'null';
				break;
			default:
				print_r($out);
		}
		echo '</pre>';
	}
	die;
}

/**
 * End the script with a redirect
 * */
function redirect(string $path)
{
	ob_purge();
	http_response_code(303);
	header("Location: $path");
	die;
}
