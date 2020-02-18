<?php
require("../../../vendor/autoload.php");
include("../../../phpini.php");

use MyApp\App\DbCart\DbCart;
use MyApp\App\DbCart\DbCartSave;
use MyApp\Web\Currency;

// Load PLN
$curr = Currency::MAIN;

// Create cart
$c = new DbCart('PLN');
// Add delivery limits
$c->DeliveryCost(5.66);
$c->DeliveryMinOrderCost(200);

// $c->Clear();

// ?add_product_id=17&add_product_quantity=1
if(!empty($_GET['add_product_id']) && !empty($_GET['add_product_quantity']) && empty($_GET['addons']))
{
	$c->AddProduct($_GET['add_product_id'], $_GET['add_product_quantity']);
}

// ?add_product_id=17&add_product_quantity=1&addons=[{"id":2,"quantity":2},{"id":17,"quantity":1}]
if(!empty($_GET['add_product_id']) && !empty($_GET['add_product_quantity']) && !empty($_GET['addons']))
{
	$hash = $c->AddProduct($_GET['add_product_id'], $_GET['add_product_quantity']);

	$addons = json_decode($_GET['addons'], true);

	foreach ($addons as $k => $v)
	{
		if($v['quantity'] <= 0)
		{
			$v['quantity'] = 1;
		}
		if($v['id'] > 0)
		{
			$c->AddAddon($hash, $v['id'], $v['quantity']);
		}
	}
}

if(!empty($_GET['add_product_hash']) && !empty($_GET['add_addon_id']) && !empty($_GET['add_product_quantity']))
{
	$c->AddAddon($_GET['add_product_hash'], $_GET['add_addon_id'], $_GET['add_addon_quantity']);
}

if(!empty($_GET['delete_product']))
{
	$c->DeleteProduct($_GET['delete_product']);
}

if(!empty($_GET['plus_product']))
{
	$c->PlusProduct($_GET['plus_product']);
}

if(!empty($_GET['minus_product']))
{
	$c->MinusProduct($_GET['minus_product']);
}

if(!empty($_GET['delete_addon']) && !empty($_GET['delete_addon_id']))
{
	$c->DeleteAddon($_GET['delete_addon'], $_GET['delete_addon_id']);
}

if(!empty($_GET['plus_addon']) && !empty($_GET['plus_addon_id']))
{
	$c->PlusAddon($_GET['plus_addon'], $_GET['plus_addon_id']);
}

if(!empty($_GET['minus_addon']) && !empty($_GET['minus_addon_id']))
{
	$c->MinusAddon($_GET['minus_addon'], $_GET['minus_addon_id']);
}

// Add product
// $hash = $c->AddProduct(2,1);
// $c->AddAddon($hash,26,2);

// $c->Show();
// echo "Cost: " . $c->Checkout();
echo $c->Html();

// Save cart orders in database
// $save = new DbCartSave();
// echo $orderid = $save->CreateOrder($c->Checkout(), 'Kucza 1', $c->DeliveryCost, '');

?>

<style>
.cart, .cart *{
	font-family: 'Quicksand', sans-serif;
	padding: 0px;
	margin: 0px;
	box-sizing: border-box;
}
.cart{
	float: left;
	width: 100%;
	padding: 5px;
	overflow: hidden;
}
.cart .checkout{
	float: left; width: 100%; overflow: hidden;
	padding: 10px 0px;
	font-size: 19px;
}
.cart .checkout .delivery{
	display: flex
}
.cart .checkout .delivery span{
	float: left; width: 50%;
}
.cart .checkout .delivery .cost{
	text-align: right; font-weight: 900
}
.cart .checkout .delivery curr{
	margin-left: 10px;
}
.cart .product{
	float: left; width: 100%;
	padding: 10px 10px 0px 10px;
	margin-bottom: 10px;
	border: 1px solid #eee;
}
.cart .product .title{
	display: flex;
	align-items: center;
	margin-bottom: 10px;
}
.cart .product .title img{
	float: left;
	min-width: 60px; min-height: 60px;
	max-width: 60px; max-height: 60px;
	margin: 5px;
	border-radius: 4px;
	overflow: hidden;
}
.cart .product .title .name{
	float: left;
	width: 100%;
	margin-left: 10px;
	font-weight: 900;
	font-size: 19px;
}
.cart .product .addon-title{
	margin-bottom: 5px; font-weight: 500; padding: 5px 5px;
}
.cart .product .addons{
	padding: 0px;
}
.cart .product .sum{
	float: left; width: 100%; text-align: right; font-weight: 600;
	padding: 10px 5px; border-top: 1px dashed #eee;
}
.cart .product .row{
	display: flex;
	align-items: center;
	padding: 5px 0px;
	margin-bottom: 5px;
}
.cart .product .row .buttons{
	float: left; min-width: 100px;
}
.cart .product .row .name{
	float: left; width: 100%; text-align: left
}
.cart .product .row .price{
	float: right; width: 100%; text-align: right
}
.cart .product .row .price .delete{
	color: #aaa; margin-left: 5px;
}
.cart .product .row .price .delete:hover{
	color: #f20; cursor: pointer
}
.cart .product .row .buttons a{
	padding: 5px; cursor: pointer; overflow: hidden
}
.cart .product .row .buttons .plus:hover{
	color: #21b973
}
.cart .product .row .buttons .minus:hover{
	color: #f20
}
.cart .product .row-big{
	font-size: 20px;
}
</style>

<link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,500,600,700,800,900" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.1/css/all.css">


<!--
<div class="cart">

	<div class="product">

		<div class="title">
			<img src="/src/Web/Auth/image.png">
			<div class="name"> Product name here </div>
		</div>

		<div class="row row-big">
			<div class="buttons">
				<a class="minus"> <i class="far fa-minus-square"></i> </a>
				<a class="quantity"> 1 </a>
				<a class="plus"> <i class="far fa-plus-square"></i> </a>
			</div>
			<div class="price">
				<span> 23.00 </span>
				<curr> PLN </curr>
				<a class="delete"> <i class="far fa-times-circle"></i> </a>
			</div>
		</div>

		<div class="addon-title"> Addons:</div>

		<div class="addons">

			<div class="row">
				<div class="buttons">
					<a class="minus"> <i class="far fa-minus-square"></i> </a>
					<a class="quantity"> 1 </a>
					<a class="plus"> <i class="far fa-plus-square"></i> </a>
				</div>
				<div class="name"> Ser parmezan </div>
				<div class="price">
					<span> 2.00 </span>
					<curr> PLN </curr>
					<a class="delete"> <i class="far fa-times-circle"></i> </a>
				</div>
			</div>

			<div class="row">
				<div class="buttons">
					<a class="minus"> <i class="far fa-minus-square"></i> </a>
					<a class="quantity"> 1 </a>
					<a class="plus"> <i class="far fa-plus-square"></i> </a>
				</div>
				<div class="name"> Ananas </div>
				<div class="price">
					<span> 5.00 </span>
					<curr> PLN </curr>
					<a class="delete"> <i class="far fa-times-circle"></i> </a>
				</div>
			</div>

		</div>

		<div class="sum"> <span> 30.00 </span> <curr> PLN </curr> </div>

	</div>

	<div class="checkout">
		<div class="delivery"> <span>Koszt dostawy</span> <span class="cost"> 5.00 </span> <curr> PLN </curr> </div>
		<div class="delivery"> <span>Razem</span> <span class="cost"> 35.00 </span> <curr> PLN </curr> </div>
	</div>

</div>
-->