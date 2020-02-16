<?php
namespace MyApp\Web\AdminPanel;
use MyApp\Web\Html\Html;
use MyApp\Web\AdminPanel\View\EditProductView;

class EditProduct
{
	function Index($r)
	{
		Html::Header(EditProductView::Title(), EditProductView::Description(), EditProductView::Keywords(), EditProductView::Head());

		echo EditProductView::Show(); // Page content

		Html::Footer();
	}
}
?>