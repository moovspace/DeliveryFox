<?php
namespace MyApp\Web\Page\ProductList;

use Exception;
use PhpApix\Mysql\Db;
use MyApp\App\Translate\Trans;
use MyApp\Web\Currency;
use MyApp\App\DbCart\DbCart;
use MyApp\App\DbCart\DbCartSave;

class ProductBoxCheckout
{
	static function Show()
	{
		$error = '';
		$formOff = 0;

		if(!empty($_POST['add_order']))
		{
			if((int) $_POST['pay'] >= 1 && !empty($_POST['mobile']) && !empty($_POST['pick_up']) && !empty($_POST['city']) && !empty($_POST['address']))
			{
				// print_r($_POST);

				try
				{
					$orderid = 0;

					// Load PLN
					$curr = Currency::MAIN;
					// Create cart
					$c = new DbCart($curr);
					// Add delivery limits
					$c->DeliveryCost(Currency::DELIVERY_COST);
					// Min order
					$c->DeliveryMinOrderCost(Currency::DELIVERY_MIN_ORDER);

					if(!empty($c->Products))
					{
						// Save cart orders in database
						$save = new DbCartSave();
						$orderid = $save->CreateOrder($c->Checkout(), $_POST['city'].' '.$_POST['address'], $_POST['pick_up'], $_POST['mobile'], $_POST['info'], (int) $_POST['pay'], (float) $c->DeliveryCost, $_POST['coupon']);
					}

					if($orderid > 0)
					{
						$error = '<div id="order-ok"> <i class="far fa-check-circle"></i> Your order has been created! </div>';
						$error .= '<div id="order-link"> Click the link to view the status of the order. </br></br></br> <a href="/order?id='.$orderid.'"> <i class="fas fa-link"></i> Order status </a> </div>';

						$formOff = 1;
					}
					else
					{
						$error = '<div id="order-error"> <i class="fas fa-exclamation-circle"></i> Error! Can\'t create order. </div>';
					}
				}
				catch(Exception $e)
				{
					$error = '<div id="order-error"> <i class="fas fa-exclamation-circle"></i> Error! '.$e->getMessage().' </div>';
				}
			}
			else
			{
				$error = '<div id="order-error"> <i class="fas fa-exclamation-circle"></i> Delivery form must be not empty! </div>';
			}
		}

		$t = new Trans('/src/Web/Page/ProductList/Lang', 'pl');

		$h = '
			<div class="checkout-box">

				<h1> Checkout </h1>

				<div id="shopping-cart" class="animated fadeIn">
					<div id="cart-top">
						<span> <i class="fas fa-shopping-cart"></i> '.$t->Get('PRODUCTS_CART').' </span>
						<div id="close-cart"> <i class="fas fa-times"></i> </div>
						<a href="/checkout"> <div id="cart-checkout"> '.$t->Get('PRODUCTS_ORDER').' </div> </a>
					</div>
					<div id="cart-hover">
						<div class="empty-cart"> '.$t->Get('PRODUCTS_ADD').' </div>
					</div>
				</div>';

			$h .= $error;

			$o = '
				<h3>Cart products</h3>

				<div id="shopping-checkout" class="animated fadeIn">
					<div id="cart-hover-checkout">
						<div class="empty-cart"> '.$t->Get('PRODUCTS_ADD').' </div>
					</div>
				</div>

				<h3>Paymeny method</h3>

				<div class="pay-btn pay-btn-active" data-pay="1" onclick="PayMethod(this)"> <i class="fas fa-money-bill-wave"></i> Money payment on delivery. </div>
				<div class="pay-btn"  data-pay="2" onclick="PayMethod(this)"> <i class="fas fa-credit-card"></i> Card payment on delivery. </div>
				<div class="pay-btn"  data-pay="3" onclick="PayMethod(this)"> <i class="fas fa-utensils"></i> I will pick up in person at the restaurant. </div>

				<h3>Delivery address</h3>
				<form method="post" id="order-form">
					<div id="pick-up-hide">
						<label>Pick up time</label>
						<select name="pick_up">
							<option value="1 hour">Pick up in an hour</option>
						';
						for($i = 0; $i < 24; $i++)
						{
							if(strlen($i) == 1){
								$i = '0'.$i;
							}
							$o .= '<option value="' .$i. ':00">' .$i. ':00</option>';
							$o .= '<option value="' .$i. ':30">' .$i. ':30</option>';
						}

			$o .=		'</select>
					</div>

					<label>Mobile</label>
					<input type="text" name="mobile" placeholder="e.g. +48 700 100 100">
					<label>City</label>
					<input type="text" name="city" placeholder="e.g. Warsaw">
					<label>Address</label>
					<input type="text" name="address" placeholder="e.g. Złota 1/23">
					<label>Order info (optional)</label>
					<textarea name="info"></textarea>
					<label>Coupon code (optional)</label>
					<input type="text" name="coupon" placeholder="e.g. HOT-WINTER">
					<input type="hidden" name="pay" value="1" id="pay-method">
					<input type="submit" name="add_order" value="Order Now">
				</form>
			</div>';

			if($formOff)
			{
				// Hide order form (order created)
				$o = '';
			}

		return $h.$o;
	}

	static function Head()
	{
		return '
		<link rel="stylesheet" href="/src/Web/Page/ProductList/product-box.css">
		<script defer src="/src/Web/Page/ProductList/product-box.js"></script>
		';
	}

	static function GetParams()
	{
		$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
		return explode('/', rtrim(ltrim($url, '/'), '/'));
	}

	static function GetProducts($slug = '', int $page = 1, int $perpage = 6, $q = '')
	{
		try
		{
			if($page < 1 ){ $page = 1; }
			$offset = (int) (($page - 1) * $perpage);

				// Get products
			$db = Db::GetInstance();

			if(!empty($q))
			{
				$q = str_replace(' ', '|', $q);
				$sql = "SELECT * FROM product WHERE CONCAT_WS('',name,about) REGEXP :q AND parent = 0 ORDER BY id DESC LIMIT $offset, $perpage";
				$r = $db->Pdo->prepare($sql);
				$r->execute([':q' => $q]);
			}
			else
			{
				// Category id
				$cid = (int) self::GetCategoryId($slug);
				$sql = "SELECT * FROM product WHERE category = $cid AND parent = 0 AND visible = 1 ORDER BY id DESC LIMIT $offset, $perpage";
				if($cid == 0)
				{
					$sql = "SELECT * FROM product WHERE category != $cid AND parent = 0 AND visible = 1 ORDER BY id DESC LIMIT $offset, $perpage";
				}
				$r = $db->Pdo->prepare($sql);
				$r->execute();
			}

			return $r->fetchAll();
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
		}
	}

	static function GetCategoryId($slug = '')
	{
		try
		{
			$db = Db::GetInstance();
			$r = $db->Pdo->prepare("SELECT id FROM category WHERE slug = :slug");
			$r->execute([':slug' => $slug]);
			$o = $r->fetchAll();
			if(!empty($o)){
				return $o[0]['id'];
			}else{
				return 0;
			}
		}
		catch(Exception $e)
		{

		}
	}
}