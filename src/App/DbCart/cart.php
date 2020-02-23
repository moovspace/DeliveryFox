<?php
require("../../../vendor/autoload.php");
include("../../../phpini.php");

use MyApp\App\DbCart\DbCart;
use MyApp\App\DbCart\DbCartSave;
use MyApp\Web\Currency;

// Load PLN
$curr = Currency::MAIN;
// Create cart
$c = new DbCart($curr);
// Add delivery limits
$c->DeliveryCost(Currency::DELIVERY_COST);
// Min order
$c->DeliveryMinOrderCost(Currency::DELIVERY_MIN_ORDER);

// ?clear=1
if(!empty($_GET['clear']))
{
	$c->Clear();
}

// ?add_product_id=17&add_product_quantity=1&addons=[{"id":2,"quantity":2},{"id":17,"quantity":1}]
// ?add_product_id=17&add_product_quantity=1&add_product_attr=0&addons=[{"id":2,"quantity":2},{"id":17,"quantity":1}]
if(!empty($_GET['add_product_id']) && !empty($_GET['add_product_quantity']))
{
	if(empty($_GET['add_product_attr'])) { $_GET['add_product_attr'] = 0; }
	$hash = $c->AddProduct($_GET['add_product_id'], $_GET['add_product_quantity'], $_GET['add_product_attr']);

	if(!empty($_GET['addons']))
	{
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
*:not(i){
	font-family: 'Quicksand', sans-serif;
}
.cart, .cart *{
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
	border: 1px solid #fff;
	border-radius: 6px;
	box-shadow: 0px 2px 3px rgba(0,0,0,0.1)
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
	object-fit: cover
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
	float: left; width: 100%; text-align: right;
	padding: 10px 5px; border-top: 1px dashed #eee;
}
.cart .product .sum *{
font-weight: 900
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
	color: #222; padding: 5px; cursor: pointer; overflow: hidden;
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
.cart .empty{
	float: left; width: 98%; margin: 1%;
	padding: 13px 25px;
	background: #fff; color: #21b973; border: 1px solid #21b973; box-shadow: 0px 1px 3px rgba(0,0,0,0.1);
	font-size: 15px; font-weight: 500;
	border-radius: 6px;
}
.cart .delivery-min{
	font-size: 15px; font-weight: 700
}
.cart .product .row .price .fa-times{
	font-size: 13px; margin-right: 10px; color: #000;
}
.cart .product .title .name small{
	background: #21b9730c; color: #21b922;
	font-weight: 500; font-size: 13px;
	padding: 2px 20px; margin-top: 5px;
	border-radius: 66px; border: 1px solid #21b922;
}
</style>

<!--
<link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,500,600,700,800,900" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.1/css/all.css">
<script src="/src/App/DbCart/cart.js"></script>
-->

<?php
exit;
?>

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