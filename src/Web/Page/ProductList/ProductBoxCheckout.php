<?php
namespace MyApp\Web\Page\ProductList;

use Exception;
use MyApp\App\Translate\Trans;
use MyApp\Web\Currency;
use MyApp\App\DbCart\DbCart;
use MyApp\App\DbCart\DbCartSave;

class ProductBoxCheckout
{
	static function Show()
	{
		$t = new Trans('/src/Web/Page/ProductList/Lang', 'pl');

		$error = '';
		$formOff = 0;

		if(!empty($_POST['add_order']))
		{
			if((int) $_POST['pay'] >= 1 && !empty($_POST['mobile']) && !empty($_POST['pick_up']) && !empty($_POST['city']) && !empty($_POST['address']))
			{
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
						$error = '<div id="order-ok"> <i class="far fa-check-circle"></i> '.$t->Get('CH_E1').' </div>';
						$error .= '<div id="order-link"> '.$t->Get('CH_E2').' </br></br></br> <a href="/order?id='.$orderid.'"> <i class="fas fa-link"></i> Status </a> </div>';

						$formOff = 1;
						unset($_SESSION['cart']);
					}
					else
					{
						$error = '<div id="order-error"> <i class="fas fa-exclamation-circle"></i> '.$t->Get('CH_E3').' </div>';
					}
				}
				catch(Exception $e)
				{
					$error = '<div id="order-error"> <i class="fas fa-exclamation-circle"></i> Error! '.$e->getMessage().' </div>';
				}
			}
			else
			{
				$error = '<div id="order-error"> <i class="fas fa-exclamation-circle"></i> '.$t->Get('CH_E4').' </div>';
			}
		}


		$h = '
			<div class="checkout-box">

				<h1> '.$t->Get('CHECKOUT').' </h1>

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
				<h3>'.$t->Get('CH_CART').' </h3>

				<div id="shopping-checkout" class="animated fadeIn">
					<div id="cart-hover-checkout">
						<div class="empty-cart"> '.$t->Get('PRODUCTS_ADD').' </div>
					</div>
				</div>

				<h3> '.$t->Get('CH_PAY').' </h3>

				<div class="pay-btn pay-btn-active" data-pay="1" onclick="PayMethod(this)"> <i class="fas fa-money-bill-wave"></i> '.$t->Get('CH_PAY1').' Money payment on delivery. </div>
				<div class="pay-btn"  data-pay="2" onclick="PayMethod(this)"> <i class="fas fa-credit-card"></i> '.$t->Get('CH_PAY2').' Card payment on delivery. </div>
				<div class="pay-btn"  data-pay="3" onclick="PayMethod(this)"> <i class="fas fa-utensils"></i> '.$t->Get('CH_PAY3').' I will pick up in person at the restaurant. </div>

				<h3> '.$t->Get('CH_ADDR').' </h3>
				<form method="post" id="order-form">
					<div id="pick-up-hide">
						<label> '.$t->Get('CH_PICKUP').' </label>
						<select name="pick_up">
							<option value="1 hour"> '.$t->Get('CH_PICK_HOUR').' </option>
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

					<label> '.$t->Get('CH_MOBILE').' </label>
					<input type="text" name="mobile" placeholder="'.$t->Get('CH_EG').' +48 700 100 100">
					<label> '.$t->Get('CH_CITY').' </label>
					<input type="text" name="city" placeholder="'.$t->Get('CH_EG').' Warsaw">
					<label> '.$t->Get('CH_ADDRESS').' </label>
					<input type="text" name="address" placeholder="'.$t->Get('CH_EG').' Złota 1/23">
					<label> '.$t->Get('CH_INFO').' </label>
					<textarea name="info"></textarea>
					<label> '.$t->Get('CH_CODE').' </label>
					<input type="text" name="coupon" placeholder="'.$t->Get('CH_EG').' HOT-WINTER">
					<input type="hidden" name="pay" value="1" id="pay-method">
					<input type="submit" name="add_order" value=" '.$t->Get('CH_ORDER_NOW').'">
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

}