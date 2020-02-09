<?php
namespace MyApp\Web\Home;

use MyApp\Web\Html\Html;
use MyApp\Web\Home\View;
use MyApp\Component\Auth\ViewLogin;

class Homepage
{
	function Index($r)
	{
		Html::Header('Hello from homepage!', 'Homepage description', 'home page');

		View::Show();

		Html::Footer();
	}
}
?>