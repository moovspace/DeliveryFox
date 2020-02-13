<?php
namespace MyApp\Web\AdminPanel;

use MyApp\Web\AdminPanel\User;
use MyApp\Web\AdminPanel\View\ProfilView;
use MyApp\Web\AdminPanel\View\AttributesView;
use MyApp\Web\AdminPanel\View\CategoriesView;

class LeftMenu
{
	static function Show()
	{
		$user = new User();

		// Menu user part
		$menu = ProfilView::Menu()->GetMenu();

		// Admin part
		if($user->Role() == 'admin')
		{
			$menu .= AttributesView::Menu()->GetMenu();
			$menu .= CategoriesView::Menu()->GetMenu();
		}

		if($user->Role() == 'worker')
		{

		}

		if($user->Role() == 'driver')
		{

		}

		return '
		<div id="box-left">
			' . $menu . '
		</div>
		';
	}
}
?>