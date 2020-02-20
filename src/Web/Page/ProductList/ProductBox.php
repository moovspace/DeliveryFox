<?php
namespace MyApp\Web\Page\ProductList;

class ProductBox
{
	static function Show()
	{
		// Url params
		$p = self::GetParams();
		// Category
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
		$perpage = 6;
		if(!empty($_GET['perpage']))
		{
			$perpage = (int) $_GET['perpage'];
		}
		if($perpage < 1) { $perpage = 6; }
		if($page < 1) { $page = 1; }
		$back = $page - 1;
		if($back < 1) { $back = 1; }
		$next = $page + 1;

		$h = '
			<div class="products">
				<div class="h1">Products > All</div>

				<div class="list">

					<div class="product">
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
						<div class="price"><span>19.99</span> <curr>PLN</curr></div>
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
					</div>

				</div>

				<!-- Pagination -->
				<div class="product-pagine">
					<a href="/category/'.$cat.'?perpage='.$perpage.'&page='.$back.'"> <i class="fas fa-chevron-left"></i> </a> <span id="product-curr-page"> '.$page.' </span> <a href="/category/'.$cat.'?perpage='.$perpage.'&page='.$next.'"> <i class="fas fa-chevron-right"></i> </a>
				</div>

				<!-- Add to cart popup -->
				<div id="black-hole">
					<div class="close-it" onclick="this.parentNode.style.display = \'none\';"> <i class="fas fa-times"></i> </div>
					<div id="add-product-fixed">
						<div class="top">
							<img src="/media/img/food-1.jpg">
							<div class="about">
								<div class="name"> Pizza hawajska z warzywami</div>
								<p class="desc">
								As a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using , making it look like readable English. And a search for will uncover many web sites still in their infancy.
								</p>
							</div>
							<div class="right">
								<div class="price"> 159.98 <curr>PLN</curr> </div>
								<div class="add-to-cart-now"> Add to cart </div>
							</div>
						</div>
						<div class="size">
							<div class="size-btn size-btn-active"> Size 15cm </div>
							<div class="size-btn"> Size 25cm </div>
							<div class="size-btn"> Size 35cm </div>
							<select class="size-btn">
								<option>Sos łagodny</option>
							</select>
						</div>
						<div class="addon-title">Addons</div>
						<div class="addons">';

						foreach(['','','','','','','','',''] as $v)
						{
							$h .= '<div class="addon-btn">
								<div class="title">
									<name>Ananas</name> <price>2.50</price> <curr>PLN<curr>
								</div>
								<div class="buttons">
									<span class="minus"> <i class="fas fa-minus"></i> </span>
									<span class="quantity">1</span>
									<span class="plus"> <i class="fas fa-plus"></i> </span>
								</div>
							</div>';
						}

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
}