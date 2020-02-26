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

		if(!empty($_GET['id'])){
			$stat = self::GetStatus($_GET['id']);
			$time = self::GetTime($_GET['id']);
		}

		if($stat == 'canceled'){
			$status = '<div class="status-btn status-btn-canceled"> '.$t->Get('ST_CANCELED').' </div>';
		}else if($stat == 'failed'){
			$status = '<div class="status-btn status-btn-failed"> '.$t->Get('ST_FAILED').' </div>';
		}else if($stat == 'processing'){
			$status = '<div class="status-btn status-btn-processing"> '.$t->Get('ST_PROCESSING').' </div>';
		}else if($stat == 'delivery'){
			$status = '<div class="status-btn status-btn-delivery"> '.$t->Get('ST_DELIVERY').' </div>';
		}else if($stat == 'completed'){
			$status = '<div class="status-btn status-btn-completed"> '.$t->Get('ST_COMPLETED').' </div>';
		}else if($stat == 'pending'){
			$status = '<div class="status-btn status-btn-pending"> '.$t->Get('ST_PENDING').' </div> <p> '.$t->Get('ST_WAIT').' </p>';
		}else{
			$status = '<div class="status-btn status-btn-pending"> Error ID </div>';
		}

		$h = '
		<div class="checkout-box">

			<h1> '.$t->Get('ORDER_STATUS').' </br> <small style="font-size: 13px;"> '.$t->Get('ORDER_STATUS_INFO').'</small> </h1>

			<div id="status-box">
				<img src="/media/img/soup.png">
				<h3> '.$t->Get('ORDER_ID').' </h3>
				<h2>'.$_GET['id'].'</h2>
				<h3> '.$t->Get('ORDER_DATE').' </h3>
				<h2>'.$time.'</h2>
				'.$status.'
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

		<script>
			setInterval(() => { location.reload(); }, 300000);
		</script>
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

	static function GetStatus($id){
		try
		{
			$id = (int) $id;
			$db = Db::getInstance();
			$r = $db->Pdo->query("SELECT * FROM orders WHERE id = " . $id . " AND time > NOW() - INTERVAL 7 DAY");
			$row = $r->fetchAll();
			if(!empty($row)){
				return $row[0]['status'];
			}else{
				return 'error';
			}
		}
		catch(Exception $e)
		{
			return 'pending';
		}
	}

	static function GetTime($id){
		try
		{
			$id = (int) $id;
			$db = Db::getInstance();
			$r = $db->Pdo->query("SELECT * FROM orders WHERE id = " . $id . " AND time > NOW() - INTERVAL 7 DAY");
			$row = $r->fetchAll();
			if(!empty($row)){
				return $row[0]['time'];
			}else{
				return '0000-00-00';
			}
		}
		catch(Exception $e)
		{
			return '0000-00-00';
		}
	}
}
?>