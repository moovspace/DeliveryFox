<?php
namespace MyApp\Web\Checkout;

use MyApp\Web\Html\Html;
use MyApp\Web\Checkout\OrderStatusView;

class OrderStatus
{
	function Index($r)
	{
		Html::Header('Order status', 'Order status', 'order status');

		OrderStatusView::Show();

		Html::Footer();
	}
}
?>