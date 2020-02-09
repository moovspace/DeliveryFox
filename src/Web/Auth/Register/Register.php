<?php
use MyApp\Web\Html\Html;
use MyApp\Web\Auth\Register\View;

class Register
{
	function Index($r)
	{
		Html::Header('Zarejestruj się', 'Nie masz konta, załóż już dziś.', 'zaloguj, login', View::Head());

		View::Show();

		Html::Footer();
	}
}
?>