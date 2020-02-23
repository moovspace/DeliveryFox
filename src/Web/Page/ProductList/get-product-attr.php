<?php
require("../../../../vendor/autoload.php");
include("../../../../phpini.php");

use PhpApix\Mysql\Db;

header('Content-Type: application/json');

if($_GET['id'] > 0)
{
	$id = (int) $_GET['id'];

	$db = Db::GetInstance();
	$r = $db->Pdo->prepare("SELECT * FROM attr_name WHERE rf_attr = $id");
	$r->execute();
	$rows = $r->fetchAll();

	echo json_encode($rows);
}else{
	echo json_encode(['error' => 1]);
}
?>