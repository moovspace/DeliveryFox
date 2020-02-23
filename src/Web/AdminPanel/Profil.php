<?php
namespace MyApp\Web\AdminPanel;
use MyApp\Web\Html\Html;
use MyApp\Web\AdminPanel\View\ProfilView;

class Profil
{
	function Index($r)
	{
		Html::Header(ProfilView::Title(), ProfilView::Description(), ProfilView::Keywords(), ProfilView::Head());

		echo ProfilView::Show(); // Page content

		Html::Footer();
	}
}
?>