<?php
namespace MyApp\App\Orders;

class Cart
{
	public $Products = array();
	public $Addons = array();
	public $Address = '';
	public $Coupon = '';

	function __construct()
	{
		$this->Load(); // Load cart from session
	}

	function AddProduct($id, $quantity = 1, $price = 0, $sale = 0)
	{
		$hash = $this->Hash();
		$this->Products[$hash] = ['id' => (int) $id, 'quantity' => (int) $quantity, 'price' => $price, 'sale' => (int) $sale];
		$this->Save();
		return $hash;
	}

	function ProductPlus($hash, $quantity = 1)
	{
		if(!empty($this->Products[$hash]))
		{
			$quantity = $this->Products[$hash]['quantity'] + $quantity;
			$this->Products[$hash]['quantity'] = (int) $quantity;
			$this->Save();
		}
		return $hash;
	}

	function ProductMinus($hash, $quantity = 1)
	{
		if(!empty($this->Products[$hash]))
		{
			$quantity = $this->Products[$hash]['quantity'] - $quantity;
			if($quantity < 1){ $quantity = 1; }
			$this->Products[$hash]['quantity'] = (int) $quantity;
			$this->Save();
		}
		return $hash;
	}

	function ProductDelete($hash)
	{
		if(!empty($this->Products[$hash]))
		{
			unset($this->Products[$hash]);
			$this->Save();
		}
	}

	function AddAddon($product_id, $addon_id, $quantity, $price = 0, $sale = 0)
	{
		// Add product to array
		$this->Addons[$product_id][$addon_id] = ['id' => (int) $addon_id, 'quantity' => (int) $quantity, 'price' => $price, 'sale' => $sale];
		$this->Save();
	}

	function AddonPlus($product_id, $addon_id, $quantity = 1)
	{
		if(!empty($this->Addons[$product_id][$addon_id]))
		{
			$quantity = $this->Addons[$product_id][$addon_id]['quantity'] + $quantity;
			$this->Addons[$product_id][$addon_id]['quantity'] = (int) $quantity;
			$this->Save();
		}
	}

	function AddonMinus($product_id, $addon_id, $quantity = 1)
	{
		if(!empty($this->Addons[$product_id][$addon_id]))
		{
			$quantity = $this->Addons[$product_id][$addon_id]['quantity'] - $quantity;
			if($quantity < 1){ $quantity = 1; }
			$this->Addons[$product_id][$addon_id]['quantity'] = (int) $quantity;
			$this->Save();
		}
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

	function Checkout()
	{
		$cost = 0;
		foreach ($this->Products as $k => $p)
		{
			$cost += $p['price'] * (int) $p['quantity'];
			$cost += $this->AddonsCost($p['id'], $p['quantity']);
		}
		return $cost;
	}

	function AddonsCost($product_id, $product_quantity = 1)
	{
		$cost = 0;
		foreach ($this->Addons[$product_id] as $k => $p)
		{
			$cost += ($p['price'] * (int) $p['quantity']) * (int) $product_quantity;
		}
		return $cost;
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
}

/*
use MyApp\App\Orders\Cart;

session_start();

// Cart test 37.16
$c = new Cart();
$c->Clear();
$hash = $c->AddProduct(1, 1, 13.50);
$c->ProductPlus($hash);
$c->AddAddon(1, 16, 2, 2.54);
$c->AddonPlus(1, 16, 1);
$c->AddonMinus(1, 16, 1);
$c->Show();
echo $c->Checkout();

*/
?>