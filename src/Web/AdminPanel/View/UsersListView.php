<?php
namespace MyApp\Web\AdminPanel\View;

use Exception;
use PhpApix\Mysql\Db;
use MyApp\App\Component;
use MyApp\App\Menu\Menu;
use MyApp\App\Translate\Trans;
use MyApp\Web\AdminPanel\LeftMenu;
use MyApp\Web\AdminPanel\User;
use MyApp\Web\AdminPanel\TopMenu;
use MyApp\Web\AdminPanel\Footer;
use MyApp\Web\AdminPanel\UsersListList;

class UsersListView extends Component
{
	static public $ErrorUpdate = 0;

	static function Menu()
	{
		$t = new Trans('/src/Web/AdminPanel/Lang', 'pl');
		$t_attr = $t->Get('A_LIST_USERS');
		$t_title = $t->Get('A_TITLE_USERS');
		$t_attr1 = $t->Get('A_CLIENT');
		$t_title1 = $t->Get('A_CLIENT_TITLE');
		$menu = new Menu('/panel/users', $t_attr, $t_title, '<i class="fas fa-users"></i>', '<i class="fas fa-users"></i>');
		if(parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH) == '/panel/client')
		{
			$menu->AddLink('/panel/client', $t_attr1, $t_title1, '<i class="fas fa-user"></i>', '<i class="fas fa-user"></i>');
		}
		return $menu;
	}

	static function GetAttributes()
	{
		if(empty($_GET['page']) || $_GET['page'] < 1){
			$_GET['page'] = 1;
		}
		$page = (int) $_GET['page'];

		if(empty($_GET['perpage']) || $_GET['perpage'] < 1){
			$_GET['perpage'] = 10;
		}
		$perpage = (int) $_GET['perpage'];

		$offset = $perpage * ($page - 1);
		if($offset < 0){
			$offset = 0;
		}

		try
		{
			$db = Db::getInstance();
			$r = $db->Pdo->prepare("SELECT id, username, email, mobile, role, time, active FROM user ORDER BY id DESC LIMIT :offset,:perpage");
			$r->execute([':offset' => $offset, ':perpage' => $perpage]);
			return $r->fetchAll();
		}
		catch(Exception $e)
		{
			return [];
		}
	}

	static function GetAttributesMaxRows()
	{
		try
		{
			$db = Db::getInstance();
			$r = $db->Pdo->prepare("SELECT COUNT(*) as cnt FROM attr");
			$r->execute();
			return $r->fetchAll()[0]['cnt'];
		}
		catch(Exception $e)
		{
			return 1;
		}
	}

	static function DelAttribute()
	{
		if(!empty($_GET['delete']))
		{
			try
			{
				$id = (int) $_GET['delete'];

				$db = Db::getInstance();
				$r = $db->Pdo->prepare("DELETE FROM user WHERE id = $id");
				$r->execute();
				return $r->rowCount();
			}
			catch(Exception $e)
			{
				return -1; // error
			}
		}
	}

	static function BanAttribute()
	{
		if(!empty($_GET['ban']))
		{
			try
			{
				$id = (int) $_GET['ban'];

				$db = Db::getInstance();
				$r = $db->Pdo->prepare("UPDATE user SET active = IF(active = 1, 0, 1) WHERE id = $id");
				$r->execute();
				return $r->rowCount();

			}
			catch(Exception $e)
			{
				return -1; // error
			}
		}
	}

	static function CreateUser()
	{
		if(!empty($_POST['add']))
		{
			try
			{
				if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && !empty($_POST['username']) && !empty($_POST['pass']))
				{
					$db = Db::getInstance();
					$r = $db->Pdo->prepare("INSERT INTO user(username,email,pass,role,active,apikey) VALUES(:username, :email, MD5(:pass), :role, :active, UUID())");
					$r->execute([':username' => $_POST['username'], ':email' => $_POST['email'], ':pass' => $_POST['pass'], ':role' => $_POST['role'], ':active' => 1]);
					return $r->rowCount();
				}
			}
			catch(Exception $e)
			{
				echo $e->getMessage();
				return -1; // error
			}
		}
	}

	static function Data($arr = null)
	{
		try
		{
			$user = new User(); // Is User logedd

			// If not admin
			if($user->Role() != 'admin')
			{
				throw new Exception("Error user privileges", 666);
			}

			$user->ErrorUpdate = 0;

			if(!empty($_GET['delete'])){
				$user->ErrorUpdate = self::DelAttribute();
			}

			if(!empty($_GET['ban'])){
				$user->ErrorUpdate = self::BanAttribute();
			}

			if(!empty($_POST['add'])){
				$user->ErrorUpdate = self::CreateUser();
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

		// Get user data
		$arr['user'] = $user->GetUser();
		$arr['user_info'] = $user->GetUserInfo();
		$arr['error'] = '';
		$arr['trans'] = $t;

		if(!empty($_POST) || !empty($_GET['delete']) || !empty($_GET['ban']))
		{
			if($user->ErrorUpdate == 0){
				$arr['error'] = '<span class="green"> '.$t->Get('A_ERR_NOTHING').' </span>';
			}else {
				$arr['error'] = '<span class="green"> '.$t->Get('A_UPDATED').' </span>';
			}
		}

		// Import component
		$menu['top'] = TopMenu::Show($arr);
		$menu['left'] = LeftMenu::Show();
		$menu['footer'] = Footer::Show($arr);

		// Draw list
		$a1 = $t->Get('A_L_ID');
		$a2 = $t->Get('U_USER');
		$a22 = $t->Get('U_EMAIL');
		$a3 = $t->Get('U_MOBILE');
		$a4 = $t->Get('U_ROLE');
		$a5 = $t->Get('U_TIME');
		$a6 = $t->Get('U_ACTIVE');
		$a10 = $t->Get('A_L_ACTION');
		$title = [$a1, $a2, $a22, $a3, $a4, $a5, $a6, $a10];
		// $title = ['Id','Name', 'Actions'];
		$rows =  self::GetAttributes();
		$maxrows =  self::GetAttributesMaxRows();
		// print_r($maxrows);
		// print_r($rows);
		$menu['list'] = UsersListList::Get($title, $rows, (int) $_GET['page'], $maxrows);

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
				<h1> '.$arr['trans']->Get('A_TITLE_USERS').'  </h1>
				<error id="error">
					' . $arr['error'] . '
				</error>
				<div class="box-wrap">

					<h3> '.$arr['trans']->Get('A_LIST_USERS').'  </h3>

					'.$html['list'].'

				</div>

				<h1> '.$arr['trans']->Get('A_ADD_USER').'  </h1>
				<div class="box-wrap">
					<form method="POST" action ="">
						<div class="w-50">
							<label>'.$arr['trans']->Get('USERNAME').' </label>
							<input type="text" name="username">
						</div>
						<div class="w-50">
							<label>'.$arr['trans']->Get('EMAIL').' </label>
							<input type="text" name="email">
						</div>
						<div class="w-50">
							<label>'.$arr['trans']->Get('PASS').' </label>
							<input type="text" name="pass">
						</div>
						<div class="w-50">
							<label>'.$arr['trans']->Get('ROLE').' </label>
							<select name="role">
								<option value="user"> User </option>
								<option value="worker"> Worker </option>
								<option value="driver"> Driver </option>
								<option value="admin"> Admin </option>
							</select>
						</div>
						<input type="submit" name="add" class="btn float-right" value="'.$arr['trans']->Get('A_ADD').'">
					</form>
				</div>
			</div>
		</div>
		'.$html['footer'].'
		';
	}

	static function Title()
	{
		return 'Clients';
	}

	static function Description()
	{
		return 'Clients list.';
	}

	static function Keywords()
	{
		return 'clients';
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