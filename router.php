<?php
use PhpApix\Router\Router;
use MyApp\Web\Error\ErrorPage;

use MyApp\App\Orders\Cart;
use MyApp\App\Orders\CartDb;

try
{
	// Cart test
	$c = new Cart();
	$c->Clear();
	$hash = $c->AddProduct(1, 1, 13.50);
	$c->ProductPlus($hash);
	$c->AddAddon($hash, 16, 2, 2.54);
	$c->AddonPlus($hash, 16, 1);
	$c->AddonMinus($hash, 16, 1);

	$hash = $c->AddProduct(2, 1, 15.50);
	$c->AddAddon($hash, 17, 2, 3.00);

	// $c->Show();
	// echo $c->Checkout();

	$cdb = new CartDb();
	$price = $cdb->Checkout();
	echo $orderid = $cdb->CreateOrder($price, 'Złota 13/9');

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
