<?php
namespace MyApp\Web\AdminPanel;

class TopMenu
{
	static function Show($arr = null)
	{
		return '
		<div class="box-top">
			<img src="/media/img/logo.png" alt="logo" class="logo" onerror="logoError(this)">
			<a href="/logout"> <i class="fas fa-door-open" id="exit" title="Logout"></i> </a>
			<div class="avatar">
				<img src="/media/avatar/' . $arr['user']['id'] . '.jpg" alt="User image" onerror="imgError(this)">
			</div>
			<div class="hello"> Hi, ' . $arr['user']['username'] . ' </div>
		</div>
		';
	}
}
?>