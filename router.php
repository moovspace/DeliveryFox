<?php
use PhpApix\Router\Router;
use MyApp\Web\Error\ErrorPage;

try
{
	$r = new Router();

	// Namespace path
	$r->Set("/", "MyApp/Web/Home/Homepage", "Index");
	$r->Set("/logout", "MyApp/Web/Logout/Logout", "Index");

	// Include Auth Component route path
	$r->Include("Web/Auth/routes");

	// Admin Panel
	// $r->Redirect('/panel', '/panel/profil');
	$r->Set("/panel", "MyApp\Web\AdminPanel\Profil", "Index");
	$r->Set("/panel/profil", "MyApp\Web\AdminPanel\Profil", "Index");
	$r->Set("/panel/attributes", "MyApp\Web\AdminPanel\Attributes", "Index");
	$r->Set("/panel/categories", "MyApp\Web\AdminPanel\Categories", "Index");
	$r->Set("/panel/products", "MyApp\Web\AdminPanel\Products", "Index");
	$r->Set("/panel/product/add", "MyApp\Web\AdminPanel\AddProduct", "Index");
	$r->Set("/panel/product/edit", "MyApp\Web\AdminPanel\EditProduct", "Index");

	// $r->ErrorPage();
	ErrorPage::Error404();
}
catch(Exception $e)
{
	echo json_encode(["errorMsg" => $e->getMessage(), "errorCode" => $e->getCode()]);
}
?>

<?php
/*
// Redirect uri (on top)
$r->Redirect('/panel', '/panel/profil');

// Only GET
$r->Set('/route1', function($p) {
	echo "WORKS WITH GET " . $p[0] . ' ' .$_GET['id'];
}, ['Param 1'], ['GET']);

// Only POST, PUT
$r->Set('/route2', function($p) {
	echo "WORKS WITH POST " . ' ' . implode(' ', $_POST);
}, 'Func params here', ['POST', 'PUT']);

// Api route
$r->Set("/api/user/{id}", "Api/User/User", "GetId");

// Add route: url, class path, class method
$r->Set("/welcome/email/{id}", "Api/Sample/SampleClass", "Index");

// Or load from controller route.php file
// $r->Include('Api/Sample/route');

*/
?>
