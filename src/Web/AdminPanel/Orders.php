<?php
namespace MyApp\Web\AdminPanel;
use MyApp\Web\Html\Html;
use MyApp\Web\AdminPanel\View\OrdersView;

class Orders
{
	function Index($r)
	{
		Html::Header(OrdersView::Title(), OrdersView::Description(), OrdersView::Keywords(), OrdersView::Head());

		// Attr list
		echo OrdersView::Show();

		Html::Footer();
	}
}
?>