<?php
namespace MyApp\App\Plugin;
use MyApp\App\Menu\Menu;

abstract class Plugin
{
	function __construct($name = '', $icon = '', $about = '')
	{
		$this->Name = $name;
		$this->Icon = $icon;
		$this->About = $about;
	}

	/**
	 * Left panel menu part
	 *
	 * @return object Menu class object
	 */
	static function Menu(): object
	{
		// Class new Menu()
		return $menu = new Menu();
	}

	/**
	 * Content panel part
	 *
	 * @return string Html string
	 */
	function Html(): string
	{
		return $html = '<h1>plugin html part</h1>';
	}

	function Action() : string
	{
		// $_POST, $_GET
		return $action = '<h4>Action confirmation alert</h4>';
	}

	function ScriptLink() : string
	{
		return 'https://link.js';
	}

	function StyleLink() : string
	{
		return 'https://link.js';
	}

	final function Style() : string
	{
		return '<link rel="stylesheet" href="'.$this->StyleLink().'">';
	}

	final function Script() : string
	{
		return '<script src="'.$this->ScriptLink().'"></script>';
	}
}
?>