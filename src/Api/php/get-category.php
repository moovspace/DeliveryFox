<?php
require("../../../vendor/autoload.php");
require("../../../phpini.php");

use MyApp\Api\Api;

header('Content-Type: application/json');

if(!empty($_GET['category']))
{
	// Get category data
	echo Api::GetCategory($_GET['category'], ['GET']);
}
else
{
	echo json_encode(['id' => 0, 'err' => 'Error params!']);
}
?>
