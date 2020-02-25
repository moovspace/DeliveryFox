<?php
namespace MyApp\Web\Category;

use MyApp\Web\Html\Html;
use MyApp\Web\Category\View;

class Category
{
	function Index($r)
	{
		Html::Header('Order online', 'Order online', 'order online');

		View::Show();

		Html::Footer();
	}
}
?>