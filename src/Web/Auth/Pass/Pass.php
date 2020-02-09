<?php
use MyApp\Web\Html\Html;
use MyApp\Web\Auth\Pass\View;

class Pass
{
	function Index($r)
	{
		Html::Header('Nie pamiętasz hasła?', 'Odzyskaj hasło w kilka chwil.', 'zaloguj, login', View::Head());

		View::Show();

		Html::Footer();
	}
}
?>