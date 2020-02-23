<?php
namespace MyApp\Web\Auth\Html;

class ChangeLang
{
	static function Show($arr)
	{
		return '
		<div id="lang">
			<a data-lang="pl" class="lang" onclick="Lang(this);"> PL </a>
			<a data-lang="en" class="lang" onclick="Lang(this);"> EN </a>
		</div>
		';
	}
}
?>