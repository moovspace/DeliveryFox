<?php
require("../../../../vendor/autoload.php");
require("../../../../phpini.php");

use MyApp\Web\AdminPanel\Api\Api;

header('Content-Type: application/json');

if(!empty($_GET['category']))
{
	echo Api::GetCategory($_GET['category'], ['GET']);
}
else
{
	echo json_encode(['id' => 0, 'err' => 'Error params!']);
}
?>