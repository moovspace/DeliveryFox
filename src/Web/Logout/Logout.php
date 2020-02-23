<?php
namespace MyApp\Web\Logout;

class Logout
{
	function Index($r)
	{
		unset($_SESSION);
		$_SESSION = array();
		session_destroy();
		header('Location: /login');
		exit;
	}
}
?>