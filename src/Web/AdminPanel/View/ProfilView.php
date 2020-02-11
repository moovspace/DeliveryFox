<?php
namespace MyApp\Web\AdminPanel\View;

use Exception;
use MyApp\App\Component;
use MyApp\Web\AdminPanel\LeftMenu;
use MyApp\Web\AdminPanel\User;
use MyApp\App\Menu\Menu;
use MyApp\Web\AdminPanel\TopMenu;
use MyApp\App\Translate\Trans;

class ProfilView extends Component
{
	static public $ErrorUpdate = 0;

	static function Menu()
	{
		$menu = new Menu('/panel', 'Profil', 'User profil', '<i class="fas fa-home"></i>', '<i class="fas fa-home"></i>');
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

		if(!empty($_POST['aboutinfo']))
		{
			try
			{
				foreach($_POST as $k => $v)
				{
					// Submit name: account
					if($k != 'aboutinfo')
					{
						$user->SetUserInfo($k, $v);
					}
				}

				// Update user db
				return $user->SaveUserInfo();
			}
			catch(Exception $e)
			{
				if ($e->errorInfo[1] == 1062) {
					return -2; // username exist
				}
				return -1;
			}
		}

		if(!empty($_POST['delivery']))
		{
			try
			{
				foreach($_POST as $k => $v)
				{
					// Submit name: account
					if($k != 'delivery')
					{
						$user->SetUserInfo($k, $v);
					}
				}

				// Update user db
				return $user->SaveUserInfo();
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
		$menu['footer'] = '';

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
				<h1> '.$arr['trans']->Get('PR_SETTINGS').' </h1>
				<error id="error">
					' . $arr['error'] . '
				</error>
				<div class="box-wrap">
					<h3> '.$arr['trans']->Get('PR_ACCOUNT').' </h3>
					<form method="post" enctype="multipart/form-data">
						<div class="w-50">
							<label> '.$arr['trans']->Get('LB_USER').' </label>
							<input type="text" name="username" placeholder="'.$arr['trans']->Get('EG').' Username" value="' . $arr['user']['username'] . '">
						</div>
						<div class="w-50">
							<label> '.$arr['trans']->Get('LB_EMAIL').' <small>(disabled)</small> </label>
							<input type="text" name="email" placeholder="'.$arr['trans']->Get('EG').' your@email.address" disabled value="' . $arr['user']['email'] . '">
						</div>
						<div class="w-50">
							<label> '.$arr['trans']->Get('LB_MOBILE').' </label>
							<input type="text" name="mobile" placeholder="'.$arr['trans']->Get('EG').' +48 000 000 000" value="' . $arr['user']['mobile'] . '">
						</div>
						<div class="w-50">
							<label> '.$arr['trans']->Get('LB_AVATAR').' </label>
							<input type="file" name="file" placeholder="'.$arr['trans']->Get('EG').' Avatar">
						</div>
						<line></line>
						<input type="submit" name="account" value="'.$arr['trans']->Get('SAVE').'" class="btn float-right">
					</form>
				</div>

				<div class="box-wrap">
					<h3> '.$arr['trans']->Get('PR_ABOUTUSER').' </h3>
					<form method="post">
						<div class="w-50">
							<label> '.$arr['trans']->Get('LB_FIRST').' </label>
							<input type="text" name="firstname" placeholder="'.$arr['trans']->Get('EG').' Alicja" value="' . $arr['user_info']['firstname'] . '">
						</div>
						<div class="w-50">
							<label> '.$arr['trans']->Get('LB_LAST').' </label>
							<input type="text" name="lastname" placeholder="'.$arr['trans']->Get('EG').' Piekna" value="' . $arr['user_info']['lastname'] . '">
						</div>
						<div class="w-50">
							<label> '.$arr['trans']->Get('LB_EMAIL').' </label>
							<input type="text" name="mail" placeholder="'.$arr['trans']->Get('EG').' your@email.address" value="' . $arr['user_info']['mail'] . '">
						</div>
						<div class="w-50">
							<label> '.$arr['trans']->Get('LB_MOBILE').' </label>
							<input type="text" name="mobile" placeholder="'.$arr['trans']->Get('EG').' +48 000 000 000" value="' . $arr['user_info']['mobile'] . '">
						</div>
						<div class="w-50">
							<label> '.$arr['trans']->Get('LB_LNG').' </label>
							<input type="text" name="lng" placeholder="'.$arr['trans']->Get('EG').' 21.000000" value="' . $arr['user_info']['lng'] . '">
						</div>
						<div class="w-50">
							<label> '.$arr['trans']->Get('LB_LAT').' </label>
							<input type="text" name="lat" placeholder="'.$arr['trans']->Get('EG').' 52.000000" value="' . $arr['user_info']['lat'] . '">
						</div>
						<div class="w-50">
							<label>'.$arr['trans']->Get('LB_ABOUT').' </label>
							<textarea name="about" placeholder="'.$arr['trans']->Get('EG').' Wspaniały opis.">' . $arr['user_info']['about'] . '</textarea>
						</div>
						<line></line>
						<input type="submit" name="aboutinfo" value="'.$arr['trans']->Get('SAVE').'" class="btn float-right">
					</form>
				</div>

				<div class="box-wrap">
					<h3> '.$arr['trans']->Get('PR_DELIVERY').' </h3>
					<form method="post">
						<div class="w-50">
							<label> '.$arr['trans']->Get('LB_CITY').' </label>
							<input type="text" name="city" placeholder="'.$arr['trans']->Get('EG').' Warsaw" value="' . $arr['user_info']['city'] . '">
						</div>
						<div class="w-50">
							<label> '.$arr['trans']->Get('LB_ZIP').' </label>
							<input type="text" name="zip" placeholder="'.$arr['trans']->Get('EG').' 00-000" value="' . $arr['user_info']['zip'] . '">
						</div>
						<div class="w-50">
							<label> '.$arr['trans']->Get('LB_ADDR').' </label>
							<input type="text" name="address" placeholder="'.$arr['trans']->Get('EG').' Złota 13/9" value="' . $arr['user_info']['address'] . '">
						</div>
						<div class="w-50">
							<label> '.$arr['trans']->Get('LB_COUNTRY').' </label>
							<input type="text" name="country" placeholder="'.$arr['trans']->Get('EG').' Polska" value="' . $arr['user_info']['country'] . '">
							<!--
							<select>
								<option value="Polska">Polska</option>
							</select>
							-->
						</div>
						<line></line>
						<input type="submit" name="delivery" value="'.$arr['trans']->Get('SAVE').'" class="btn float-right">
					</form>
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