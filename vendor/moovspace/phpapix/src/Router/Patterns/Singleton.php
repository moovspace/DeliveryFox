<?php
declare(strict_types=1);

namespace PhpApix\Router\Patterns;

final class Singleton
{
	/**
	 * Gets the instance of class (only one per app)
	 */
	public static function getInstance(): self
	{
		static $instance;

		if (null === $instance) {
			$instance = new self();
		}

		return $instance;
	}

	/**
	 * Is not allowed to call from outside to prevent from creating multiple instances,
	 * to use the singleton, you have to obtain the instance from Singleton::getInstance() instead
	 */
	private function __construct()
	{
	}

	/**
	 * prevent the instance from being cloned (which would create a second instance of it)	 
	 */
	private function __clone()
	{
	}

	/**
	 * prevent from being unserialized (which would create a second instance of it)
	 * protected or private
	 */
	private function __wakeup()
	{
	}
}
?>