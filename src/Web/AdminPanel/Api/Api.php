<?php
namespace MyApp\Web\AdminPanel\Api;

use PhpApix\Mysql\Db;

class Api
{
	/**
	 * Test request method
	 */
	static function AllowedMethod(array $methods = ['GET', 'POST'])
	{
		if(in_array($_SERVER['REQUEST_METHOD'], array_map('strtoupper', $methods)))
		{
			return 1;
		}
		return 0;
	}

	/**
	 * Get category data
	 *
	 * @param integer $id Category id
	 * @param array $methods Allowed request methods GET, POST, DELETE, PUT ...
	 * @return string String in json format. If error then id = 0 and err = 'Error message'
	 */
	static function GetCategory(int $id = 0, $methods = ['GET'])
	{
		if(self::AllowedMethod($methods) == 0)
		{
			return json_encode(['id' => 0, 'err' => 'Error method!']);
		}

		$db = Db::GetInstance();
		$r = $db->Pdo->prepare("SELECT * FROM category WHERE id = :id");
		$r->execute([':id' => $id]);
		$row = $r->fetchAll();

		if(empty($row))
		{
			return json_encode(['id' => 0, 'err' => 'No records found!']);
		}

		return json_encode($row[0]);
	}
}