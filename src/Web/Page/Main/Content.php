<?php
namespace MyApp\Web\Page\Main;

class Content
{
	static function Show(array $arr)
	{
		$html = '';
		foreach($arr as $v)
		{
			$html = $v;
		}
		return '<div class="content">'.$html.'</div>';
	}

	static function Head()
	{
		return '
		<link rel="stylesheet" href="/src/Web/Page/Main/content.css">
		<script defer src="/src/Web/Page/Main/content.js"></script>
		';
	}
}