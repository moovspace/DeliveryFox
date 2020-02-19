<?php
namespace MyApp\Web\Page\ProductList;

class ProductBox
{
	static function Show()
	{
		// Category
		$cat = 0;
		if(!empty($_GET['category'])){
			$cat = (int) $_GET['category'];
		}
		// Pagination
		$page = 1;
		if(!empty($_GET['page'])){
			$page = (int) $_GET['page'];
		}
		$perpage = 6;
		if(!empty($_GET['perpage'])){
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
						<div class="add-to-cart"> <span>ORDER</span> <i class="fas fa-chevron-right"></i> </div>
					</div>
					<div class="product">
						<div class="sale"> <i class="fas fa-grin-stars"></i> Sale! </div>
						<div class="img">
							<img src="/media/img/food-1.jpg">
						</div>
						<div class="name">Tortilla vege</div>
						<div class="price"><span>19.99</span> <curr>PLN</curr></div>
						<div class="add-to-cart"> <span>ORDER</span> <i class="fas fa-chevron-right"></i> </div>
					</div>
					<div class="product">
						<div class="sale"> <i class="fas fa-grin-stars"></i> Sale! </div>
						<div class="img">
							<img src="/media/img/food-2.jpg">
						</div>
						<div class="name">Spaghetti mushrom</div>
						<div class="price"><span>19.99</span> <curr>PLN</curr></div>
						<div class="add-to-cart"> <span>ORDER</span> <i class="fas fa-chevron-right"></i> </div>
					</div>

					<div class="product">
						<div class="img">
							<img src="/media/img/food-3.jpg">
						</div>
						<div class="name">Quasadilla</div>
						<div class="price"><span>19.99</span> <curr>PLN</curr></div>
						<div class="add-to-cart"> <span>ORDER</span> <i class="fas fa-chevron-right"></i> </div>
					</div>
					<div class="product">
						<div class="img">
							<img src="/media/img/food-4.jpg">
						</div>
						<div class="name">Kuleczki panierowane</div>
						<div class="price"><span>19.99</span> <curr>PLN</curr></div>
						<div class="add-to-cart"> <span>ORDER</span> <i class="fas fa-chevron-right"></i> </div>
					</div>
					<div class="product">
						<div class="img">
							<img src="/media/img/food-5.jpg">
						</div>
						<div class="name">Szaszłyki z kaczki</div>
						<div class="price"><span>19.99</span> <curr>PLN</curr></div>
						<div class="add-to-cart"> <span>ORDER</span> <i class="fas fa-chevron-right"></i> </div>
					</div>

				</div>

				<div class="product-pagine">
					<a href="?category='.$cat.'&perpage='.$perpage.'&page='.$back.'"> <i class="fas fa-chevron-left"></i> </a> <span id="product-curr-page"> '.$page.' </span> <a href="?category='.$cat.'&perpage='.$perpage.'&page='.$next.'"> <i class="fas fa-chevron-right"></i> </a>
				</div>

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
						<div class="size-btn"> Size 15cm </div>
						<div class="size-btn"> Size 25cm </div>
						<div class="size-btn"> Size 35cm </div>
						<select class="size-btn">
							<option>Sos łagodny</option>
						</select>
					</div>
					<h3>Addons</h3>
					<div class="addons">
						<div class="addon-btn"> Ananas <i class="fas fa-minus"></i> <span class="quantity">1</span> <i class="fas fa-plus"></i> </div>
						<div class="addon-btn"> Ser kozi <i class="fas fa-minus"></i> <span class="quantity">1</span> <i class="fas fa-plus"></i> </div>
						<div class="addon-btn"> Szynka <i class="fas fa-minus"></i> <span class="quantity">1</span> <i class="fas fa-plus"></i> </div>
						<div class="addon-btn"> Ananas <i class="fas fa-minus"></i> <span class="quantity">1</span> <i class="fas fa-plus"></i> </div>
						<div class="addon-btn"> Ser kozi <i class="fas fa-minus"></i> <span class="quantity">1</span> <i class="fas fa-plus"></i> </div>
						<div class="addon-btn"> Szynka <i class="fas fa-minus"></i> <span class="quantity">1</span> <i class="fas fa-plus"></i> </div>
						<div class="addon-btn"> Ananas <i class="fas fa-minus"></i> <span class="quantity">1</span> <i class="fas fa-plus"></i> </div>
						<div class="addon-btn"> Ser kozi <i class="fas fa-minus"></i> <span class="quantity">1</span> <i class="fas fa-plus"></i> </div>
						<div class="addon-btn"> Szynka <i class="fas fa-minus"></i> <span class="quantity">1</span> <i class="fas fa-plus"></i> </div>
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
}