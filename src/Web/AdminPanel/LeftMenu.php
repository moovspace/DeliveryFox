<?php
namespace MyApp\Web\AdminPanel;

use MyApp\Web\AdminPanel\View\ProfilView;

class LeftMenu
{
	static function Show()
	{
		$menu = ProfilView::Menu();

		return '
		<div id="box-left">
			' . $menu->GetMenu() .'
		</div>
		';
	}
}
?>