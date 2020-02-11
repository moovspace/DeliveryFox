<?php
namespace MyApp\Web\AdminPanel\View;

use Exception;
use MyApp\App\Component;
use MyApp\Web\AdminPanel\LeftMenu;
use MyApp\Web\AdminPanel\User;
use MyApp\App\Menu\Menu;
use MyApp\Web\AdminPanel\TopMenu;

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
		// Get data
		$user = self::Data();

		// Get user data
		$arr['user'] = $user->GetUser();
		$arr['user_info'] = $user->GetUserInfo();
		$arr['error'] = '';

		if(!empty($_POST))
		{
			if($user->ErrorUpdate == 0){
				$arr['error'] = '<span class="green">Nothing to update.</span>';
			}else if($user->ErrorUpdate == 1){
				$arr['error'] = '<span class="green">Profil has been updated.</span>';
			}else if($user->ErrorUpdate == -3){
				$arr['error'] = '<span class="red">Error image file (Only .jpeg, .jpg files).</span>';
			}else if($user->ErrorUpdate == -2){
				$arr['error'] = '<span class="red">This username is aledy taken.</span>';
			}else if($user->ErrorUpdate < 0){
				$arr['error'] = '<span class="red">Can not update profil.</span>';
			}
		}

		// Import component
		$menu['top'] = TopMenu::Show($arr);
		$menu['left'] = LeftMenu::Show();

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
				<h1>Profil settings</h1>
				<error id="error">
					' . $arr['error'] . '
				</error>
				<div class="box-wrap">
					<h3>Account</h3>
					<form method="post" enctype="multipart/form-data">
						<div class="w-50">
							<label>Username</label>
							<input type="text" name="username" placeholder="Username" value="' . $arr['user']['username'] . '">
						</div>
						<div class="w-50">
							<label>Email <small>(disabled)</small> </label>
							<input type="text" name="email" placeholder="your@email.address" disabled value="' . $arr['user']['email'] . '">
						</div>
						<div class="w-50">
							<label>Mobile</label>
							<input type="text" name="mobile" placeholder="+48 000 000 000" value="' . $arr['user']['mobile'] . '">
						</div>
						<div class="w-50">
							<label>Avatar (Extension: .jpg, .jpeg)</label>
							<input type="file" name="file" placeholder="Avatar">
						</div>
						<line></line>
						<input type="submit" name="account" value="Save" class="btn float-right">
					</form>
				</div>

				<div class="box-wrap">
					<h3>About user</h3>
					<form method="post">
						<div class="w-50">
							<label>Firstname</label>
							<input type="text" name="firstname" placeholder="First Name" value="' . $arr['user_info']['firstname'] . '">
						</div>
						<div class="w-50">
							<label>Lastname</label>
							<input type="text" name="lastname" placeholder="Last Name" value="' . $arr['user_info']['lastname'] . '">
						</div>
						<div class="w-50">
							<label>Email</label>
							<input type="text" name="mail" placeholder="your@email.address" value="' . $arr['user_info']['mail'] . '">
						</div>
						<div class="w-50">
							<label>Mobile</label>
							<input type="text" name="mobile" placeholder="+48 000 000 000" value="' . $arr['user_info']['mobile'] . '">
						</div>
						<div class="w-50">
							<label>Longtitude</label>
							<input type="text" name="lng" placeholder="21.000000" value="' . $arr['user_info']['lng'] . '">
						</div>
						<div class="w-50">
							<label>Latitude</label>
							<input type="text" name="lat" placeholder="52.000000" value="' . $arr['user_info']['lat'] . '">
						</div>
						<div class="w-50">
							<label>About</label>
							<textarea name="about" placeholder="Write something">' . $arr['user_info']['about'] . '</textarea>
						</div>
						<line></line>
						<input type="submit" name="aboutinfo" value="Save" class="btn float-right">
					</form>
				</div>

				<div class="box-wrap">
					<h3>Delivery address</h3>
					<form method="post">
						<div class="w-50">
							<label>City</label>
							<input type="text" name="city" placeholder="Warsaw" value="' . $arr['user_info']['city'] . '">
						</div>
						<div class="w-50">
							<label>Postal</label>
							<input type="text" name="zip" placeholder="00-000" value="' . $arr['user_info']['zip'] . '">
						</div>
						<div class="w-50">
							<label>Address</label>
							<input type="text" name="address" placeholder="Złota 13/9" value="' . $arr['user_info']['address'] . '">
						</div>
						<div class="w-50">
							<label>Country</label>
							<input type="text" name="country" placeholder="Polska" value="' . $arr['user_info']['country'] . '">
							<!--
							<select>
								<option value="Polska">Polska</option>
							</select>
							-->
						</div>
						<line></line>
						<input type="submit" name="delivery" value="Save" class="btn float-right">
					</form>
				</div>
			</div>
		</div>
		';
	}

	static function Title()
	{
		return 'Page title here. Title() method.';
	}

	static function Description()
	{
		return 'Page description text. Description() method.';
	}

	static function Keywords()
	{
		return 'Page keywords. Keywords() method';
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