<?php
namespace MyApp\Web\Logout;

class Logout
{
	function Index($r)
	{
		unset($_SESSION);
		header('Location: /login');
		exit;
	}
}
?>