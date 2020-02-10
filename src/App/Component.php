<?php
namespace MyApp\App;

// Database pdo connection import
// use PhpApix\Mysql\Db;

abstract class Component
{
	/**
	 * Return page html content
	 *
	 * @param array $arr Input data array from parent component
	 *
	 * @return string|void Html content
	 */
	static function Show($arr = null)
	{
		// Get data
		$arr = self::Data();

		// Display html
		return self::Html($arr);
	}

	/**
	 * Get data here, post, get, form, db
	 *
	 * @return $array Data from database, ...
	 */
	static function Data($arr = null){
		// Db connsctions here
		// try
		// {
		// 	$db = Db::GetInstance(); // Singleton

		// 	$stm = $db->Pdo->query("SELECT * FROM users");
		// 	$rows = $stm->fetchAll();
		// 	$count = $stm->rowCount();

		// 	$stm = $db->Pdo->query("INSERT INTO users(...) VALUES(...)");
		// 	$id = $db->Pdo->lastInsertId();

		// 	$stm = $db->Pdo->prepare("INSERT INTO users(name, ...) VALUES(:s1, ...)");
		// 	$stm->execute([':s1' => 'Name here: $name', /* ... */]);
		// 	$id = $db->Pdo->lastInsertId();

		// 	// return data here
		// }
		// catch(Exception $e)
		// {
		// 	echo $e->getMessage(). ' ' . $e->getCode();
		// }

		return ['data' => 123];
	}

	static function Html($arr = null, $html = "")
	{
		return $html . '
			<div id="box-right">
				<h1>Component Html() method</h1>
			</div>
		';
	}

	/**
	 * Return head tags: <script> i <link> for component
	 *
	 * @return string
	 */
	static function Head()
	{
		return [
			// '<link rel="stylesheet" href="/src/Web/Auth/auth.css">',
			// '<script defer src="/src/Web/Auth/auth.js"></script>'
		];
	}

	static function Title()
	{
		return 'Page title here.';
	}

	static function Description()
	{
		return 'Page description text.';
	}

	static function Keywords()
	{
		return 'Page keywords with comas.';
	}
}
?>
