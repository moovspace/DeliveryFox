<?php
namespace MyApp\Web\Auth\Confirm;

use MyApp\Web\Html\Html;
use MyApp\Web\Auth\Confirm\View;

class Confirm
{
	function Index($r)
	{
		Html::Header('Confirm your email', 'Email confirmation page.', 'zaloguj, login', View::Head());

		View::Show();

		Html::Footer();
	}
}
?>