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

class ProductView extends Component
{
	static public $ErrorUpdate = 0;

	static function Menu()
	{
		$menu = new Menu('/panel/attributes', 'Attributes', 'Product attributes', '<i class="fas fa-cog"></i>', '<i class="fas fa-cog"></i>');
		// $menu->AddLink('/panel/profil', 'Profil', 'User profile');
		return $menu;
	}

	static function isImage()
	{
		$mime = $_FILES['file']['type'];
		$allowed = array("image/jpeg");
		return in_array($mime, $allowed);
	}

	static function UpdateAccount($user)
	{
		if(!empty($_POST['account']))
		{
			if(!empty($_FILES['file']['tmp_name']))
			{
				// Upload avatar
				if(self::isImage()){
					move_uploaded_file($_FILES['file']['tmp_name'],'media/avatar/'.$user->Id().'.jpg');
				}else{
					return -3;
				}
			}

			try
			{
				foreach($_POST as $k => $v)
				{
					// Submit name: account
					if($k != 'account')
					{
						$user->SetUser($k, $v);
					}
				}

				// Update user db
				return $user->SaveUser();
			}
			catch(Exception $e)
			{
				if ($e->errorInfo[1] == 1062) {
					return -2; // username exist
				}
				return -1;
			}

		}

	}

	static function Data($arr = null)
	{
		try
		{
			$user = new User();

			// If not admin
			if($user->Role() != 'admin' && $user->Role() != 'worker' && $user->Role() != 'driver')
			{
				throw new Exception("Error user privileges", 666);
			}

			// Update database
			$user->ErrorUpdate = self::UpdateAccount($user);
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
			if($user->ErrorUpdate == 0){
				$arr['error'] = '<span class="green"> '.$t->Get('ERR_NOTHING').' </span>';
			}else if($user->ErrorUpdate == 1){
				$arr['error'] = '<span class="green"> '.$t->Get('UPDATED').' </span>';
			}else if($user->ErrorUpdate == -3){
				$arr['error'] = '<span class="red"> '.$t->Get('ERR_IMAGE').' </span>';
			}else if($user->ErrorUpdate == -2){
				$arr['error'] = '<span class="red"> '.$t->Get('ERR_USERNAME').' </span>';
			}else if($user->ErrorUpdate < 0){
				$arr['error'] = '<span class="red"> '.$t->Get('ERR_UPDATE').' </span>';
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
				<h1> '.$arr['trans']->Get('PR_SETTINGS').'  </h1>
				<error id="error">
					' . $arr['error'] . '
				</error>
				<div class="box-wrap">

					<div id="box-fixed" class="animated fadeIn">
						<h3 onclick="Close(this)">Add attribute <i class="fas fa-times close"></i> </h3>
						<form method="POST">
							<input type="text" name="attr" placeholder="e.g. Size or Sauce">
							<input type="submit" name="add" value="Add" class="btn float-right">
						</form>
					</div>

					<h3> '.$arr['trans']->Get('PR_ACCOUNT').'  <a id="btn-add-attribute" onclick="OpenAddAttributes(this)"> Attribute <i class="fas fa-plus"></i> </a> </h3>

					<ul class="header">
						<li>
							<div>Id</div><div>Name</div><div>Actions</div>
						</li>
					</ul>
					<ul>
						<li>
							<div>1</div>
							<div>Rozmiar</div>
							<div>
								<a class="btn-small-li"> <i class="fas fa-edit"></i> </a>
								<a class="btn-small-li"> <i class="fas fa-trash"></i> </a>
							</div>
						</li>
						<li>
							<div>2</div>
							<div>Sos</div>
							<div>
								<a class="btn-small-li"> <i class="fas fa-edit"></i> </a>
								<a class="btn-small-li"> <i class="fas fa-trash"></i> </a>
							</div>
						</li>

					</ul>

					<div class="pages">
						<a href="?page=1"> <i class="fas fa-chevron-left"></i> </a>
						<a href="?page=2"> 2 / 50 </a>
						<a href="?page=3"> <i class="fas fa-chevron-right"></i> </a>
					</div>

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