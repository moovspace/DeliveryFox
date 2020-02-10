<?php
namespace MyApp\Web\AdminPanel\View;

use Exception;
use MyApp\App\Component;
use MyApp\Web\AdminPanel\LeftMenu;
use MyApp\Web\AdminPanel\User;

class ProfilView extends Component
{
	static function Data($arr = null)
	{
		try
		{
			$user = new User();
			// User table
			$user->SetUser('role', 'user');
			// $user->SaveUser();

			// User_info table
			$user->SetUserInfo('firstname', '');
			$user->SetUserInfo('lastname', '');
			// $user->SaveUserInfo();
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
		}

		return  'Db data here';
	}

	static function Show($arr = null)
	{
		// Get data
		$arr = self::Data();

		// Import component
		$menu = LeftMenu::Show();

		// Retuen html
		return self::Html($arr, $menu);
	}

	static function Html($arr = null, $html = '')
	{
		return $html.'
			<div id="box-right">
				<h1>Profil Component</h1>
			</div>
		';
	}

	static function Title()
	{
		return 'Page title here. Title() method.';
	}

	static function Description()
	{
		return 'Page description text. Description() method.';
	}

	static function Keywords()
	{
		return 'Page keywords. Keywords() method';
	}

	static function Head()
	{
		// return [
		// 	'<link rel="stylesheet" href="/src/Web/Auth/auth.css">',
		// 	'<script defer src="/src/Web/Auth/auth.js"></script>'
		// ];
		return '';
	}
}
?>