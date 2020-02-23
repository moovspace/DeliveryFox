<?php
namespace MyApp\Web\Page\Menu;

use Exception;
use PhpApix\Mysql\Db;

class CategoryMenu
{
	static function Data()
	{
		try
		{
			$db = Db::GetInstance();
			$r = $db->Pdo->prepare("SELECT * FROM category WHERE visible = 1");
			$r->execute();
			$row = $r->fetchAll();
			return $row;
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
		}
		return [];
	}

	static function Show(array $arr = [])
	{
		$h = '<div class="category-menu"> <div class="title"> <i class="fas fa-bars"></i> Menu </div>';
		foreach (self::Data() as $k => $v) {
			$h .= '<a class="link" href="/category/'.$v['slug'].'">'.ucfirst($v['name']).'</a>';
		}
		return $h .'</div>';
	}

	static function Head()
	{
		return '
		<link rel="stylesheet" href="/src/Web/Page/Menu/category-menu.css">
		<script defer src="/src/Web/Page/Menu/category-menu.js"></script>
		';
	}
}
?>