<?php
namespace MyApp\App;

// Database pdo connection import
// use PhpApix\Mysql\Db;

abstract class Component
{
	/**
	 * Return or display page html content
	 *
	 * @param array $arr Input data array
	 *
	 * @return string|echo Html content
	 */
	abstract static function Show($arr = null);

	/**
	 * Return head tags: <script> i <link> for component
	 *
	 * @return string
	 */
	static function Head()
	{
		// return '<link rel="stylesheet" href="/src/Web/Home/style.css">';
	}

	/**
	 * Get data here, post, get, form, db
	 *
	 * @return void
	 */
	static function Data(){
		// Db connsctions here
		// try {
		// 	$db = Db::GetInstance();
		// 	$stm = $db->Pdo->query("SELECT * FROM users");
		// 	$rows = $stm->fetchAll();
		// 	return json_encode($rows);
		// 	// $db->Pdo->lastInsertId();
		// 	// PDO::lastInsertId();
		// }catch(Exception $e){
		// 	echo $e->getMessage();
        // }
	}
}
?>
