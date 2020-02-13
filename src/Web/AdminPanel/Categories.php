<?php
namespace MyApp\Web\AdminPanel;
use MyApp\Web\Html\Html;
use MyApp\Web\AdminPanel\View\CategoriesView;

class Categories
{
	function Index($r)
	{
		Html::Header(CategoriesView::Title(), CategoriesView::Description(), CategoriesView::Keywords(), CategoriesView::Head());

		// Attr list
		echo CategoriesView::Show();

		Html::Footer();
	}
}
?>