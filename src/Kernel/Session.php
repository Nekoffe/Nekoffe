<?php

namespace Kernel;

final class Session
{
	/**
	 * Check if the session file exists
	 * @return bool 
	 * */
	static private function exists(): bool
	{
		$name = session_name();
		$path = session_save_path();
		$ssid = $_COOKIE[$name] ?? null;
		if (!empty($ssid))
			return file_exists("$path/sess_$ssid");
		return false;
	}

	/**
	 * Check if the session has been started
	 * @return bool 
	 * */
	static function active(): bool
	{
		return session_status() === PHP_SESSION_ACTIVE;
	}

	/**
	 * Start the session only if the session exists
	 * @return bool 
	 * */
	static function start(): bool
	{
		if (!self::exists())
			return false;
		return session_start();
	}

	/**
	 * Destroy the session and end
	 * @return bool 
	 * */
	static function end(): bool
	{
		if (!self::exists())
			return false;
		return session_destroy();
	}

	/**
	 * Save the session data and close the session handler
	 * @return bool 
	 * */
	static function commit(): bool {
		if(!self::active())
			return false;
		return session_commit();
	}
}
