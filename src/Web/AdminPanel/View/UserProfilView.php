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
use PhpApix\Mysql\Db;

error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);

class UserProfilView extends Component
{
	static public $ErrorUpdate = 0;

	static function GetUserOrdersQuantity($id = 0)
	{
		$db = Db::getInstance();
		$r = $db->Pdo->prepare("SELECT COUNT(*) as cnt FROM orders WHERE rf_user = :id");
		$r->execute([':id' => $id]);
		$rows = $r->fetchAll();

		if(!empty($rows))
		{
			// Update variable
			return $rows[0]['cnt'];
		}
		return 0;
	}

	static function GetUser($id = 0)
	{
		$db = Db::getInstance();
		$r = $db->Pdo->prepare("SELECT * FROM user WHERE id = :id");
		$r->execute([':id' => $id]);
		$rows = $r->fetchAll();

		if(!empty($rows))
		{
			// Remove password hash
			unset($rows[0]['pass']);
			// Update variable
			return $rows[0];
		}
		return [];
	}

	static function GetUserInfo($id = 0)
	{
		$db = Db::getInstance();
		$r = $db->Pdo->prepare("SELECT * FROM user_info WHERE rf_user = :id");
		$r->execute([':id' => $id]);
		$rows = $r->fetchAll();

		if(!empty($rows))
		{
			return $rows[0];
		}
		return [];
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

		if(!empty($_GET['id'])){
			$uid = $_GET['id'];
		}else{
			header('Location: /panel/users');
		}

		// Get user data
		$arr['user'] = self::GetUser($uid);
		$arr['user_info'] = self::GetUserInfo($uid);
		$arr['user_qty'] = self::GetUserOrdersQuantity($uid);
		$arr['error'] = '';
		$arr['trans'] = $t;

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
				<h1> '.$arr['trans']->Get('PR_SETTINGS').' </h1>
				<h4>Orders/Zamówień: '.$arr['user_qty'].' </h4>
				<error id="error">
					' . $arr['error'] . '
				</error>
				<div class="box-wrap">
					<h3> '.$arr['trans']->Get('PR_ACCOUNT').' </h3>
					<form method="post" enctype="multipart/form-data">
						<div class="w-50">
							<label> '.$arr['trans']->Get('LB_USER').'</label>
							<input disabled type="text" name="username" placeholder="'.$arr['trans']->Get('EG').' Username" value="' . $arr['user']['username'] . '">
						</div>
						<div class="w-50">
							<label> '.$arr['trans']->Get('LB_EMAIL').' <small>(disabled)</small> </label>
							<input disabled type="text" name="email" placeholder="'.$arr['trans']->Get('EG').' your@email.address" disabled value="' . $arr['user']['email'] . '">
						</div>
						<div class="w-50">
							<label> '.$arr['trans']->Get('LB_MOBILE').' </label>
							<input disabled type="text" name="mobile" placeholder="'.$arr['trans']->Get('EG').' +48 000 000 000" value="' . $arr['user']['mobile'] . '">
						</div>
					</form>
				</div>

				<div class="box-wrap">
					<h3> '.$arr['trans']->Get('PR_ABOUTUSER').' </h3>
					<form method="post">
						<div class="w-50">
							<label> '.$arr['trans']->Get('LB_FIRST').' </label>
							<input disabled type="text" name="firstname" placeholder="'.$arr['trans']->Get('EG').' Alicja" value="' . $arr['user_info']['firstname'] . '">
						</div>
						<div class="w-50">
							<label> '.$arr['trans']->Get('LB_LAST').' </label>
							<input disabled type="text" name="lastname" placeholder="'.$arr['trans']->Get('EG').' Piekna" value="' . $arr['user_info']['lastname'] . '">
						</div>
						<div class="w-50">
							<label> '.$arr['trans']->Get('LB_EMAIL').' </label>
							<input disabled type="text" name="mail" placeholder="'.$arr['trans']->Get('EG').' your@email.address" value="' . $arr['user_info']['mail'] . '">
						</div>
						<div class="w-50">
							<label> '.$arr['trans']->Get('LB_MOBILE').' </label>
							<input disabled type="text" name="mobile" placeholder="'.$arr['trans']->Get('EG').' +48 000 000 000" value="' . $arr['user_info']['mobile'] . '">
						</div>
						<div class="w-50">
							<label> '.$arr['trans']->Get('LB_LNG').' </label>
							<input disabled type="text" name="lng" placeholder="'.$arr['trans']->Get('EG').' 21.000000" value="' . $arr['user_info']['lng'] . '">
						</div>
						<div class="w-50">
							<label> '.$arr['trans']->Get('LB_LAT').' </label>
							<input disabled type="text" name="lat" placeholder="'.$arr['trans']->Get('EG').' 52.000000" value="' . $arr['user_info']['lat'] . '">
						</div>
						<div class="w-50">
							<label>'.$arr['trans']->Get('LB_ABOUT').' </label>
							<textarea disabled name="about" placeholder="'.$arr['trans']->Get('EG').' Wspaniały opis.">' . $arr['user_info']['about'] . '</textarea>
						</div>
					</form>
				</div>

				<div class="box-wrap">
					<h3> '.$arr['trans']->Get('PR_DELIVERY').' </h3>
					<form method="post">
						<div class="w-50">
							<label> '.$arr['trans']->Get('LB_CITY').' </label>
							<input disabled type="text" name="city" placeholder="'.$arr['trans']->Get('EG').' Warsaw" value="' . $arr['user_info']['city'] . '">
						</div>
						<div class="w-50">
							<label> '.$arr['trans']->Get('LB_ZIP').' </label>
							<input disabled type="text" name="zip" placeholder="'.$arr['trans']->Get('EG').' 00-000" value="' . $arr['user_info']['zip'] . '">
						</div>
						<div class="w-50">
							<label> '.$arr['trans']->Get('LB_ADDR').' </label>
							<input disabled type="text" name="address" placeholder="'.$arr['trans']->Get('EG').' Złota 13/9" value="' . $arr['user_info']['address'] . '">
						</div>
						<div class="w-50">
							<label> '.$arr['trans']->Get('LB_COUNTRY').' </label>
							<input disabled type="text" name="country" placeholder="'.$arr['trans']->Get('EG').' Polska" value="' . $arr['user_info']['country'] . '">
							<!--
							<select>
								<option value="Polska">Polska</option>
							</select>
							-->
						</div>
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