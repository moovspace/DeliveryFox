<?php
namespace MyApp\Web\AdminPanel;

use \Exception;
use PhpApix\Mysql\Db;

/**
 * Logged user class
 *
 * @throw Exception Error code number: 666
 */
class User
{
	/**
	 * User id
	 *
	 * @var integer
	 */
	protected $Id = 0;

	/**
	 * User privileges
	 *
	 * @var string
	 */
	protected $Role = 'user';

	/**
	 * Is account activeated
	 *
	 * @var integer
	 */
	protected $Active = 0;

	/**
	 * Username
	 *
	 * @var string
	 */
	protected $Username = '';

	/**
	 * User email
	 *
	 * @var string
	 */
	protected $Email = '';

	/**
	 * User mobile
	 *
	 * @var string
	 */
	protected $Mobile = '';

	/**
	 * User tmp data
	 *
	 * @var array
	 */
	protected $UserSave = null;

	/**
	 * User info tmp data
	 *
	 * @var array
	 */
	protected $UserInfoSave = null;

	/**
	 * User login data
	 *
	 * @var array
	 */
	public $User = null;

	/**
	 * User info data
	 *
	 * @var array
	 */
	public $UserInfo = null;

	/**
	 * Logged user session id
	 *
	 * @return integer
	 */
	public function Id()
	{
		return $this->Id;
	}

	/**
	 * Logged user session role
	 *
	 * @return integer
	 */
	public function Role()
	{
		return (string) $this->Role;
	}

	/**
	 * Logged user session active
	 *
	 * @return integer
	 */
	public function Active()
	{
		return $this->Active;
	}

	/**
	 * Logged user session username
	 *
	 * @return string
	 */
	public function Username()
	{
		return $this->Username;
	}

	/**
	 * Logged user session email
	 *
	 * @return string
	 */
	public function Email()
	{
		return $this->Email;
	}

	/**
	 * Logged user session mobile
	 *
	 * @return string
	 */
	public function Mobile()
	{
		return $this->Mobile;
	}

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
			if($_SESSION['user']['id'] <= 0)
			{
				throw new Exception("Invalid session user id!", 666);
			}
			else
			{
				$this->Id = (int) $_SESSION['user']['id'];
				$this->Role = (string) $_SESSION['user']['role'];
				$this->Active = (int) $_SESSION['user']['active'];
				$this->Username = (string) $_SESSION['user']['username'];
				$this->Mobile = (string) $_SESSION['user']['mobile'];
				$this->Email = (string) $_SESSION['user']['email'];
			}
		}
		else
		{
			throw new Exception("Invalid session user id!", 666);
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
		$this->UserSave[$name] = $value;
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
		// Data update
		$this->UserInfoSave[$name] = $value;
		return $this;
	}

	/**
	 * Get user data
	 *
	 * @return array
	 */
	function GetUser()
	{
		$this->User = null;

		$db = Db::getInstance();
		$r = $db->Pdo->prepare("SELECT * FROM user WHERE id = :id");
		$r->execute([':id' => $this->Id]);
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

	/**
	 * Get user info data
	 *
	 * @return array
	 */
	function GetUserInfo()
	{
		$this->UserInfo = null;

		$db = Db::getInstance();
		$r = $db->Pdo->prepare("SELECT * FROM user_info WHERE rf_user = :id");
		$r->execute([':id' => $this->Id]);
		$rows = $r->fetchAll();

		if(!empty($rows))
		{
			$this->UserInfo = $rows[0];
		}

		return $this->UserInfo;
	}

	/**
	 * Update user data
	 *
	 * @return integer
	 */
	function SaveUser()
	{
		return $this->UpdateUserDb($this->UserSave);
	}

	/**
	 * Update user table
	 *
	 * @param array $arr Array with data [paran => value]
	 * @param string $table Table name
	 * @return integer
	 */
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

	/**
	 * Update user_info data
	 *
	 * @return integer
	 */
	function SaveUserInfo()
	{
		return $this->UpdateUserInfoDb($this->UserInfoSave);
	}

	/**
	 * Update database
	 *
	 * @param array $arr Array with data [paran => value]
	 * @param string $table Table name
	 * @return integer
	 */
	final protected function UpdateUserInfoDb($arr, $table = 'user_info')
	{
		try
		{
			$uid = (int) $this->Id;
			$insert = 'INSERT INTO '.$table.'(rf_user,firstname) VALUES('.$uid.',"") ';
			$db = Db::getInstance();
			$r = $db->Pdo->query($insert);
		}
		catch(Exception $e)
		{
			// echo $e->getMessage();
			// Dummy error: duplicate key
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

/*
	$user = new User();

	// Get user data
	$u = $this->GetUser(); // user table: username, email, mobile, ...
	$ui = $this->GetUserInfo(); // user_info table: firstname, lastname, country, address, city, ...

	// User table update
	$user->SetUser('role', 'admin');
	$user->SaveUser();

	// User_info table update
	$user->SetUserInfo('firstname', 'Maxiu');
	$user->SetUserInfo('lastname', 'Maxioski');
	$user->SaveUserInfo();
*/