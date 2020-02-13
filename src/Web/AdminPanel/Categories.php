<?php
namespace MyApp\Web\AdminPanel;
use MyApp\Web\Html\Html;
use MyApp\Web\AdminPanel\View\CategoriesView;
use MyApp\Web\AdminPanel\View\EditCategoriesView;

class Categories
{
	function Index($r)
	{
		Html::Header(CategoriesView::Title(), CategoriesView::Description(), CategoriesView::Keywords(), CategoriesView::Head());

		if(!empty($_GET['edit']))
		{
			// Edit attr
			echo EditCategoriesView::Show();
		}
		else
		{
			// Attr list
			echo CategoriesView::Show();
		}

		Html::Footer();
	}
}
?>