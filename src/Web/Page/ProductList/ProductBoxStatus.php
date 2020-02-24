<?php
namespace MyApp\Web\Page\ProductList;

use Exception;
use PhpApix\Mysql\Db;
use MyApp\App\Translate\Trans;

class ProductBoxStatus
{
	static function Show()
	{
		$t = new Trans('/src/Web/Page/ProductList/Lang', 'pl');

		$h = '
		<div class="checkout-box">

			<h1> Order status </h1>

			<div id="status-box">
				<img src="/media/img/soup.png">
				<h3>Order ID</h3>
				<h2>'.$_GET['id'].'</h2>
				<h3>Order Date</h3>
				<h2>2020-02-22 15:55:55</h2>
				<div class="status-btn status-btn-pending"> Pending </div>
				<div class="status-btn status-btn-canceled"> Canceled </div>
				<div class="status-btn status-btn-failed"> Failed </div>
				<div class="status-btn status-btn-processing"> Processing </div>
				<div class="status-btn status-btn-delivery"> Delivery </div>
				<div class="status-btn status-btn-completed"> Delivered </div>
				<p>Order waiting for restaurant confirmation.</p>
			</div>

			<div id="shopping-cart" class="animated fadeIn">
				<div id="cart-top">
					<span> <i class="fas fa-shopping-cart"></i> '.$t->Get('PRODUCTS_CART').' </span>
					<div id="close-cart"> <i class="fas fa-times"></i> </div>
					<a href="/checkout"> <div id="cart-checkout"> '.$t->Get('PRODUCTS_ORDER').' </div> </a>
				</div>
				<div id="cart-hover">
					<div class="empty-cart"> '.$t->Get('PRODUCTS_ADD').' </div>
				</div>
			</div>

		</div>
		';

		return $h;
	}

	static function Head()
	{
		return '
		<link rel="stylesheet" href="/src/Web/Page/ProductList/product-box.css">
		<script defer src="/src/Web/Page/ProductList/product-box.js"></script>
		';
	}
}