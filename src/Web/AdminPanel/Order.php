<?php
namespace MyApp\Web\AdminPanel;
use MyApp\Web\Html\Html;
use MyApp\Web\AdminPanel\View\OrderView;

class Order
{
	function Index($r)
	{
		Html::Header(OrderView::Title(), OrderView::Description(), OrderView::Keywords(), OrderView::Head());

		// Attr list
		echo OrderView::Show();

		Html::Footer();
	}
}
?>