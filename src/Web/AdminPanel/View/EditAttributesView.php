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
use MyApp\Web\AdminPanel\AttrListEdit;

class EditAttributesView extends Component
{
	static public $ErrorUpdate = 0;

	static function Menu()
	{
		$t = new Trans('/src/Web/AdminPanel/Lang', 'pl');
		$t_attr = $t->Get('A_LIST');
		$t_title = $t->Get('A_TITLE');
		$menu = new Menu('/panel/attributes', $t_attr, $t_title, '<i class="fas fa-cog"></i>', '<i class="fas fa-cog"></i>');
		// $menu->AddLink('/panel/profil', 'Profil', 'User profile');
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
			$eid = (int)$_GET['edit'];

			$db = Db::getInstance();
			$r = $db->Pdo->prepare("SELECT id,name FROM attr_name WHERE rf_attr = $eid ORDER BY id DESC LIMIT :offset,:perpage");
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

	static function AddAttributeVariant()
	{
		if(!empty($_POST['add']))
		{
			try
			{
				$name = $_POST['attr'];
				$eid = (int) $_GET['edit'];

				if(!empty($name) && self::AttributeExists($eid) > 0)
				{
					$db = Db::getInstance();
					$r = $db->Pdo->prepare("INSERT INTO attr_name(rf_attr,name) VALUES(:attr, :name)");
					$r->execute(['attr' => $eid,':name' => $name]);
					unset($_POST['attr']);
					return $db->Pdo->lastInsertId();
				}
				return 0;
			}
			catch(Exception $e)
			{
				if ($e->errorInfo[1] == 1062) {
					return -2; // record exist
				}
				return -1; // error
			}
		}
	}

	static function ChangeAttribute()
	{
		if(!empty($_POST['change']))
		{
			try
			{
				$name = $_POST['attr'];
				$eid = (int) $_GET['edit'];

				if(!empty($name) && self::AttributeExists($eid) > 0)
				{
					$db = Db::getInstance();
					$r = $db->Pdo->prepare("UPDATE attr SET name = :name WHERE id = :attr");
					$r->execute(['attr' => $eid, ':name' => $name]);
					return $db->Pdo->lastInsertId();
				}
				return 0;
			}
			catch(Exception $e)
			{
				return -1;
			}
		}
	}

	static function GetAttributeName()
	{
		try
		{
			$eid = (int)$_GET['edit'];

			$db = Db::getInstance();
			$r = $db->Pdo->prepare("SELECT name FROM attr WHERE id = $eid");
			$r->execute();
			$rows = $r->fetchAll();

			if(!empty($rows))
			{
				return $rows[0]['name'];
			}
			return 'Error attribute id';
		}
		catch(Exception $e)
		{
			return [];
		}
	}

	static function AttributeExists($id)
	{
		try
		{
			$id = (int)$id;

			$db = Db::getInstance();
			$r = $db->Pdo->prepare("SELECT COUNT(*) as cnt FROM attr WHERE id = $id");
			$r->execute();
			return $r->fetchAll()[0]['cnt'];
		}
		catch(Exception $e)
		{
			return 0;
		}
	}

	static function CheckAttributesChilds($id)
	{
		try
		{
			$id = (int) $id;

			$db = Db::getInstance();
			$r = $db->Pdo->prepare("SELECT COUNT(*) as cnt FROM product_attr WHERE rf_attr = $id");
			$r->execute();
			return $r->fetchAll()[0]['cnt'];
		}
		catch(Exception $e)
		{
			return 1;
		}
	}

	static function DelAttributeVariant()
	{
		if(!empty($_GET['delete']))
		{
			try
			{
				$id = (int) $_GET['delete'];

				if(self::CheckAttributesChilds($id) == 0)
				{
					$db = Db::getInstance();
					$r = $db->Pdo->prepare("DELETE FROM attr_name WHERE id = $id");
					$r->execute();
					return $r->rowCount();
				}else{
					// Delete attr_name childs first
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

			// Add variant
			$user->ErrorUpdate = self::AddAttributeVariant();

			// Delete variant
			if(!empty($_GET['delete']))
			{
				$user->ErrorUpdate = self::DelAttributeVariant();
			}

			// Change attribute
			if(!empty($_POST['change']))
			{
				$user->ErrorUpdate = self::ChangeAttribute();
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

		if(!empty($_POST) || !empty($_GET['delete']))
		{
			if($user->ErrorUpdate == 0){
				$arr['error'] = '<span class="green"> '.$t->Get('A_ERR_OK').' </span>';
			}else if($user->ErrorUpdate == 1){
				$arr['error'] = '<span class="green"> '.$t->Get('A_VARIANT_UPDATED').' </span>';
			}else if($user->ErrorUpdate > 0){
				$arr['error'] = '<span class="green"> '.$t->Get('A_VARIANT_UPDATED').' </span>';
			}else if($user->ErrorUpdate == -3){
				$arr['error'] = '<span class="red"> '.$t->Get('A_ERR_VARIANT_DELETE').' </span>';
			}else if($user->ErrorUpdate == -2){
				$arr['error'] = '<span class="red"> '.$t->Get('A_ERR_VARIANT_DUPLICATE').' </span>';
			}else if($user->ErrorUpdate < 0){
				$arr['error'] = '<span class="red"> '.$t->Get('A_ERR_UPDATE').' </span>';
			}
		}

		// Import component
		$menu['top'] = TopMenu::Show($arr);
		$menu['left'] = LeftMenu::Show();
		$menu['footer'] = Footer::Show($arr);

		// Draw list
		$aid = $t->Get('A_L_ID');
		$aname = $t->Get('A_V_NAME');
		$aaction = $t->Get('A_L_ACTION');
		$title = [$aid, $aname, $aaction]; // $title = ['Id','Name', 'Actions'];

		$rows =  self::GetAttributes();
		$maxrows =  self::GetAttributesMaxRows();
		// print_r($maxrows);
		// print_r($rows);
		$menu['list'] = AttrListEdit::Get($title, $rows, (int) $_GET['page'], $maxrows);
		$menu['attr_name'] = self::GetAttributeName();

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
				<h1> '.$arr['trans']->Get('A_TITLE_EDIT').'  </h1>
				<error id="error">
					' . $arr['error'] . '
				</error>
				<div class="box-wrap">

					<div id="box-fixed" class="animated fadeIn">
						<h3 onclick="Close(this)"> '.$arr['trans']->Get('A_VARIANT').' <i class="fas fa-times close"></i> </h3>
						<form method="POST" action="">
							<input type="text" name="attr" placeholder="e.g. Big or Small">
							<input type="submit" name="add" value="'.$arr['trans']->Get('A_VARIANT_ADD').'" class="btn float-right">
						</form>
					</div>

					<div id="box-fixed-edit" class="animated fadeIn">
						<h3 onclick="Close(this)"> '.$arr['trans']->Get('A_ATTRIBUTE_EDIT').' <i class="fas fa-times close"></i> </h3>
						<form method="POST" action="">
							<input type="text" name="attr" placeholder="e.g. Size or Sauce">
							<input type="submit" name="change" value="'.$arr['trans']->Get('A_ATTRIBUTE_CHANGE').'" class="btn float-right">
						</form>
					</div>

					<h3> '.$arr['trans']->Get('A_ATTRIBUTE').': <span class="color-green"> '.$html['attr_name'].' </span>  <a id="btn-add-attribute" onclick="OpenAddAttributes(this)"> '.$arr['trans']->Get('A_VARIANT').' <i class="fas fa-plus"></i> </a>  <a id="btn-add-attribute" onclick="OpenEditAttributes(this)"> '.$arr['trans']->Get('A_EDIT').' <i class="fas fa-edit"></i> </a> </h3>

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