<?php
namespace MyApp\Web\AdminPanel\View;

use Exception;
use PhpApix\Mysql\Db;
use MyApp\App\Component;
use MyApp\App\Menu\Menu;
use MyApp\App\Translate\Trans;
use MyApp\Web\AdminPanel\LeftMenu;
use MyApp\Web\AdminPanel\User;
use MyApp\Web\AdminPanel\TopMenu;
use MyApp\Web\AdminPanel\Footer;

class OrderView extends Component
{
	static public $ErrorUpdate = 0;

	static function Menu()
	{
		$t = new Trans('/src/Web/AdminPanel/Lang', 'pl');

		$t_name = $t->Get('OR_ORDERS');
		$t_title = $t->Get('OR_ORDERS');
		$t_edit = $t->Get('OR_ORDER');
		$t_edit_title = $t->Get('OR_ORDER');

		$menu = new Menu('/panel/orders', $t_name, $t_title, '<i class="fas fa-truck-monster"></i>', '<i class="fas fa-truck-monster"></i>');
		if(parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH) == '/panel/order')
		{
			$menu->AddLink('/panel/order', $t_edit, $t_edit_title, '<i class="fas fa-boxes"></i>', '<i class="fas fa-boxes"></i>');
		}
		return $menu;
	}

	static function GetOrderHtml($id = 0)
	{
		if(!empty($id))
		{
			$order = self::GetOrder($id);
			$order_products = self::GetOrderProducts($id);
			$order_addons = self::GetOrderAddons($id);

			// print_r($order);
			// print_r($order_products);
			// print_r($order_addons);

			if($order['payment'] == 1){
				$payment = '<i class="fas fa-money-bill-wave"></i> Płatność gotówką przy dostawie.';
			}
			if($order['payment'] == 2){
				$payment = '<i class="fas fa-credit-card"></i> Płatność kartą przy dostawie.';
			}
			if($order['payment'] == 3){
				$payment = '<i class="fas fa-utensils"></i> Odbiór osobist w lokalu. Godzina: ' . $order['pick_up_time'];
			}

			$h = '<div id="printarea">';
			$h .= '
				<h3> <span>Order ID:</span> <strong>'.$order['id'].'</strong> <span id="curr-status"> '.$order['status'].'</span> </h3>
				<div id="payment">'.$payment.'</div>
				<div class="thin"> <b>Date:</b> '.$order['time'].' </br> <b>IP address:</b> '.$order['ip'].'</div>
				<h1>Delivery address</h1>
				<div id="delivery-address">
					<div class="thin"> <b>Imię:</b> '.$order['name'].' </br> <b>Adres:</b> '.$order['address'].' </br> <b>Tel:</b> '.$order['mobile'].'</div>
					<div class="thin"> <b>Komentarz do zamowienia:</b> </br>'.$order['info'].'</div>
				</div>

				<h1>Order list</h1>
			';

			foreach($order_products as $pr)
			{
				$addons = '';
				foreach($order_addons as $ad)
				{
					if($ad['rf_order_product'] == $pr['id'])
					{
						$addons .= '<div class="flex"> <div>'.$ad['pr_name'].'</div> <div>'.$ad['pr_size'].'</div> <div> <b>'.$ad['quantity'].'</b> szt.</div> <div>'.$ad['price'].' PLN</div> </div>';
					}
				}

				if(empty($addons)){
					$addons = '<div class="empty-addons"> Brak dodatków</div>';
				}

				$attr = self::GetOrderProductAttr($pr['attr']);

				$h .= '
					<div class="pr">
						<div class="flex">
							<div>'.$pr['pr_name'].'</div> <div>'.$pr['pr_size'].'</div> <div>'.$attr.'</div> <div><b>'.$pr['quantity'].'</b> szt.</div> <div>'.$pr['price'].' PLN</div>
						</div>
						<div class="ad">
							<h4>Addons:</h4>
							'.$addons.'
						</div>
					</div>
				';
			}

			$h .= '
				<h2> Order delivery cost: <span style="float: right">'.$order['delivery_cost'].' PLN </span> </h2>
				<h2> Order cost: <span style="float: right">'.$order['price'].' PLN</span> </h2>

				<h1> Change order status </h1>
				<div id="actions">
					<form method="POST" action="">
						<select name="status" id="select-status">
							<option value=""> Choose status </option>
							<option value="processing"> Processing </option>
							<option value="delivery"> Delivery </option>
							<option value="completed"> Completed </option>
							<option value="canceld"> Canceled </option>
							<option value="failed"> Failed </option>
							<option value="pending"> Pending (default) </option>
						</select>
						<input type="submit" name="update" value="Update status" id="submit-status">
					</form>
				</div>
			';
			$h .= '</div>';

			return $h;
		}
	}

	static function GetOrder($id = 0)
	{
		// Search
		if(!empty($id))
		{
			try
			{
				$db = Db::getInstance();
				$r = $db->Pdo->prepare("SELECT * FROM orders WHERE id = :id");
				$r->execute([':id' => $id]);
				$row = $r->fetchAll();
				if(!empty($row))
				{
					return $row[0];
				}
			}
			catch(Exception $e)
			{
				return [];
			}
		}
		return [];
	}

	static function GetOrderProductAttr($id = 0)
	{
		// Search
		if(!empty($id))
		{
			try
			{
				$db = Db::getInstance();
				$r = $db->Pdo->prepare("SELECT * FROM attr_name WHERE id = :id");
				$r->execute([':id' => $id]);
				$row = $r->fetchAll();
				if(!empty($row))
				{
					return $row[0]['name'];
				}
			}
			catch(Exception $e)
			{
				return '';
			}
		}
		return '';
	}

	static function GetOrderProducts($id = 0)
	{
		// Search
		if(!empty($id))
		{
			try
			{
				$db = Db::getInstance();
				$r = $db->Pdo->prepare("SELECT order_product.*, product.name as pr_name, product.size as pr_size FROM order_product LEFT JOIN product ON order_product.product = product.id WHERE order_product.rf_orders = :id");
				$r->execute([':id' => $id]);
				return $r->fetchAll();
			}
			catch(Exception $e)
			{
				echo $e->getMessage();
				return [];
			}
		}
		return [];
	}

	static function GetOrderAddons($id = 0)
	{
		// Search
		if(!empty($id))
		{
			try
			{
				$db = Db::getInstance();
				$r = $db->Pdo->prepare("SELECT order_product_addon.*, product.name as pr_name, product.size as pr_size FROM order_product_addon LEFT JOIN product ON order_product_addon.product = product.id WHERE order_product_addon.rf_orders = :id");
				$r->execute([':id' => $id]);
				return $r->fetchAll();
			}
			catch(Exception $e)
			{
				echo $e->getMessage();
				return [];
			}
		}
		return [];
	}

	static function Del()
	{
		if(!empty($_GET['delete']))
		{
			try
			{
				$id = (int) $_GET['delete'];

				if($id > 0)
				{
					$db = Db::getInstance();
					$r = $db->Pdo->prepare("UPDATE orders SET visible = 0 WHERE id = $id");
					$r->execute();
					$ok = $r->rowCount();

					return $ok;
				}else{
					return -3;
				}
			}
			catch(Exception $e)
			{
				return -1; // error
			}
		}
	}

	static function Data($arr = null)
	{
		try
		{
			$user = new User(); // Is User logedd

			// If not admin
			if($user->Role() != 'admin')
			{
				throw new Exception("Error user privileges", 666);
			}
		}
		catch(Exception $e)
		{
			if($e->getCode() == 666){
				// Error user
				header('Location: /logout');
			}else{
				echo $e->getMessage();
			}
		}

		return  $user;
	}

	static function Show($arr = null)
	{
		$t = new Trans('/src/Web/AdminPanel/Lang', 'pl');

		// Get data
		$user = self::Data();

		// Get user data
		$arr['user'] = $user->GetUser();
		$arr['user_info'] = $user->GetUserInfo();
		$arr['error'] = '';
		$arr['trans'] = $t;

		// Import component
		$menu['top'] = TopMenu::Show($arr);
		$menu['left'] = LeftMenu::Show();
		$menu['footer'] = Footer::Show($arr);
		// Html order
		$menu['order'] = self::GetOrderHtml($_GET['id']);
		// Retuen html
		return self::Html($arr, $menu);
	}

	static function Html($arr = null, $html = '')
	{
		return '
		'.$html['top'].'
		<div id="box">
			'.$html['left'].'
			<div id="box-right">
				<h1> '.$arr['trans']->Get('OR_ORDER').'  </h1>
				<error id="error">
					' . $arr['error'] . '
				</error>
				<div class="box-wrap">
					'.$html['order'].'
				</div>
			</div>
		</div>
		'.$html['footer'];
	}

	static function Title()
	{
		return 'Profil';
	}

	static function Description()
	{
		return 'Profil settings.';
	}

	static function Keywords()
	{
		return 'profil, settings';
	}

	static function Head()
	{
		return [
			'<link rel="stylesheet" href="/src/Web/AdminPanel/panel.css">',
			'<script defer src="/src/Web/AdminPanel/panel.js"></script>'
		];
	}
}
?>