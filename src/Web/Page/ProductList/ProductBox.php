<?php
namespace MyApp\Web\Page\ProductList;

use Exception;
use MyApp\Web\Page\Perpage;
use PhpApix\Mysql\Db;

class ProductBox
{
	static function Show()
	{
		// Url params
		$p = self::GetParams();
		// Category slug
		$cat = '';
		if(!empty($p[1]))
		{
			$cat = $p[1];
		}
		// Pagination
		$page = 1;
		if(!empty($_GET['page']))
		{
			$page = (int) $_GET['page'];
		}
		// Perpage
		$perpage = Perpage::MAIN;
		if(!empty($_GET['perpage']))
		{
			$perpage = (int) $_GET['perpage'];
		}
		if($perpage < 1) { $perpage = (int) Perpage::MAIN; }
		// Pages
		if($page < 1) { $page = 1; }
		$back = $page - 1;
		if($back < 1) { $back = 1; }
		$next = $page + 1;

		$q = ''; // Search words
		if(!empty($_GET['q']))
		{
			$q = $_GET['q'];
		}

		$products = self::GetProducts($cat, $page, $perpage, $q);

		$h = '
			<div class="products">
				<!-- <div class="h1"> Products </div> -->

				<div class="list">';

				if(empty($products)){
					$h .= '<notify>No products available</notify>';
				}

				foreach ($products as $k => $v)
				{
					$sale_off = '';
					if($v['on_sale'] == 0)
					{
						$sale_off = 'sale-off';
					}

					$price = $v['price'];
					if($v['on_sale'] > 0)
					{
						if($v['price_sale'] < $v['price'])
						{
							$price = $v['price_sale'];
						}
					}

					$h .= '<div class="product">
						<div class="sale '.$sale_off.'"> <i class="fas fa-grin-stars"></i> Sale! </div>
						<div class="img">
							<img src="/media/product/'.$v['id'].'.jpg" onerror="ErrorProductImage(this)">
						</div>
						<div class="name">'.$v['name'].'</div>
						<div class="price"><span>'.number_format((float) $price, 2).'</span> <curr>PLN</curr></div>
						<div class="add-to-cart" onclick="ShowAddToCart(\''.$v['id'].'\')"> <span>ZAMÓW</span> <i class="fas fa-chevron-right"></i> </div>
					</div>';
				}

				$h1 = '<div class="product">
						<div class="sale sale-off"> <i class="fas fa-grin-stars"></i> Sale! </div>
						<div class="img">
							<img src="/media/img/food-0.jpg">
						</div>
						<div class="name">Krewetki meksykańskie</div>
						<div class="price"><span>19.99</span> <curr>PLN</curr></div>
						<div class="add-to-cart"> <span>BUY</span> <i class="fas fa-chevron-right"></i> </div>
					</div>
					<div class="product">
						<div class="sale"> <i class="fas fa-grin-stars"></i> Sale! </div>
						<div class="img">
							<img src="/media/img/food-1.jpg">
						</div>
						<div class="name">Tortilla vege</div>
						<div class="price"><span>109.15</span> <curr>PLN</curr></div>
						<div class="add-to-cart"> <span>BUY</span> <i class="fas fa-chevron-right"></i> </div>
					</div>
					<div class="product">
						<div class="sale"> <i class="fas fa-grin-stars"></i> Sale! </div>
						<div class="img">
							<img src="/media/img/food-2.jpg">
						</div>
						<div class="name">Spaghetti mushrom</div>
						<div class="price"><span>19.99</span> <curr>PLN</curr></div>
						<div class="add-to-cart"> <span>BUY</span> <i class="fas fa-chevron-right"></i> </div>
					</div>

					<div class="product">
						<div class="img">
							<img src="/media/img/food-3.jpg">
						</div>
						<div class="name">Quasadilla</div>
						<div class="price"><span>19.99</span> <curr>PLN</curr></div>
						<div class="add-to-cart"> <span>BUY</span> <i class="fas fa-chevron-right"></i> </div>
					</div>
					<div class="product">
						<div class="img">
							<img src="/media/img/food-4.jpg">
						</div>
						<div class="name">Kuleczki panierowane</div>
						<div class="price"><span>19.99</span> <curr>PLN</curr></div>
						<div class="add-to-cart"> <span>BUY</span> <i class="fas fa-chevron-right"></i> </div>
					</div>
					<div class="product">
						<div class="img">
							<img src="/media/img/food-5.jpg">
						</div>
						<div class="name">Szaszłyki z kaczki</div>
						<div class="price"><span>19.99</span> <curr>PLN</curr></div>
						<div class="add-to-cart"> <span>BUY</span> <i class="fas fa-chevron-right"></i> </div>
					</div>';

				$h .= '</div>';

				if(!empty($products)){

					$h .= '
					<div class="product-pagine">
						<a href="/category/'.$cat.'?perpage='.$perpage.'&page='.$back.'"> <i class="fas fa-chevron-left"></i> </a> <span id="product-curr-page"> '.$page.' </span> <a href="/category/'.$cat.'?perpage='.$perpage.'&page='.$next.'"> <i class="fas fa-chevron-right"></i> </a>
					</div>';
				}

				$h .= '<!-- Add to cart popup -->
					<div id="black-hole" data-lang="'.$_SESSION['lang'].'">
						<div class="close-it" onclick="this.parentNode.style.display = \'none\';"> <i class="fas fa-times"></i> </div>
						<div id="add-product-fixed">
							<div class="top">
							<img src="/media/img/food.png" id="pr-img">
							<div class="about">
								<div class="name" id="pr-name"> <!-- Pizza hawajska z warzywami --> </div>
								<p class="desc" id="pr-desc">
								<!-- As a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using , making it look like readable English. And a search for will uncover many web sites still in their infancy. -->
								</p>
							</div>
							<div class="right">
								<div class="price"> <span id="pr-price" data-price="0.00">0.00</span> <curr>PLN</curr> </div>
								<div id="product-quantity">
									<span class="plus" onclick="PlusProduct(this)"> <i class="fas fa-plus"></i> </span>
									<span class="quantity" id="product-quantity-count">1</span>
									<span class="minus" onclick="MinusProduct(this)"> <i class="fas fa-minus"></i> </span>
								</div>
								<div class="size" id="pr-attr">
									<!--
									<select class="size-btn" id="pr-attr-id">
										<option>Sos łagodny</option>
									</select>
									-->
								</div>
								<div class="add-to-cart-now" id="pr-id" onclick="AddToCartProduct(this)" data-id="0"> <i class="fas fa-cart-plus"></i> <span>DO KOSZYKA</span> </div>
							</div>
						</div>
						<div class="size" id="pr-size">
							<!--
								<div class="size-btn size-btn-active"> Size 15cm </div>
								<div class="size-btn" onclick="SetProductSize(this)" data-price="0"> Size 25cm </div>
							-->
						</div>
						<div class="addon-title" id="hide-addon-title">Dodatki</div>
						<div class="addons" id="pr-addons">
						<notify> Produkt bez dodatków. </notify>';

						// foreach(['','','','','','','','',''] as $v)
						// {
						// 	$h .= '<div class="addon-btn" data-id="0">
						// 		<div class="title">
						// 			<name>Ananas</name> <price>2.50</price> <curr>PLN<curr>
						// 		</div>
						// 		<div class="buttons">
						// 			<span class="minus" onclick="MinusAddon(this)"> <i class="fas fa-minus"></i> </span>
						// 			<span class="quantity">0</span>
						// 			<span class="plus" onclick="PlusAddon(this)"> <i class="fas fa-plus"></i> </span>
						// 		</div>
						// 	</div>';
						// }

						$h .= '</div>
					</div>
				</div>

			</div>
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