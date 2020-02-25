<?php
declare(strict_types=1);

namespace PhpApix\Router\Patterns;

trait SingletonTrait {
	private static $instance;

	public static function getInstance() {
		if (!(self::$instance instanceof self)) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	protected function __construct()
	{
	}

	protected function __clone()
	{
	}

	protected function __wakeup()
	{
	}
}

// How to use it
// class SingletonClass
// {
// 	use SingletonTrait;
//
// }
?>