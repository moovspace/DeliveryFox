<?php
namespace MyApp\Web\AdminPanel;
use MyApp\Web\Html\Html;
use MyApp\Web\AdminPanel\View\ProductsView;

class Products
{
	function Index($r)
	{
		Html::Header(ProductsView::Title(), ProductsView::Description(), ProductsView::Keywords(), ProductsView::Head());

		// Attr list
		echo ProductsView::Show();

		Html::Footer();
	}
}
?>