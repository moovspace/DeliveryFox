<?php
namespace MyApp\Web\AdminPanel;
use MyApp\Web\Html\Html;
use MyApp\Web\AdminPanel\View\AddProductView;

class AddProduct
{
	function Index($r)
	{
		Html::Header(AddProductView::Title(), AddProductView::Description(), AddProductView::Keywords(), AddProductView::Head());

		echo AddProductView::Show(); // Page content

		Html::Footer();
	}
}
?>