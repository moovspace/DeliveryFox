<?php
namespace MyApp\App\Orders;

use \Exception;
use PhpApix\Mysql\Db;

class CartDb
{
	public $Products = array();
	public $Addons = array();

	function __construct()
	{
		$this->Load(); // Load cart from session
	}

	function Show()
	{
		print_r($this->Products);
		print_r($this->Addons);
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

	/**
	 * Create orders in database from Cart class object
	 *
	 * @param float $price Checkout price
	 * @param string $address Delivery address
	 * @param string $cupon Coupon code
	 * @return string Order id
	 */
	function CreateOrder($price, $address, $cupon = '')
	{
		$orderid = 0;

		if(empty($this->Products))
		{
			throw new Exception("Add products to cart", 1);
		}

		if(empty($address))
		{
			throw new Exception("Empty order address", 1);
		}

		if($price < 0)
		{
			throw new Exception("Error order price", 3);
		}

		$orderid = (int) $this->CreateOrderId($price, $address, $cupon);

		if($orderid > 0)
		{
			$this->AddProducts($orderid);
			// $this->AddAddons($orderid);
		}
		else
		{
			throw new Exception("Error order id", 2);
		}


		return $orderid;
	}

	protected function CreateOrderId($price = 0, $address, $cupon = '')
	{
		try
		{
			$db = Db::GetInstance();
			$r = $db->Pdo->prepare("INSERT INTO orders(price, address, coupon) VALUES(:price, :address, :cupon)");
			$r->execute([':price' => $price, ':address' => $address, ':cupon' => $cupon]);
			return $db->Pdo->lastInsertId();
		}
		catch(Exception $e)
		{
			throw new Exception("Can not create order in database! " . $e->getMessage(), 5);
		}
	}

	protected function AddProducts($oid = 0)
	{
		$this->ProductsIds = null;

		if($oid > 0)
		{
			try
			{
				$db = Db::GetInstance();

				foreach($this->Products as $k => $v)
				{
					$r = $db->Pdo->prepare("INSERT INTO order_product(rf_orders, product, price, quantity, sale) VALUES(:rf, :product, :price, :quantity, :sale)");
					$r->execute([':rf' => $oid, ':product' => $v['id'], ':price' => $v['price'], ':quantity' => $v['quantity'], ':sale' => $v['sale']]);
					$this->ProductsIds[] = $pid = $db->Pdo->lastInsertId();
					// Add product addons
					$this->AddAddons($oid, $pid, $k);
				}
			}
			catch(Exception $e)
			{
				throw new Exception("Error products: " . $e->getMessage(), 4);
			}
		}
		else
		{
			throw new Exception("Error order id", 2);
		}
	}

	protected function AddAddons($oid = 0, $pid = 0, $hash = 'XXX')
	{
		$this->AddonsIds = null;

		if($oid > 0 && $pid > 0)
		{
			try
			{
				$db = Db::GetInstance();

				echo "<pre>";
				print_r($this->Addons);
				print_r($hash);

				foreach($this->Addons[$hash] as $k => $v)
				{
					print_r($v);

					$r = $db->Pdo->prepare("INSERT INTO order_product_addon(rf_orders, rf_order_product, product, price, quantity, sale) VALUES(:rf1, :rf2, :product, :price, :quantity, :sale)");
					$r->execute([':rf1' => $oid, ':rf2' => $pid, ':product' => $v['id'], ':price' => $v['price'], ':quantity' => $v['quantity'], ':sale' => $v['sale']]);
					$this->AddonsIds[] = $db->Pdo->lastInsertId();

				}
			}
			catch(Exception $e)
			{
				throw new Exception("Error addons: " . $e->getMessage(), 4);
			}
		}
		else
		{
			throw new Exception("Error order id", 2);
		}
	}

	/**
	 * Cart price
	 *
	 * @return float Cart products price with addons
	 */
	function Checkout()
	{
		$cost = 0;
		foreach ($this->Products as $k => $p)
		{
			$cost += $p['price'] * (int) $p['quantity'];
			$cost += $this->AddonsCost($k, $p['quantity']);
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
}

/*
use MyApp\App\Orders\Cart;
use MyApp\App\Orders\CartDb;

session_start();

try
{
	// Cart sum: 37.16
	$c = new Cart();
	$c->Clear();
	$hash = $c->AddProduct(1, 1, 13.50);
	$c->ProductPlus($hash);
	$c->AddAddon(1, 16, 2, 2.54);
	$c->AddonPlus(1, 16, 1);
	$c->AddonMinus(1, 16, 1);
	$c->Show();
	$price = $c->Checkout();
	echo $price;

	// Save in database (from Cart session)
	$cdb = new CartDb();
	$price = $cdb->Checkout();
	$orderid = $cdb->CreateOrder($price, 'Złota 13/9');
}
catch(Exception $e)
{
	echo $e->getMessage();
}
*/
?>