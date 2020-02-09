<?php
// Import mysql pdo class
use PhpApix\Mysql\MysqlConnect;

// Import html header, body
use MyApp\Api\Home\Html;

// Class controller
class Home extends MysqlConnect
{
    function Index($router)
    {
		// Include header
		Html::Header();

    	?>

		<div class="box">			
			<h1>Hello World</h1>			
		</div>

        <?php

		try
		{
			// Create mysql database, tables
			// $this->Create();
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
