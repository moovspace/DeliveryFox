<?php
namespace MyApp\Web\AdminPanel\View;

use Exception;
use MyApp\App\Component;
use MyApp\App\Menu\Menu;
use MyApp\App\Translate\Trans;
use MyApp\Web\AdminPanel\LeftMenu;
use MyApp\Web\AdminPanel\User;
use MyApp\Web\AdminPanel\TopMenu;
use MyApp\Web\AdminPanel\Footer;
use MyApp\App\Email\SendNewsletter;

class NewsletterView extends Component
{
	static public $ErrorUpdate = 0;

	static function Menu()
	{
		$menu = new Menu('/panel/newsletter', 'Newsletter', 'Newsletter', '<i class="fas fa-envelope"></i>', '<i class="fas fa-envelope-open"></i>');
		// $menu->AddLink('/panel/profil', 'Profil', 'User profile');
		return $menu;
	}

	static function SendNews()
	{
		if(!empty($_POST['news']))
		{
			if(!empty($_FILES['file']['tmp_name']) && !empty($_POST['title']))
			{
				try
				{
					return SendNewsletter::Send($_POST['title'], $_FILES['file']['tmp_name'], 100);
				}
				catch(Exception $e)
				{
					return 0;
				}
			}
			return 0;
		}
	}

	static function Data($arr = null)
	{
		try
		{
			$user = new User();

			// If not admin
			if($user->Role() != 'admin')
			{
				throw new Exception("Error user privileges", 666);
			}

			// Send newsletter
			$user->ErrorUpdate = self::SendNews();
		}
		catch(Exception $e)
		{
			if($e->getCode() == 666){
				// Error user
				header('Location: /logout');
			}else{
				echo $e->getMessage();
			}
		}

		return  $user;
	}

	static function Show($arr = null)
	{
		$t = new Trans('/src/Web/AdminPanel/Lang', 'pl');

		// Get data
		$user = self::Data();

		// Get user data
		$arr['user'] = $user->GetUser();
		$arr['user_info'] = $user->GetUserInfo();
		$arr['error'] = '';
		$arr['trans'] = $t;

		if(!empty($_POST))
		{
			if($user->ErrorUpdate == 1){
				$arr['error'] = '<span class="green"> '.$t->Get('SEND_OK').' </span>';
			}else{
				$arr['error'] = '<span class="red"> '.$t->Get('SEND_ERR').' </span>';
			}
		}

		// Import component
		$menu['top'] = TopMenu::Show($arr);
		$menu['left'] = LeftMenu::Show();
		$menu['footer'] = Footer::Show($arr);;

		// Retuen html
		return self::Html($arr, $menu);
	}

	static function Html($arr = null, $html = '')
	{
		return '
		'.$html['top'].'
		<div id="box">
			'.$html['left'].'
			<div id="box-right">
				<h1> Newsletter </h1>
				<error id="error">
					' . $arr['error'] . '
				</error>
				<div class="box-wrap">
					<h3> '.$arr['trans']->Get('LB_NEWS').' </h3>
					<form method="post" enctype="multipart/form-data">
						<div class="w-50">
							<label> '.$arr['trans']->Get('LB_TITLE').' </label>
							<input type="text" name="title">
						</div>
						<div class="w-50">
							<label> '.$arr['trans']->Get('LB_HTML').' </label>
							<input type="file" name="file" accept=".html, .htm">
						</div>
						<line></line>
						<input type="submit" name="news" value="'.$arr['trans']->Get('SEND').'" class="btn float-right">
					</form>
					<a href="/src/Api/cron/send-newsletter.php" target="_blank" id="send-newsletter"> Test cron send file </a>
				</div>
			</div>
		</div>
		'.$html['footer'].'
		';
	}

	static function Title()
	{
		return 'Profil';
	}

	static function Description()
	{
		return 'Profil settings.';
	}

	static function Keywords()
	{
		return 'profil, settings';
	}

	static function Head()
	{
		return [
			'<link rel="stylesheet" href="/src/Web/AdminPanel/panel.css">',
			'<script defer src="/src/Web/AdminPanel/panel.js"></script>'
		];
	}
}
?>