<?php
namespace MyApp\Web\AdminPanel;

use MyApp\Web\AdminPanel\User;
use MyApp\Web\AdminPanel\View\ProfilView;
use MyApp\Web\AdminPanel\View\AttributesView;
use MyApp\Web\AdminPanel\View\CategoriesView;
use MyApp\Web\AdminPanel\View\ProductsView;
use MyApp\Web\AdminPanel\View\OrdersView;
use MyApp\Web\AdminPanel\View\OrdersUserView;
use MyApp\Web\AdminPanel\View\UsersListView;
use MyApp\Web\AdminPanel\View\NewsletterView;

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
			$menu .= ProductsView::Menu()->GetMenu();
			$menu .= OrdersView::Menu()->GetMenu();
			$menu .= OrdersUserView::Menu()->GetMenu();
			$menu .= UsersListView::Menu()->GetMenu();
			$menu .= NewsletterView::Menu()->GetMenu();
		}

		if($user->Role() == 'worker')
		{
			$menu .= AttributesView::Menu()->GetMenu();
			$menu .= CategoriesView::Menu()->GetMenu();
			$menu .= ProductsView::Menu()->GetMenu();
			$menu .= OrdersView::Menu()->GetMenu();
			$menu .= OrdersUserView::Menu()->GetMenu();
		}

		if($user->Role() == 'driver')
		{
			$menu .= AttributesView::Menu()->GetMenu();
			$menu .= CategoriesView::Menu()->GetMenu();
			$menu .= ProductsView::Menu()->GetMenu();
			$menu .= OrdersView::Menu()->GetMenu();
			$menu .= OrdersUserView::Menu()->GetMenu();
		}

		if($user->Role() == 'user')
		{
			$menu .= OrdersUserView::Menu()->GetMenu();
		}

		return '
		<div id="box-left">
			' . $menu . '
		</div>
		';
	}
}
?>