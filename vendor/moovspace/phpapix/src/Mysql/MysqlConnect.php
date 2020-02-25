<?php
namespace PhpApix\Mysql;

use \PDO;
use \Exception;
use PhpApix\Settings\Config;

class MysqlConnect extends Config
{
	public $Pdo = null;

	function __construct (){
		// Mysql object
		$this->Pdo = $this->Conn ();
	}

	final function Conn (){
		try{
			// pdo
			$con = new PDO('mysql:host='.self::MYSQL_HOST.';port='.self::MYSQL_PORT.';dbname='.self::MYSQL_DBNAME.';charset=utf8mb4', self::MYSQL_USER, self::MYSQL_PASS);
			// show warning text
			$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
			// throw error exception
			$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//Default fetch mode
			$con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
			// don't colose connecion on script end
			$con->setAttribute(PDO::ATTR_PERSISTENT, true);
			// set utf for connection utf8_general_ci or utf8_unicode_ci
			$con->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'utf8mb4' COLLATE 'utf8mb4_unicode_ci'");
			// prepared statements, don't cache query with prepared statments
			$con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			// Auto commit
			// $con->setAttribute(PDO::ATTR_AUTOCOMMIT,flase);
			// Buffered querry default
			// $con->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true);
			return $con;
		}catch(Exception $e){
			echo 'Connection failed: ' . $e->getMessage ();
			// print_r($e->errorInfo());
			return null;
		}
	}

	/**
	 * Query
	 * Secure mysql query
	 *
	 * $this->Query("SELECT * FROM users WHERE id = :id", array(':id' => 1));
	 */
	function Query($sql, $arr = array()){
		try{
			$r = $this->pdo->prepare ($sql);
			$r->execute ($arr);
			$out = $r->fetchAll ();
			$lid = (int) $this->pdo->lastInsertId ();
			if(!empty ($out)){
				return $out;
			}else if($lid > 0){
				return $lid;
			}
			return $r->rowCount ();
		}catch(Exception $e){
			print_r ($e);
			throw new Exception ("Error sql " . $e->getMessage (), 1);
		}
	}

	public function Create()
	{
		try
		{
			$table = "
			CREATE TABLE IF NOT EXISTS `users` (
				`id` bigint(22) NOT NULL AUTO_INCREMENT,
				`username` varchar(32) NOT NULL DEFAULT '',
				`email` varchar(180) NOT NULL DEFAULT '',
				`pass` varchar(32) NOT NULL DEFAULT '',
				`language` varchar(10) NOT NULL DEFAULT 'en',
				`role` int(3) NOT NULL DEFAULT '1',
				`active` int(3) NOT NULL DEFAULT '0',
				`ban` int(3) NOT NULL DEFAULT '0',
				`ip` varchar(200) NOT NULL DEFAULT '',
				`code` varchar(32) NOT NULL DEFAULT 'abc321',
				`time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				`firstname` varchar(50) NOT NULL DEFAULT '',
				`lastname` varchar(50) NOT NULL DEFAULT '',
				`country` varchar(100) NOT NULL DEFAULT 'Poland',
				`district` varchar(100) NOT NULL DEFAULT '',
				`city` varchar(50) NOT NULL DEFAULT '',
				`address` varchar(100) NOT NULL DEFAULT '',
				`zipcode` varchar(10) NOT NULL DEFAULT '',
				`mobile` varchar(50) NOT NULL DEFAULT '',
				`mail` varchar(250) NOT NULL DEFAULT '',
				`www` varchar(250) NOT NULL DEFAULT '',
				`social` text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
				`about` text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
				`sex` enum('men','woman') DEFAULT 'men',
				`lng` decimal(10,6) NOT NULL DEFAULT '0.000000',
				`lat` decimal(10,6) NOT NULL DEFAULT '0.000000',
				PRIMARY KEY (`id`),
				UNIQUE KEY `ukey1` (`email`),
				UNIQUE KEY `ukey` (`username`),
				KEY `id` (`id`)
			) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
			";
			$r = $this->Pdo->query($table);
		}
		catch(Exception $e)
		{
			throw new Exception("Error create table: ". $e->getMessage(), 1);
		}
	}

	function ImportSqlite($dbPath = 'dbname.db', $sqlPath = 'phpapix.sql'){
		$db = new PDO('sqlite:' . $dbPath);
		$fh = fopen($sqlPath, 'r');
		while ($line = fread($fh, 4096)) {
			$db->exec($line);
		}
		fclose($fh);
	}

	function ImportSql($sqlPath = 'phpapix.sql'){
		$fh = fopen($sqlPath, 'r');
		while ($line = fread($fh, 4096)) {
			$this->Pdo->exec($line);
		}
		fclose($fh);
		// Or
		// $r = $this->pdo->exec(file_get_contents($sqlPath));
	}
}
?>
