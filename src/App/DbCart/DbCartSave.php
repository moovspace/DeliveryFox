<?php
namespace MyApp\App\DbCart;

use \Exception;
use PhpApix\Mysql\Db;

class DbCartSave
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
	 * Create orders in database from DbCart class
	 * Cart in: $_SESSION['cart']
	 *
	 * @param float $price Checkout price
	 * @param string $address Delivery address
	 * @param string $cupon Coupon code
	 * @return string Order id
	 */
	function CreateOrder($price, $name, $address, $pick_up, $mobile, $info, $payment, $delivery = 0, $cupon = '')
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

		if($delivery < 0)
		{
			$delivery = 0;
		}

		$orderid = (int) $this->CreateOrderId($price, $name, $address, $pick_up , $mobile, $info, (int) $payment, $delivery, $cupon);

		if($orderid > 0)
		{
			$this->AddProducts($orderid);
		}
		else
		{
			throw new Exception("Error order id", 2);
		}


		return $orderid;
	}

	protected function CreateOrderId($price = 0, $name = '', $address, $pick_up = '', $mobile = '', $info = '', $payment = 3, $delivery = 0, $cupon = '')
	{
		try
		{
			$ip = $_SERVER['REMOTE_ADDR'];

			$db = Db::GetInstance();
			$r = $db->Pdo->prepare("INSERT INTO orders(name, price, address, coupon, delivery_cost, pick_up_time, mobile, info, payment, ip) VALUES(:name, :price, :address, :cupon, :delivery, :pick, :mobile, :info, :payment, :ip)");
			$r->execute([':name' => $name, ':price' => $price, ':address' => $address, ':cupon' => $cupon, ':delivery' => $delivery, ':pick' => $pick_up, ':mobile' => $mobile, ':info' => $info, ':payment' => $payment, ':ip' => $ip]);
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
					$pr = $this->GetProduct($v['id']);

					if(!empty($pr))
					{
						if($pr['on_sale'] > 0)
						{
							if($pr['price_sale'] < $pr['price'])
							{
								$pr['price'] = $pr['price_sale'];
							}
						}

						$r = $db->Pdo->prepare("INSERT INTO order_product(rf_orders, product, price, quantity, sale,attr) VALUES(:rf, :product, :price, :quantity, :sale, :attr)");
						$r->execute([':rf' => $oid, ':product' => $v['id'], ':price' => $pr['price'], ':quantity' => $v['quantity'], ':sale' => $pr['on_sale'], ':attr' => $v['attr']]);
						$this->ProductsIds[] = $pid = $db->Pdo->lastInsertId();
						// Add product addons
						$this->AddAddons($oid, $pid, $k);
					}
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

	protected function AddAddons($oid = 0, $pid = 0, $hash)
	{
		$this->AddonsIds = null;

		if($oid > 0 && $pid > 0 && !empty($hash))
		{
			try
			{
				$db = Db::GetInstance();

				if(!empty($this->Addons[$hash])){
					foreach($this->Addons[$hash] as $v)
					{
						$pr = $this->GetProduct($v['id']);

						if(!empty($pr))
						{
							if($pr['on_sale'] > 0)
							{
								if($pr['price_sale'] < $pr['price'])
								{
									$pr['price'] = $pr['price_sale'];
								}
							}

							$r = $db->Pdo->prepare("INSERT INTO order_product_addon(rf_orders, rf_order_product, product, price, quantity, sale) VALUES(:rf1, :rf2, :product, :price, :quantity, :sale)");
							$r->execute([':rf1' => $oid, ':rf2' => $pid, ':product' => $v['id'], ':price' => $pr['price'], ':quantity' => $v['quantity'], ':sale' => $pr['on_sale']]);
							$this->AddonsIds[] = $db->Pdo->lastInsertId();
						}
					}
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
}

/*
use MyApp\App\Orders\DbCart;
use MyApp\App\Orders\DbCartSave;

session_start();

try
{
	// Cart sum: 37.16
	$c = new DbCart();
	$c->Clear();

	// Add product
	$hash = $c->AddProduct(2,1);
	$c->AddAddon($hash,26,2);

	$c->Show();

	echo $price = $c->Checkout();

	// Save in database (from Cart session)
	$save = new DbCartSave();
	echo $orderid = $save->CreateOrder($c->Checkout(), 'Kucza 1', $c->DeliveryCost, '');
}
catch(Exception $e)
{
	echo $e->getMessage();
}
*/
?>