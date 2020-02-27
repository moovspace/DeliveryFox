<?php
namespace MyApp\Web\AdminPanel;
use MyApp\Web\Html\Html;
use MyApp\Web\AdminPanel\View\UserProfilView;

class UserProfil
{
	function Index($r)
	{
		Html::Header(UserProfilView::Title(), UserProfilView::Description(), UserProfilView::Keywords(), UserProfilView::Head());

		echo UserProfilView::Show(); // Page content

		Html::Footer();
	}
}
?>