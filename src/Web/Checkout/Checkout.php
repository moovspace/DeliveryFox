<?php
namespace MyApp\Web\Checkout;

use MyApp\Web\Html\Html;
use MyApp\Web\Checkout\View;

class Checkout
{
	function Index($r)
	{
		Html::Header('Checkout', 'Checkout', 'checkout');

		View::Show();

		Html::Footer();
	}
}
?>