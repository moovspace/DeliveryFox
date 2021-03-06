<?php
namespace MyApp\App\DbCart;

use MyApp\App\Translate\Trans;
use PhpApix\Mysql\Db;

class DbCart
{
	public $Products = [];
	public $Addons = [];
	public $Address = '';
	public $Coupon = '';
	public $DeliveryMinOrderCost = 0;
	public $DeliveryCost = 0;
	public $DeliveryTime = 60;
	public $CartDeliveryCost = 0;
	public $Currency = 'PLN';

	function __construct($currency = 'PLN')
	{
		$this->Currency = $currency;
		$this->Load(); // Load cart from session
	}

	function AddProduct(int $id = 0, int $quantity = 1, int $attr = 0)
	{
		$hash = $this->Hash();
		if(!empty($hash) && $quantity > 0 && $id > 0)
		{
			if($attr < 0){ $attr = 0; }

			$this->Products[$hash] = ['id' => $id, 'quantity' => $quantity, 'attr' => $attr];
			$this->Save();
		}
		return $hash;
	}

	function AddAddon(string $product_hash, int $id = 0, int $quantity = 1)
	{
		if(!empty($product_hash) && $quantity > 0 && $id > 0)
		{
			$this->Addons[$product_hash][$id] = ['id' => $id, 'quantity' => $quantity];
			$this->Save();
		}
	}

	function GetProduct($id)
	{
		if($id > 0)
		{
			$db = Db::GetInstance();
			$r = $db->Pdo->prepare("SELECT * FROM product WHERE id = :id AND stock_status = 'instock'");
			$r->execute([':id' => $id]);
			$row = $r->fetchAll();

			if(!empty($row))
			{
				return $row[0];
			}
		}
		return [];
	}

	function GetAttrName($id)
	{
		if($id > 0)
		{
			$db = Db::GetInstance();
			$r = $db->Pdo->prepare("SELECT * FROM attr_name WHERE id = :id");
			$r->execute([':id' => $id]);
			$row = $r->fetchAll();

			if(!empty($row))
			{
				return $row[0]['name'];
			}
		}
		return '';
	}

	function Checkout()
	{
		$cost = 0;

		foreach ($this->Products as $k => $p)
		{
			$pr = $this->GetProduct($p['id']);

			if(!empty($pr['price']))
			{
				if($pr['on_sale'] > 0)
				{
					if($pr['price_sale'] < $pr['price'])
					{
						$cost += $pr['price_sale'] * (int) $p['quantity'];
					}else{
						$cost += $pr['price'] * (int) $p['quantity'];
					}
				}
				else
				{
					$cost += $pr['price'] * (int) $p['quantity'];
				}

				$cost += $this->AddonsCost($k, $p['quantity']);
			}
		}

		// Delivery cost
		if($cost < $this->DeliveryMinOrderCost && $cost > 0)
		{
			$cost += $this->DeliveryCost;
			$this->CartDeliveryCost = $this->DeliveryCost;
		}

		return $cost;
	}

	function AddonsCost($product_hash, $product_quantity = 1)
	{
		$cost = 0;

		if(!empty($this->Addons[$product_hash]))
		{
			foreach ($this->Addons[$product_hash] as $a)
			{
				$adb = $this->GetProduct($a['id']);

				if(!empty($adb['price']))
				{
					if($adb['on_sale'] > 0)
					{
						if($adb['price_sale'] < $adb['price'])
						{
							$cost += ($adb['price_sale'] * (int) $a['quantity']) * (int) $product_quantity;
						}else{
							$cost += ($adb['price'] * (int) $a['quantity']) * (int) $product_quantity;
						}
					}
					else
					{
						$cost += ($adb['price'] * (int) $a['quantity']) * (int) $product_quantity;
					}
				}
			}
		}

		return $cost;
	}

	function Html()
	{
		$t = new Trans('/src/App/DbCart/Lang', 'pl');

		$cart_cost = 0;

		$h = '<div class="cart">';

		foreach($this->Products as $k => $p)
		{
			$attr_name = $this->GetAttrName($p['attr']);
			if(!empty($attr_name))
			{
				$attr_name = '<small>' . $attr_name . '</small>';
			}

			$pr = $this->GetProduct($p['id']);

			if(!empty($pr) && $pr['stock_status'] == 'instock')
			{
				$price = $pr['price'];
				if($pr['price_sale'] < $price && $pr['on_sale'] > 0){
					$price = $pr['price_sale'];
				}

				$product_cost = $price * (int) $p['quantity'];

				$h .= '
				<div class="product">

					<div class="title">
						<img src="/media/product/'.$p['id'].'.jpg" onerror="ErrorProductImage(this)">
						<div class="name"> '.$pr['name'].' '.$pr['size'].' </br> ' . $attr_name . ' </div>
					</div>

					<div class="row row-big">
						<div class="buttons">
							<a class="minus" onclick="minusProduct(\''.$k.'\')"> <i class="fas fa-minus"></i> </a>
							<a class="quantity"> '.$p['quantity'].' </a>
							<a class="plus" onclick="plusProduct(\''.$k.'\')"> <i class="fas fa-plus"></i> </a>
						</div>
						<div class="price">
							<i class="fas fa-times"></i>
							<span> '.$price.' </span>
							<curr> '.$this->Currency.' </curr>
							<a class="delete" onclick="deleteProduct(\''.$k.'\')"> <i class="far fa-times-circle"></i> </a>
						</div>
					</div>';

					if(!empty($this->Addons[$k]))
					{
						$h .= '
						<div class="addon-title"> '.$t->Get('ADDONS').' </div>
						<div class="addons">
						';

						foreach($this->Addons[$k] as $v)
						{
							$pr = $this->GetProduct($v['id']);

							if(!empty($pr) && $pr['stock_status'] == 'instock')
							{
								$price = $pr['price'];
								if($pr['price_sale'] < $price && $pr['on_sale'] > 0)
								{
									$price = $pr['price_sale'];
								}

								$product_cost += ($price * (int) $v['quantity']) * (int) $p['quantity'];

								$h .= '
								<div class="row">
									<div class="buttons">
										<a class="minus" onclick="minusAddon(\''.$k.'\', \''.$v['id'].'\')"> <i class="fas fa-minus"></i> </a>
										<a class="quantity"> '.$v['quantity'].' </a>
										<a class="plus" onclick="plusAddon(\''.$k.'\', \''.$v['id'].'\')"> <i class="fas fa-plus"></i> </a>
									</div>
									<div class="name"> '.$pr['name'].' '.$pr['size'].' </div>
									<div class="price">
										<i class="fas fa-times"></i>
										<span> '.$price.' </span>
										<curr> '.$this->Currency.' </curr>
										<a class="delete" onclick="deleteAddon(\''.$k.'\', \''.$v['id'].'\')"> <i class="far fa-times-circle"></i> </a>
									</div>
								</div>
								';
							}
						}

						$h .= '</div>';
					}

					$h .= '
					<div class="sum"> <span> '.number_format((float)$product_cost,2).' </span> <curr> '.$this->Currency.' </curr> </div>
				</div>
				'; // product

				$cart_cost += $product_cost;
			}
		}

		$delivery_cost = 0;
		if($cart_cost < $this->DeliveryMinOrderCost)
		{
			$delivery_cost = $this->DeliveryCost;
		}

		if(!empty($this->Products)){
			$h .= '
				<div class="checkout">
					<div class="delivery"> <span> '.$t->Get('DELIVERY_COST').' </span> <span class="cost"> '.number_format((float)$delivery_cost,2).' </span> <curr> '.$this->Currency.' </curr> </div>
					<div class="delivery"> <span> '.$t->Get('COST').' </span> <span class="cost"> '.number_format((float)$this->Checkout(),2).' </span> <curr> '.$this->Currency.' </curr> </div>
				</div>
				<p class="delivery-min"> * '.$t->Get('DELIVERY_MIN').' '.$this->DeliveryMinOrderCost.' <curr> '.$this->Currency.' </curr> </p>
				<p class="delivery-min"> * '.$t->Get('DELIVERY_TIME').' '.$this->DeliveryTime.' min </p>
			</div>
			'; // cart
		}else{
			$h .= '
				<div class="empty">Dodaj produkty do koszyka!</div>
			';
		}

		return $h;
	}

	function Address($address = '')
	{
		$this->Address = $address;
	}

	function Coupon($coupon = '')
	{
		$this->Coupon = $coupon;
	}

	function Show()
	{
		echo "<pre>";
		print_r($this->Products);
		print_r($this->Addons);
	}

	function Save()
	{
		$_SESSION['cart']['products'] = $this->Products;
		$_SESSION['cart']['addons'] = $this->Addons;
	}

	function Load()
	{
		if(!empty($_SESSION['cart']['products'])){
			$this->Products = $_SESSION['cart']['products'];
		}
		if(!empty($_SESSION['cart']['addons'])){
			$this->Addons = $_SESSION['cart']['addons'];
		}
	}

	function DeliveryMinOrderCost($value = 0)
	{
		if($value < 0){ $value = 0; }
		$this->DeliveryMinOrderCost = $value;
	}

	function DeliveryCost($value = 0)
	{
		if($value < 0){ $value = 0; }
		$this->DeliveryCost = $value;
	}

	function DeliveryTime($value = 60)
	{
		if($value < 1){ $value = 1; }
		$this->DeliveryTime = $value;
	}

	function Clear()
	{
		unset($_SESSION['cart']);
		$this->Products = [];
		$this->Addons = [];
	}

	function Hash()
	{
		return substr(md5(microtime()),0,16);
	}

	function DeleteProduct($hash)
	{
		if(!empty($this->Products[$hash]))
		{
			unset($this->Products[$hash]);
			$this->DeleteAddons($hash);
			$this->Save();
		}
	}

	function PlusProduct($hash)
	{
		if(!empty($this->Products[$hash]['quantity']))
		{
			$this->Products[$hash]['quantity']++;
			$this->Save();
		}
	}

	function MinusProduct($hash)
	{
		if(!empty($this->Products[$hash]['quantity']))
		{
			if($this->Products[$hash]['quantity'] > 1){
				$this->Products[$hash]['quantity']--;
				$this->Save();
			}
		}
	}

	function DeleteAddons($hash)
	{
		if(!empty($this->Addons[$hash]))
		{
			unset($this->Addons[$hash]);
			$this->Save();
		}
	}

	function DeleteAddon($hash, $aid = 0)
	{
		if(!empty($this->Addons[$hash][$aid]))
		{
			unset($this->Addons[$hash][$aid]);
			$this->Save();
		}
	}

	function PlusAddon($hash, $aid = 0)
	{
		$max_addons = 10;

		$addon = $this->GetProduct($aid);
		if(!empty($addon['addon_quantity']))
		{
			$max_addons = (int) $addon['addon_quantity'];
		}

		if(!empty($this->Addons[$hash][$aid]['quantity']))
		{
			if($this->Addons[$hash][$aid]['quantity'] < $max_addons)
			{
				$this->Addons[$hash][$aid]['quantity']++;
				$this->Save();
			}
		}
	}

	function MinusAddon($hash, $aid = 0)
	{
		if(!empty($this->Addons[$hash][$aid]['quantity']))
		{
			if($this->Addons[$hash][$aid]['quantity'] > 1){
				$this->Addons[$hash][$aid]['quantity']--;
				$this->Save();
			}
		}
	}
}

?>