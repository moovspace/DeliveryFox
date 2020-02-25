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
use MyApp\Web\AdminPanel\OrdersList;

class OrdersView extends Component
{
	static public $ErrorUpdate = 0;

	static function Menu()
	{
		$t = new Trans('/src/Web/AdminPanel/Lang', 'pl');

		$t_name = $t->Get('OR_ORDERS');
		$t_title = $t->Get('OR_ORDERS');
		$t_edit = $t->Get('OR_ORDER');
		$t_edit_title = $t->Get('OR_ORDER');
		$menu = new Menu('/panel/orders', $t_name, $t_title, '<i class="fas fa-truck-monster"></i>', '<i class="fas fa-truck-monster"></i>');

		if(parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH) == '/panel/order')
		{
			$menu->AddLink('/panel/order', $t_edit, $t_edit_title, '<i class="fas fa-boxes"></i>', '<i class="fas fa-boxes"></i>');
		}
		return $menu;
	}

	static function GetProducts()
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

		// Search
		$q = '';
		$sql = '';
		if(!empty($_GET['q']))
		{
			$q = htmlentities($_GET['q'], ENT_QUOTES, "UTF-8");
			$sql = " AND CONCAT_WS(' ', name, status, address, mobile, price) REGEXP(".$q.")";
		}

		try
		{
			$db = Db::getInstance();
			$r = $db->Pdo->prepare("SELECT * FROM orders WHERE visible = 1 ".$sql." ORDER BY id DESC LIMIT :offset,:perpage");
			$r->execute([':offset' => $offset, ':perpage' => $perpage]);
			return $r->fetchAll();
		}
		catch(Exception $e)
		{
			return [];
		}
	}

	static function GetMaxRows()
	{
		try
		{
			// Search
			$q = '';
			$sql = '';
			if(!empty($_GET['q']))
			{
				$q = htmlentities($_GET['q'], ENT_QUOTES, "UTF-8");
				$sql = "AND CONCAT_WS(' ', name, status, address, mobile, price) REGEXP(".$q.")";
			}

			$db = Db::getInstance();
			$r = $db->Pdo->prepare("SELECT COUNT(*) as cnt FROM orders WHERE visible = 1".$sql);
			$r->execute();
			return $r->fetchAll()[0]['cnt'];
		}
		catch(Exception $e)
		{
			return 1;
		}
	}

	static function Del()
	{
		if(!empty($_GET['delete']))
		{
			try
			{
				$id = (int) $_GET['delete'];

				if($id > 0)
				{
					$db = Db::getInstance();
					$r = $db->Pdo->prepare("UPDATE orders SET visible = 0 WHERE id = $id");
					$r->execute();
					$ok = $r->rowCount();

					return $ok;
				}else{
					return -3;
				}
			}
			catch(Exception $e)
			{
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

		// Import component
		$menu['top'] = TopMenu::Show($arr);
		$menu['left'] = LeftMenu::Show();
		$menu['footer'] = Footer::Show($arr);

		// Draw list
		$aid = $t->Get('PP_ID');
		$vid = $t->Get('PP_IMIE');
		$a1 = $t->Get('PP_PRICE');
		$a2 = $t->Get('PP_DATE');
		$a3 = $t->Get('PP_PAY');
		$a4 = $t->Get('PP_STATUS');
		$a5 = $t->Get('PP_ACTION');
		$status = $t->Get('PP_STATUS');

		$title = [$aid, $vid, $a1, $a2, $a3, $status, $a5];

		$rows =  self::GetProducts();
		$maxrows =  self::GetMaxRows();
		// print_r($maxrows);
		// print_r($rows);
		$menu['list'] = OrdersList::Get($title, $rows, (int) $_GET['page'], $maxrows);

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
				<h1> '.$arr['trans']->Get('P_TITLE').'  </h1>
				<error id="error">
					' . $arr['error'] . '
				</error>
				<div class="box-wrap">

					<div id="box-fixed" class="animated fadeIn">
						<h3 onclick="Close(this)"> '.$arr['trans']->Get('C_ADD_CAT').' <i class="fas fa-times close"></i> </h3>
						<form method="POST" action="/panel/categories">
							<label>Name</label>
							<input type="text" name="name" placeholder="e.g. Pizza">
							<label>Slug</label>
							<input type="text" name="slug" placeholder="e.g. pizza">
							<label>Visible</label>
							<select name="visible">
								<option value="1">Yes</option>
								<option value="0">No</option>
							</select>
							<input type="submit" name="add" value="'.$arr['trans']->Get('C_ADD').'" class="btn float-right">
						</form>
					</div>

					<div id="box-fixed-edit" class="animated fadeIn">
						<h3 onclick="Close(this)"> '.$arr['trans']->Get('C_ADD_CAT1').' <i class="fas fa-times close"></i> </h3>
						<form method="POST" action="/panel/categories">
							<label>Name</label>
							<input type="text" name="name" placeholder="e.g. Pizza" id="edit-cat-name">
							<label>Slug</label>
							<input type="text" name="slug" placeholder="e.g. pizza" id="edit-cat-slug">
							<label>Visible</label>
							<select name="visible" id="edit-cat-visible">
								<option value="1">Yes</option>
								<option value="0">No</option>
							</select>
							<input type="hidden" name="catid" value="0" id="catid">
							<input type="submit" name="update" value="'.$arr['trans']->Get('C_CHANGE').'" class="btn float-right">
						</form>
					</div>

					<h3> '.$arr['trans']->Get('P_SUB_TITLE').' </h3>

					'.$html['list'].'

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