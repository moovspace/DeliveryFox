<?php
global $r;

// $r->Redirect('/panel', '/panel/profil');
$r->Set("/panel", "MyApp\Web\AdminPanel\Profil", "Index");
$r->Set("/panel/profil", "MyApp\Web\AdminPanel\Profil", "Index");
$r->Set("/panel/attributes", "MyApp\Web\AdminPanel\Attributes", "Index");
$r->Set("/panel/categories", "MyApp\Web\AdminPanel\Categories", "Index");
// Products
$r->Set("/panel/products", "MyApp\Web\AdminPanel\Products", "Index");
$r->Set("/panel/product/add", "MyApp\Web\AdminPanel\AddProduct", "Index");
$r->Set("/panel/product/edit", "MyApp\Web\AdminPanel\EditProduct", "Index");
// Orders
$r->Set("/panel/orders", "MyApp\Web\AdminPanel\Orders", "Index");
$r->Set("/panel/order", "MyApp\Web\AdminPanel\Order", "Index");
// Delivery
$r->Set("/panel/delivery", "MyApp\Web\AdminPanel\OrdersUser", "Index");
$r->Set("/panel/order-delivery", "MyApp\Web\AdminPanel\OrderUser", "Index");
?>