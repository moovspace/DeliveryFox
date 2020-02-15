<?php
namespace MyApp\Web\AdminPanel\View;

use Exception;
use MyApp\App\Component;
use MyApp\App\Menu\Menu;
use MyApp\App\Translate\Trans;
use MyApp\Web\AdminPanel\LeftMenu;
use MyApp\Web\AdminPanel\User;
use MyApp\Web\AdminPanel\TopMenu;
use MyApp\Web\AdminPanel\Footer;

class AddProductView extends Component
{
	static public $ErrorUpdate = 0;

	static function ImageHash()
	{
		if(empty($_SESSION['imagehash'])){
			$_SESSION['imagehash'] = md5(microtime());
		}
		return $_SESSION['imagehash'];
	}

	static function isImage()
	{
		$mime = $_FILES['file']['type'];
		$allowed = array("image/jpeg");
		return in_array($mime, $allowed);
	}

	static function Update()
	{
		if(!empty($_POST['product']))
		{
			if(!empty($_FILES['file']['tmp_name']))
			{
				// Random image name, copy to product id
				$img = self::ImageHash();

				// Upload avatar
				if(self::isImage())
				{
					echo move_uploaded_file($_FILES['file']['tmp_name'], 'media/tmp/' . $img. '.jpg');
				}
				else
				{
					return -3;
				}
			}

			try
			{
				foreach($_POST as $k => $v)
				{

				}

				// Error
				return 1;
			}
			catch(Exception $e)
			{
				if ($e->errorInfo[1] == 1062) {
					return -2; // username exist
				}
				return -1;
			}

		}
	}

	static function Data($arr = null)
	{
		try
		{
			$user = new User();

			// If not admin
			if($user->Role() != 'admin')
			{
				throw new Exception("Error user privileges", 666);
			}

			// Update database
			$user->ErrorUpdate = self::Update();
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

		if(!empty($_POST))
		{
			if($user->ErrorUpdate == 0){
				$arr['error'] = '<span class="green"> '.$t->Get('ERR_NOTHING').' </span>';
			}else if($user->ErrorUpdate == 1){
				$arr['error'] = '<span class="green"> '.$t->Get('UPDATED').' </span>';
			}else if($user->ErrorUpdate == -3){
				$arr['error'] = '<span class="red"> '.$t->Get('ERR_IMAGE').' </span>';
			}else if($user->ErrorUpdate == -2){
				$arr['error'] = '<span class="red"> '.$t->Get('ERR_USERNAME').' </span>';
			}else if($user->ErrorUpdate < 0){
				$arr['error'] = '<span class="red"> '.$t->Get('ERR_UPDATE').' </span>';
			}
		}

		// Import component
		$menu['top'] = TopMenu::Show($arr);
		$menu['left'] = LeftMenu::Show();
		$menu['footer'] = Footer::Show($arr);;

		// Retuen html
		return self::Html($arr, $menu);
	}

	static function Html($arr = null, $html = '')
	{
		if(empty($_POST['name'])) { $_POST['name'] = ''; }
		if(empty($_POST['size'])) { $_POST['size'] = ''; }
		if(empty($_POST['price'])) { $_POST['price'] = '0.00'; }
		if(empty($_POST['price_sale'])) { $_POST['price_sale'] = '0.00'; }
		if(empty($_POST['category'])) { $_POST['category'] = 0; }
		if(empty($_POST['rf_attr'])) { $_POST['rf_attr'] = 0; }
		if(empty($_POST['on_sale'])) { $_POST['on_sale'] = 0; }
		if(empty($_POST['visible'])) { $_POST['visible'] = 0; }
		if(empty($_POST['addon_category'])) { $_POST['addon_category'] = 0; }
		if(empty($_POST['addon_quantity'])) { $_POST['addon_quantity'] = 5; }
		if(empty($_POST['parent'])) { $_POST['parent'] = 0; }
		if(empty($_POST['stock_status'])) { $_POST['stock_status'] = 'instock'; }
		// Image
		$img = '/image.png';
		if(!empty(self::ImageHash()))
		{
			$img = '/media/tmp/'.self::ImageHash().'.jpg';
		}

		return '
		'.$html['top'].'
		<div id="box">
			'.$html['left'].'
			<div id="box-right">
				<h1> '.$arr['trans']->Get('EP_ADD_PRODUCT').' </h1>

				<error id="error">
					' . $arr['error'] . '
				</error>

				<div class="box-wrap">
					<form method="post" enctype="multipart/form-data">

						<h3> '.$arr['trans']->Get('EP_FOTO').' </h3>

						<div class="w-50">
							<img id="product-image" src="'.$img.'" onerror="imgErrorProduct(this)">
						</div>
						<div class="w-50">
							<label> '.$arr['trans']->Get('LB_AVATAR').' </label>
							<input type="file" name="file" accept="image/jpeg" onchange="SetProductImage(this)">
						</div>

						<line></line>

						<h3> '.$arr['trans']->Get('EP_TYPE').' </h3>

						<div class="w-50">
							<label> '.$arr['trans']->Get('EP_TYPE_VARIANT').' </label>
							<select name="category" data-val="'.$_POST['parent'].'">
								<option value="0"> '.$arr['trans']->Get('EP_TYPE_MAIN').' </option>
								<option value="1">Pizza hawajska Mała 35cm</option>
							</select>
						</div>

						<line></line>

						<h3> '.$arr['trans']->Get('EP_INFO').' </h3>

						<div class="w-50">
							<label> '.$arr['trans']->Get('EP_NAME').' </label>
							<input type="text" name="name" placeholder="'.$arr['trans']->Get('EP_NAME_PL').'" value="' . $_POST['name'] . '">
						</div>

						<div class="w-50">
							<label> '.$arr['trans']->Get('EP_SIZE').' </label>
							<input type="text" name="size" placeholder="'.$arr['trans']->Get('EP_SIZE_PL').'" value="' . $_POST['size'] . '">
						</div>

						<div class="w-50">
							<label> '.$arr['trans']->Get('EP_CATEGORY').' </label>
							<select name="category" data-val="'.$_POST['category'].'">
								<option value="1">Kebab</option>
								<option value="0">Pizza</option>
							</select>
						</div>

						<div class="w-50">
							<label> '.$arr['trans']->Get('EP_ATTR').' </label>
							<select name="rf_attr" data-val="'.$_POST['rf_attr'].'">
								<option value="0"> '.$arr['trans']->Get('EP_ATTR_CHOSE').' </option>
								<option value="1">Sos</option>
								<option value="2">Napoje 330ml</option>
							</select>
						</div>

						<line></line>

						<h3> '.$arr['trans']->Get('EP_PRICE_TITLE').' </h3>

						<div class="w-50">
							<label> '.$arr['trans']->Get('EP_PRICE').' </label>
							<input type="text" name="price" placeholder="'.$arr['trans']->Get('EP_PRICE_PL').'" value="' . $_POST['price'] . '">
						</div>

						<div class="w-50">
							<label> '.$arr['trans']->Get('EP_SALE_PRICE').' </label>
							<input type="text" name="price_sale" placeholder="'.$arr['trans']->Get('EP_SALE_PRICE_PL').'" value="' .$_POST['price_sale'] . '">
						</div>

						<line></line>

						<div class="w-50">
							<label> '.$arr['trans']->Get('EP_SALE_ON').' </label>
							<select name="on_sale" data-val="'.$_POST['on_sale'].'">
								<option value="0"> '.$arr['trans']->Get('EP_OFF').' </option>
								<option value="1"> '.$arr['trans']->Get('EP_ON').' </option>
							</select>
						</div>

						<line></line>

						<h3> '.$arr['trans']->Get('EP_VISIBLE').' </h3>

						<div class="w-50">
							<label> '.$arr['trans']->Get('EP_VISIBLE_ON').' </label>
							<select name="visible" data-val="'.$_POST['visible'].'">
								<option value="1"> '.$arr['trans']->Get('EP_YES').' </option>
								<option value="0"> '.$arr['trans']->Get('EP_NO').' </option>
							</select>
						</div>

						<div class="w-50">
							<label> '.$arr['trans']->Get('EP_INSTOCK_ON').' </label>
							<select name="visible" data-val="'.$_POST['stock_status'].'">
								<option value="instock"> '.$arr['trans']->Get('EP_YES').' </option>
								<option value="outofstock"> '.$arr['trans']->Get('EP_NO').' </option>
							</select>
						</div>

						<line></line>

						<h3> '.$arr['trans']->Get('EP_ADDONS').' </h3>

						<div class="w-50">
							<label> '.$arr['trans']->Get('EP_CATEGORY').' </label>
							<select name="addon_category" data-val="'.$_POST['addon_category'].'">
								<option value="0"> '.$arr['trans']->Get('EP_ATTR_CHOSE').' </option>
								<option value="1">Dodatki pizza</option>
								<option value="2">Dodatki kebab</option>
							</select>
						</div>

						<div class="w-50">
							<label> '.$arr['trans']->Get('EP_QUANTITY').' </label>
							<input type="text" name="addon_quantity" placeholder="'.$arr['trans']->Get('EP_QUANTITY_PL').'" value="' .$_POST['addon_quantity'] . '">
						</div>

						<line></line>

						<input type="submit" name="product" value="'.$arr['trans']->Get('EP_CREATE').'" class="btn float-right">
					</form>
				</div>

			</div>
		</div>
		'.$html['footer'].'
		';
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