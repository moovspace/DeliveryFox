<?php
namespace MyApp\Web\AdminPanel;

use \Exception;
use PhpApix\Mysql\Db;

class User
{
	/**
	 * User id
	 *
	 * @var integer
	 */
	protected $Id = 0;

	/**
	 * User login data
	 *
	 * @var array
	 */
	protected $User = null;

	/**
	 * User info data
	 *
	 * @var array
	 */
	protected $UserInfo = null;

	/**
	 * Get user id from session
	 *
	 * @param integer $uid
	 */
	function __construct($uid = 0)
	{
		if($uid > 0)
		{
			$_SESSION['user']['id'] = (int) $uid;
		}

		if(!empty($_SESSION['user']['id']))
		{
			$this->Id = (int) $_SESSION['user']['id'];

			if($this->Id <= 0)
			{
				throw new Exception("Invalid user id!", 1);
			}
			else
			{
				$this->GetUser();
				$this->GetUserInfo();
			}
		}
		else
		{
			throw new Exception("Session user id does not exists!", 2);
		}
	}

	/**
	 * Set user data
	 *
	 * @param string $name
	 * @param string $value
	 * @return void
	 */
	function SetUser($name, $value)
	{
		$this->User[$name] = $value;
		return $this;
	}

	/**
	 * Set user_info data
	 *
	 * @param string $name
	 * @param string $value
	 * @return void
	 */
	function SetUserInfo($name, $value)
	{
		$this->UserInfo[$name] = $value;
		return $this;
	}

	function GetUser()
	{
		$id = $this->Id;
		$this->User = null;

		$db = Db::getInstance();
		$r = $db->Pdo->prepare("SELECT * FROM user WHERE id = :id");
		$r->execute([':id' => $id]);
		$rows = $r->fetchAll();

		if(!empty($rows))
		{
			// Remove password hash
			unset($rows[0]['pass']);
			// Update variable
			$this->User = $rows[0];
		}
		return $this->User;
	}

	function GetUserInfo()
	{
		$id = $this->Id;
		$this->UserInfo = null;

		$db = Db::getInstance();
		$r = $db->Pdo->prepare("SELECT * FROM user_info WHERE rf_user = :id");
		$r->execute([':id' => $id]);
		$rows = $r->fetchAll();

		if(!empty($rows))
		{
			$this->UserInfo = $rows[0];
		}

		return $this->UserInfo;
	}

	function SaveUser()
	{
		return $this->UpdateUserDb($this->User);
	}

	final protected function UpdateUserDb($arr, $table = 'user')
	{
		$sql = 'UPDATE '.$table.' SET ';
		$param = [];
		$o = '';
		foreach ($arr as $k => $v)
		{
			// key = :key
			$o .= $k.' = :'.$k .',';
			// Params array [':id' => $v]
			$param[':'.$k] = $v;
		}
		$sql .= rtrim($o, ',');
		$sql .= ' WHERE id = '.(int)$this->Id;

		$db = Db::getInstance();
		$r = $db->Pdo->prepare($sql);
		$r->execute($param);
		$ok = $r->rowCount();
		return $ok;
	}

	function SaveUserInfo()
	{
		return $this->UpdateUserInfoDb($this->UserInfo);
	}

	/**
	 * Update database
	 *
	 * @param array $arr
	 * @param string $table
	 * @return void
	 */
	final protected function UpdateUserInfoDb($arr, $table = 'user_info')
	{
		try
		{
			$insert = 'INSERT INTO '.$table.'(rf_user,firstname) VALUES('.$this->Id.',"") ';
			$db = Db::getInstance();
			$r = $db->Pdo->query($insert);
		}
		catch(Exception $e)
		{
			// echo $e->getMessage();
		}

		$sql = 'UPDATE '.$table.' SET ';
		$param = [];
		$o = '';
		foreach ($arr as $k => $v)
		{
			// key = :key
			$o .= $k.' = :'.$k .',';
			// Params array [':id' => $v]
			$param[':'.$k] = $v;
		}
		$sql .= rtrim($o, ',');
		$sql .= ' WHERE `rf_user` = '.(int)$this->Id;

		$db = Db::getInstance();
		$r = $db->Pdo->prepare($sql);
		$r->execute($param);
		$ok = $r->rowCount();
		return $ok;
	}
}