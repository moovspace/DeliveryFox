<?php
namespace MyApp\Web\AdminPanel;
use MyApp\Web\Html\Html;
use MyApp\Web\AdminPanel\View\OrderUserView;

class OrderUser
{
	function Index($r)
	{
		Html::Header(OrderUserView::Title(), OrderUserView::Description(), OrderUserView::Keywords(), OrderUserView::Head());

		// Attr list
		echo OrderUserView::Show();

		Html::Footer();
	}
}
?>