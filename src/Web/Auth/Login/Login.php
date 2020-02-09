<?php
namespace MyApp\Web\Auth\Login;

use MyApp\Web\Html\Html;
use MyApp\Web\Auth\Login\View;

class Login
{
	function Index($r)
	{
		Html::Header('Zaloguj się', 'Zaloguj się do naszego portalu już dziś.', 'zaloguj, login', View::Head());

		View::Show();

		Html::Footer();
	}
}
?>