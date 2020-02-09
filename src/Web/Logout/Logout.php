<?php
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