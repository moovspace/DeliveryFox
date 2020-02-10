<?php
namespace MyApp\Web\Auth\Html;

class TopMenu
{
	static function Show($arr)
	{
		return '
		<div class="box-top">
			<img src="/src/Web/Auth/logo.png" alt="logo" class="logo">
			<a href="/login" class="button-signin" title="' . $arr->btn . '">' . $arr->btn . '</a>
		</div>
		';
	}
}
?>