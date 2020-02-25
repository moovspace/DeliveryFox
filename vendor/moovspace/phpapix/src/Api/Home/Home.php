<?php
namespace PhpApix\Api\Home;

// Import mysql pdo class
use PhpApix\Mysql\MysqlConnect;

// Import html header, body
use PhpApix\Api\Home\Html;

// Class controller
class Home extends MysqlConnect
{
    function Index($router)
    {
		// Include header
		Html::Header();

    	?>

		<div class="box">
			<img src="media/img/phpapix-logo.jpg" width="156" height="156" class="logo">
			<h1>PhpApix</h1>
			<h3>Php api router with composer autoload</h3>
			<br>
			<a href="/welcome/email/UserName"> Page sample </a> </br>
			<a href="/api/user/Admin"> Json api sample </a>
			<h5>For more examples, go to the src/Api directory.</h5>
			<br>
			<a href="https://github.com/moovspace/PhpApix" class="btn btn-outline-primary" target="__blank"> Get Started With PhpApix</a>
		</div>

        <?php

		try
		{
			// Create mysql database, tables
			$this->Create();
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
		}

        // Include footer
    	Html::Footer();
    }
}
?>
