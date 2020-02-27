<?php
namespace MyApp\Web\AdminPanel;
use MyApp\Web\Html\Html;
use MyApp\Web\AdminPanel\View\OrdersUserView;

class OrdersUser
{
	function Index($r)
	{
		Html::Header(OrdersUserView::Title(), OrdersUserView::Description(), OrdersUserView::Keywords(), OrdersUserView::Head());

		// Attr list
		echo OrdersUserView::Show();

		Html::Footer();
	}
}
?>