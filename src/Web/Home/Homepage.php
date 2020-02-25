<?php
namespace MyApp\Web\Home;

use MyApp\Web\Html\Html;
use MyApp\Web\Home\View;
// use MyApp\Component\Auth\ViewLogin;

class Homepage
{
	function Index($r)
	{
		Html::Header('Order online', 'Order online', 'order online');

		View::Show();

		Html::Footer();
	}

	static function MenuLinks()
	{
		$arr = [];
		$arr[0] = ['name' => 'homepage', 'title' => 'Main page', 'href' => '/'] ;
		$arr[1] = ['name' => 'login', 'title' => 'Login page', 'href' => '/login'] ;
		return $arr;
	}
}
?>