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
use MyApp\Web\Currency;

class OrderUserView extends Component
{
	static public $ErrorUpdate = 0;

	static function Menu()
	{
		$t = new Trans('/src/Web/AdminPanel/Lang', 'pl');

		$t_name = $t->Get('OR_ORDERS');
		$t_title = $t->Get('OR_ORDERS');
		$t_edit = $t->Get('OR_ORDER');
		$t_edit_title = $t->Get('OR_ORDER');

		$menu = new Menu('/panel/delivery', $t_name, $t_title, '<i class="fas fa-truck"></i>', '<i class="fas fa-truck"></i>');
		if(parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH) == '/panel/order-delivery')
		{
			$menu->AddLink('/panel/order-delivery', $t_edit, $t_edit_title, '<i class="fas fa-box"></i>', '<i class="fas fa-box"></i>');
		}
		return $menu;
	}

	static function GetOrderHtml()
	{
		$t = new Trans('/src/Web/Page/ProductList/Lang', 'pl');

		if(!empty($_GET['id']))
		{
			$id = (int) $_GET['id'];

			$order = self::GetOrder($id);
			$order_products = self::GetOrderProducts($id);
			$order_addons = self::GetOrderAddons($id);

			// print_r($order);
			// print_r($order_products);
			// print_r($order_addons);

			if($order['payment'] == 1){
				$payment = '<i class="fas fa-money-bill-wave"></i> '.$t->Get('CH_PAY1');
			}
			if($order['payment'] == 2){
				$payment = '<i class="fas fa-credit-card"></i> '.$t->Get('CH_PAY2');
			}
			if($order['payment'] == 3){
				$payment = '<i class="fas fa-utensils"></i> '.$t->Get('CH_PAY3').'  ' . $order['pick_up_time'];
			}

			$comment = '';
			if(!empty($order['info'])){
				$comment = '<div class="thin"> <b> '.$t->Get('CH_COMMENT').'</b> </br>'.$order['info'].'</div>';
			}

			$h = '<div id="printarea">';
			$h .= '
				<h3> <span>'.$t->Get('CH_ID').'</span> <strong>'.$order['id'].'</strong> <span id="curr-status"> '.$order['status'].'</span> </h3>
				<div id="payment">'.$payment.'</div>
				<div class="thin"> <b>'.$t->Get('CH_COUPON').'</b> '.$order['coupon'].' </br> <b> '.$t->Get('CH_DATE').'</b> '.$order['time'].' </br> <b> '.$t->Get('CH_IP').'</b> '.$order['ip'].'</div>
				<h1> '.$t->Get('CH_DELIVERY_ADDR').'</h1>
				<div id="delivery-address">
					<div class="thin"> <b>'.$t->Get('CH_IMIE').'</b> '.$order['name'].' </br> <b> '.$t->Get('CH_ADDRESS').'</b> '.$order['address'].' </br> <b>'.$t->Get('CH_MOBILE').'</b> '.$order['mobile'].'</div>
					'.$comment.'
				</div>

				<h1> '.$t->Get('CH_ORDER_LIST').'</h1>
			';

			foreach($order_products as $pr)
			{
				$addons = '';
				foreach($order_addons as $ad)
				{
					if($ad['rf_order_product'] == $pr['id'])
					{
						$addons .= '<div class="flex"> <div>'.$ad['pr_name'].' (ID-'.$ad['id'].')</div> <div>'.$ad['pr_size'].'</div> <div> <b>'.$ad['quantity'].'</b> szt.</div> <div>'.$ad['price'].' '.Currency::MAIN.'</div> </div>';
					}
				}

				if(empty($addons)){
					$addons = '<div class="empty-addons"> '.$t->Get('CH_NO_ADDONS').' </div>';
				}

				$attr = self::GetOrderProductAttr($pr['attr']);

				$h .= '
					<div class="pr">
						<div class="flex">
							<div>'.$pr['pr_name'].' (ID-'.$pr['id'].')</div> <div>'.$pr['pr_size'].'</div> <div>'.$attr.'</div> <div><b>'.$pr['quantity'].'</b> szt.</div> <div>'.$pr['price'].' '.Currency::MAIN.'</div>
						</div>
						<div class="ad">
							<h4> '.$t->Get('CH_ADDONS').'</h4>
							'.$addons.'
						</div>
					</div>
				';
			}

			$h .= '
				<h3> '.$t->Get('CH_DELIVERY_COST').'  <span style="float: right">'.$order['delivery_cost'].' '.Currency::MAIN.' </span> </h3>
				<h3> '.$t->Get('CH_ORDER_COST').'  <span style="float: right">'.$order['price'].' '.Currency::MAIN.'</span> </h3>
			';

			$h .= '</div>';

			return $h;
		}else{
			return '<h3>'.$t->Get('CH_ERR_ID').'</h3>';
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
					return '<div class="attr">' . $row[0]['name'] . '</div>';
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

	static function Data($arr = null)
	{
		try
		{
			$user = new User(); // Is User logedd

			// If not admin
			if($user->Role() != 'admin' && $user->Role() != 'worker' && $user->Role() != 'user' && $user->Role() != 'driver')
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
		$menu['order'] = self::GetOrderHtml();
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
		if(!empty($_GET['id'])){
			return 'Order ID: '. (int) $_GET['id'];
		}else{
			return 'Error order id';
		}
	}

	static function Description()
	{
		return 'Order detail';
	}

	static function Keywords()
	{
		return 'single order';
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